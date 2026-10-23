<?php

declare(strict_types=1);

namespace App\Modules\Shared\Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

use function config;

final class StatusTest extends TestCase
{
    #[Test]
    public function it_answers_in_the_default_locale_without_an_accept_language_header(): void
    {
        // Symfony's test requests send "Accept-Language: en-us" unless told otherwise.
        $this->getJson('/api/v1/status', ['Accept-Language' => ''])
            ->assertOk()
            ->assertExactJson(['data' => ['status' => 'ok', 'locale' => 'en']])
            ->assertHeader('Content-Language', 'en');
    }

    #[Test]
    public function it_falls_back_to_whichever_locale_is_configured_as_default(): void
    {
        config(['app.locale' => 'ar']);

        $this->getJson('/api/v1/status', ['Accept-Language' => 'fr-FR'])
            ->assertJsonPath('data.locale', 'ar');
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function acceptLanguageHeaders(): iterable
    {
        yield 'Egyptian Arabic' => ['ar-EG', 'ar'];
        yield 'US English' => ['en-US,en;q=0.9', 'en'];
        yield 'Arabic weighted above English' => ['en;q=0.5,ar-EG;q=0.9', 'ar'];
        yield 'English weighted above Arabic' => ['ar;q=0.4,en-GB;q=0.8', 'en'];
        yield 'unsupported language falls back to the default' => ['fr-FR', 'en'];
    }

    #[Test]
    #[DataProvider('acceptLanguageHeaders')]
    public function it_negotiates_the_locale_from_accept_language(string $header, string $expected): void
    {
        $this->getJson('/api/v1/status', ['Accept-Language' => $header])
            ->assertOk()
            ->assertJsonPath('data.locale', $expected)
            ->assertHeader('Content-Language', $expected);
    }

    #[Test]
    public function it_tells_caches_that_responses_vary_by_language(): void
    {
        $response = $this->getJson('/api/v1/status');

        $this->assertContains('Accept-Language', $response->baseResponse->getVary());
    }
}
