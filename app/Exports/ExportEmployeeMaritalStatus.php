<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Manage the employee marital status exporting to an excel file
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 23/06/2023
 *
 */
class ExportEmployeeMaritalStatus implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    private $headings = [
        'Marital Status List',
    ];

    /**
     * Collect the employee marital status
     * 
     * @author Thu Nandar Aye Min
     * @created 23/06/2023
     * @param none
     * @return an collection
     */
    public function collection()
    {
        return collect([
            ['ID', 'Marital Status'],
            [1, 'Single'],
            [2, 'Married'],
            [3, 'Divorce']
        ]);
    }

    /**
     * Define header
     * 
     * @author Thu Nandar Aye Min
     * @created 23/06/2023
     * @param none
     * @return array
     */
    public function headings(): array
    {
        return $this->headings;
    }

    /**
     * Define title
     * 
     * @author Thu Nandar Aye Min
     * @created 23/06/2023
     * @param none
     * @return string
     */
    public function title(): string
    {
        return 'Marital Status';
    }

    /**
     * Define font size, border, background color and alignment.
     * 
     * @author Thu Nandar Aye Min
     * @created 23/06/2023
     * @param Worksheet $sheete
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getDefaultColumnDimension()->setWidth(20);

        return [
            1 => [
                'font' => ['bold' => true],
            ],
            'A2:B2' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '00FF00'], // green
                    ],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '08D0F7'], // blue
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            'A3:B5' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '008000'], // green
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}
