<?php

declare(strict_types=1);

namespace PhpOffice\PhpSpreadsheetTests\Calculation\Functions\MathTrig;

use PhpOffice\PhpSpreadsheet\Calculation\Calculation;

class ArabicTest extends AllSetupTeardown
{
    #[\PHPUnit\Framework\Attributes\DataProvider('providerARABIC')]
    public function testARABIC(mixed $expectedResult, string $romanNumeral): void
    {
        $this->mightHaveException($expectedResult);
        $sheet = $this->getSheet();
        $sheet->getCell('A1')->setValue($romanNumeral);
        $sheet->getCell('B1')->setValue('=ARABIC(A1)');
        $result = $sheet->getCell('B1')->getCalculatedValue();
        self::assertSame($expectedResult, $result);
    }

    public static function providerARABIC(): array
    {
        return require 'tests/data/Calculation/MathTrig/ARABIC.php';
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('providerArabicArray')]
    public function testArabicArray(array $expectedResult, string $array): void
    {
        $calculation = Calculation::getInstance();

        $formula = "=ARABIC({$array})";
        $result = $calculation->_calculateFormulaValue($formula);
        self::assertEqualsWithDelta($expectedResult, $result, 1.0e-14);
    }

    public static function providerArabicArray(): array
    {
        return [
            'row vector' => [[[49, 2022, 499]], '{"XLIX", "MMXXII", "VDIV"}'],
            'column vector' => [[[49], [2022], [499]], '{"XLIX"; "MMXXII"; "VDIV"}'],
            'matrix' => [[[49, 2022], [-499, 499]], '{"XLIX", "MMXXII"; "-ID", "VDIV"}'],
        ];
    }
}
