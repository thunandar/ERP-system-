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
 * Manage the employee gender exporting to an excel file.
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 23/06/2023
 *
 */
class ExportEmployeeGender implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    private $headings = [
        'Gender List',
    ];

    /**
     * Collect the employee gender data.
     * 
     * @author Thu Nandar Aye Min
     * @created 23/06/2023
     * @param none
     * @return an empty collection
     */
    public function collection()
    {
        return collect([
            ['ID', 'Gender Name'],
            [1, 'Male'],
            [2, 'Female']
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
        return 'Gender';
    }

    /**
     * Define font size, border, background color and alignment
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
            'A3:B4' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '008000'], // pink
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
