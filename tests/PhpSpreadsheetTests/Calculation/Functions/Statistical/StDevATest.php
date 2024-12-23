<?php

declare(strict_types=1);

namespace PhpOffice\PhpSpreadsheetTests\Calculation\Functions\Statistical;

class StDevATest extends AllSetupTeardown
{
    #[\PHPUnit\Framework\Attributes\DataProvider('providerSTDEVA')]
    public function testSTDEVA(mixed $expectedResult, mixed ...$args): void
    {
        $this->runTestCaseReference('STDEVA', $expectedResult, ...$args);
    }

    public static function providerSTDEVA(): array
    {
        return require 'tests/data/Calculation/Statistical/STDEVA.php';
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('providerOdsSTDEVA')]
    public function testOdsSTDEVA(mixed $expectedResult, mixed ...$args): void
    {
        $this->setOpenOffice();
        $this->runTestCaseReference('STDEVA', $expectedResult, ...$args);
    }

    public static function providerOdsSTDEVA(): array
    {
        return require 'tests/data/Calculation/Statistical/STDEVA_ODS.php';
    }
}
