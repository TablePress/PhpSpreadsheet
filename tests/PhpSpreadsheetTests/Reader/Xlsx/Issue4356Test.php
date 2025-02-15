<?php

declare(strict_types=1);

namespace PhpOffice\PhpSpreadsheetTests\Reader\Xlsx;

use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheetTests\Functional\AbstractFunctional;

class Issue4356Test extends AbstractFunctional
{
    public function testIssue4356(): void
    {
        // Reader couldn't handle sheet title with apostrophe for defined name
        $originalSpreadsheet = new Spreadsheet();
        $originalSheet = $originalSpreadsheet->getActiveSheet();
        $originalSheet->setTitle("Goodn't sheet name");
        $originalSpreadsheet->addNamedRange(
            new NamedRange('CELLNAME', $originalSheet, '$A$1')
        );
        $originalSheet->setCellValue('A1', 'This is a named cell.');
        $originalSheet->getStyle('A1')->getFont()->setItalic(true);
        $spreadsheet = $this->writeAndReload($originalSpreadsheet, 'Xlsx');
        $originalSpreadsheet->disconnectWorksheets();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('C1', '=CELLNAME');
        self::assertSame('This is a named cell.', $sheet->getCell('C1')->getCalculatedValue());
        $namedRange2 = $spreadsheet->getNamedRange('CELLNAME');
        self::assertNotNull($namedRange2);
        $sheetx = $namedRange2->getWorksheet();
        self::assertNotNull($sheetx);
        $style = $sheetx->getStyle($namedRange2->getRange());
        self::assertTrue($style->getFont()->getItalic());
        $style->getFont()->setItalic(false);

        $spreadsheet->disconnectWorksheets();
    }
}
