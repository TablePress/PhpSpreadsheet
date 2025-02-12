<?php

declare(strict_types=1);

namespace PhpOffice\PhpSpreadsheetTests\Calculation\Functions\Statistical;

use PhpOffice\PhpSpreadsheet\Calculation\Calculation;

class NegBinomDistTest extends AllSetupTeardown
{
    #[\PHPUnit\Framework\Attributes\DataProvider('providerNEGBINOMDIST')]
    public function testNEGBINOMDIST(mixed $expectedResult, mixed ...$args): void
    {
        $this->runTestCases('NEGBINOMDIST', $expectedResult, ...$args);
    }

    public static function providerNEGBINOMDIST(): array
    {
        return require 'tests/data/Calculation/Statistical/NEGBINOMDIST.php';
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('providerNegBinomDistArray')]
    public function testNegBinomDistArray(
        array $expectedResult,
        string $failures,
        string $successes,
        string $probabilities
    ): void {
        $calculation = Calculation::getInstance();

        $formula = "=NEGBINOMDIST({$failures}, {$successes}, {$probabilities})";
        $result = $calculation->_calculateFormulaValue($formula);
        self::assertEqualsWithDelta($expectedResult, $result, 1.0e-14);
    }

    public static function providerNegBinomDistArray(): array
    {
        return [
            'row/column vectors' => [
                [[0.07508468627929688, 0.04301726818084717], [0.04503981303423643, 0.05629976629279554]],
                '{7; 12}',
                '{3, 5}',
                '0.25',
            ],
        ];
    }
}
