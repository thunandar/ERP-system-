<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Manage the employee exporting to an excel file.
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 23/06/2023
 *
 */
class ExportEmployee implements FromCollection, WithHeadings, WithStyles, WithEvents, WithTitle
{
    private $headings = [
        'Employee Code',
        'Employee Name',
        'NRC Number',
        'Password',
        'Email Address',
        'Gender',
        'Date of Birth',
        'Marital Status',
        'Address',
    ];

    /**
     * Collect the employee data to be exported.
     * 
     * @author Thu Nandar Aye Min
     * @created 23/06/2023
     * @param none
     * @return an empty collection
     */
    public function collection()
    {
        return new Collection();
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
        return 'Employee Registration';
    }

    /**
     * Define font size
     * 
     * @author Thu Nandar Aye Min
     * @created 23/06/2023
     * @param Worksheet $sheete
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            'A1:I1' => ['font' => ['size' => 12]],
        ];
    }

    /**
     * Define style
     * 
     * @author Thu Nandar Aye Min
     * @created 23/06/2023
     * @param none
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDefaultColumnDimension()->setWidth(20);

                $event->sheet->getStyle('A1:I1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FF0000'], //red
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '08D0F7'],  //blue
                    ],
                ]);

                $event->sheet->getStyle('F1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '000000'], //black
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '08D0F7'], //blue
                    ],
                ]);

                $event->sheet->getStyle('G1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FF0000'], //red
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '08D0F7'], //blue
                    ],
                ]);

                $event->sheet->getStyle('H1:I1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '000000'], //black
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '08D0F7'], //blue
                    ],
                ]);
            },
        ];
    }
}
