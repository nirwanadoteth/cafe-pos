<?php

declare(strict_types=1);

namespace Tests\Unit\Casts;

use App\Casts\MoneyCast;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MoneyCastTest extends TestCase
{
    #[DataProvider('setProvider')]
    public function test_set_rounds_to_integer_cents(float $input, float $expected): void
    {
        $cast = new MoneyCast;
        $result = $cast->set(model: null, key: 'amount', value: $input, attributes: []);
        $this->assertSame($expected, $result);
    }

    public static function setProvider(): array
    {
        return [
            'exact cents' => [12.34, 1234.0],
            'round up' => [12.345, 1235.0],
            'round down' => [12.344, 1234.0],
            'large' => [12345.67, 1234567.0],
            'zero' => [0.0, 0.0],
            'tiny below half-cent' => [0.004, 0.0],
            'half-cent up' => [0.005, 1.0],
            'negative tiny above zero' => [-0.004, 0.0],
            'negative half-cent down' => [-0.005, -1.0],
            'negative with thirds' => [-12.345, -1235.0],
        ];
    }

    #[DataProvider('getProvider')]
    public function test_get_divides_by_100_and_rounds(float $stored, float $expected): void
    {
        $cast = new MoneyCast;
        $result = $cast->get(model: null, key: 'amount', value: $stored, attributes: []);
        $this->assertSame($expected, $result);
    }

    public static function getProvider(): array
    {
        return [
            'exact cents' => [1234.0, 12.34],
            'with fractions' => [1234.56, 12.35],
            'large' => [1234567.0, 12345.67],
            'zero' => [0.0, 0.0],
            'one cent' => [1.0, 0.01],
            'negative one cent' => [-1.0, -0.01],
            'half up' => [1234.5, 12.35],
            'negative half up' => [-1234.5, -12.35],
        ];
    }
}
