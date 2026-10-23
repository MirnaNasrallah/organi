<?php

declare(strict_types=1);

namespace App\Modules\Identity\Tests\Feature;

use App\Modules\Identity\IdentityServiceProvider;
use App\Modules\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

use function str_repeat;

final class AuthTest extends TestCase
{
    use RefreshDatabase;

    private const string PASSWORD = 'correct horse battery';

    private const string EMAIL = 'salma@example.com';

    #[Test]
    public function signing_up_returns_a_token_that_works(): void
    {
        $token = $this->tokenFrom($this->postJson('/api/v1/auth/register', [
            'name' => 'Salma',
            'email' => '  Salma@Example.COM ',
            'password' => self::PASSWORD,
            'device_name' => 'iPhone',
        ])
            ->assertCreated()
            ->assertJsonPath('data.token_type', 'Bearer')
            ->assertJsonPath('data.user.email', self::EMAIL)
            ->json('data.token'));

        $this->withToken($token)->getJson('/api/v1/me')
            ->assertOk()
            ->assertExactJson(['data' => ['id' => User::sole()->id, 'name' => 'Salma', 'email' => self::EMAIL]]);
    }

    #[Test]
    public function the_password_is_only_stored_hashed(): void
    {
        $this->postJson('/api/v1/auth/register', ['name' => 'Salma', 'email' => self::EMAIL, 'password' => self::PASSWORD, 'device_name' => 'iPhone'])
            ->assertCreated();

        $stored = User::sole()->password;
        $this->assertNotSame(self::PASSWORD, $stored);
        $this->assertTrue(Hash::check(self::PASSWORD, $stored));
    }

    #[Test]
    public function an_email_can_only_sign_up_once_whatever_its_case(): void
    {
        User::factory()->create(['email' => self::EMAIL]);

        $this->postJson('/api/v1/auth/register', ['name' => 'Salma', 'email' => 'SALMA@example.com', 'password' => self::PASSWORD, 'device_name' => 'iPhone'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function a_password_needs_a_minimum_length(): void
    {
        $this->postJson('/api/v1/auth/register', [
            'name' => 'Salma',
            'email' => self::EMAIL,
            'password' => str_repeat('a', IdentityServiceProvider::PASSWORD_MIN_LENGTH - 1),
            'device_name' => 'iPhone',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['password']);
    }

    #[Test]
    public function signing_in_ignores_the_case_and_spacing_of_the_email(): void
    {
        User::factory()->create(['email' => self::EMAIL, 'password' => self::PASSWORD]);

        $token = $this->tokenFrom($this->postJson('/api/v1/auth/login', ['email' => ' SALMA@Example.com ', 'password' => self::PASSWORD, 'device_name' => 'iPhone'])
            ->assertOk()
            ->json('data.token'));

        $this->withToken($token)->getJson('/api/v1/me')->assertOk();
    }

    #[Test]
    public function a_wrong_password_and_an_unknown_email_get_the_same_answer(): void
    {
        User::factory()->create(['email' => self::EMAIL, 'password' => self::PASSWORD]);

        $wrongPassword = $this->postJson('/api/v1/auth/login', ['email' => self::EMAIL, 'password' => 'not it at all', 'device_name' => 'iPhone']);
        $unknownEmail = $this->postJson('/api/v1/auth/login', ['email' => 'nobody@example.com', 'password' => self::PASSWORD, 'device_name' => 'iPhone']);

        $wrongPassword->assertUnprocessable()->assertJsonValidationErrors(['email']);
        $unknownEmail->assertUnprocessable();
        $this->assertSame($wrongPassword->json('errors'), $unknownEmail->json('errors'));
    }

    #[Test]
    public function signing_out_revokes_only_this_device(): void
    {
        User::factory()->create(['email' => self::EMAIL, 'password' => self::PASSWORD]);
        $phone = $this->signIn('iPhone');
        $tablet = $this->signIn('iPad');

        $this->withToken($phone)->postJson('/api/v1/auth/logout')->assertNoContent();
        $this->app['auth']->forgetGuards();

        $this->withToken($phone)->getJson('/api/v1/me')->assertUnauthorized();
        $this->withToken($tablet)->getJson('/api/v1/me')->assertOk();
    }

    #[Test]
    public function the_current_user_needs_a_token(): void
    {
        $this->getJson('/api/v1/me')->assertUnauthorized();
        $this->withToken('not-a-real-token')->getJson('/api/v1/me')->assertUnauthorized();
    }

    #[Test]
    public function tokens_expire_after_90_days(): void
    {
        User::factory()->create(['email' => self::EMAIL, 'password' => self::PASSWORD]);
        $token = $this->signIn('iPhone');

        $this->travel(89)->days();
        $this->withToken($token)->getJson('/api/v1/me')->assertOk();

        $this->travel(2)->days();
        $this->app['auth']->forgetGuards();
        $this->withToken($token)->getJson('/api/v1/me')->assertUnauthorized();
    }

    #[Test]
    public function signing_in_is_rate_limited(): void
    {
        User::factory()->create(['email' => self::EMAIL, 'password' => self::PASSWORD]);
        $attempt = ['email' => self::EMAIL, 'password' => 'guess', 'device_name' => 'iPhone'];

        for ($i = 0; $i < IdentityServiceProvider::AUTH_ATTEMPTS_PER_MINUTE; $i++) {
            $this->postJson('/api/v1/auth/login', $attempt)->assertUnprocessable();
        }

        $this->postJson('/api/v1/auth/login', $attempt)->assertTooManyRequests();
    }

    private function signIn(string $device): string
    {
        return $this->tokenFrom($this->postJson('/api/v1/auth/login', ['email' => self::EMAIL, 'password' => self::PASSWORD, 'device_name' => $device])
            ->assertOk()
            ->json('data.token'));
    }

    private function tokenFrom(mixed $token): string
    {
        $this->assertIsString($token);

        return $token;
    }
}
