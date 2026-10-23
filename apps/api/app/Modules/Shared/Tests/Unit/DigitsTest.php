<?php

declare(strict_types=1);

namespace App\Modules\Shared\Tests\Unit;

use App\Modules\Shared\Digits;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Digits::class)]
final class DigitsTest extends TestCase
{
    /**
     * @return iterable<string, array{string, string}>
     */
    public static function typedNumbers(): iterable
    {
        yield 'Arabic-Indic digits' => ['٧٠', '70'];
        yield 'Extended Arabic-Indic digits' => ['۱۶۵', '165'];
        yield 'the Arabic decimal separator' => ['٦٢٫٥', '62.5'];
        yield 'Western digits stay as they are' => ['80.5', '80.5'];
        yield 'mixed text keeps everything else' => ['وزن ٨٠ kg', 'وزن 80 kg'];
    }

    #[Test]
    #[DataProvider('typedNumbers')]
    public function it_converts_to_western_digits(string $typed, string $expected): void
    {
        $this->assertSame($expected, Digits::toWestern($typed));
    }
}
