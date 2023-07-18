<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Manage the employee exporting to an excel file.
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 23/06/2023
 *
 */
class ExportSearchEmployee implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $employees;

    /**
     * Constructor to assign interface to variable
     */
    public function __construct(Collection $employees)
    {
        $this->employees = $employees;
    }

    /**
     * Collect the employee data to be exported.
     * 
     * @author Thu Nandar Aye Min
     * @created 23/06/2023
     * @param none
     * @return array
     */
    public function collection()
    {
        $employees = collect($this->employees);
        return $employees->map(function ($employee) {
            $gender = $employee->gender;
            $maritalStatus = $employee->marital_status;

            if ($gender == 1) {
                $gender = 'Male';
            } elseif ($gender == 2) {
                $gender = 'Female';
            }

            if ($maritalStatus == 1) {
                $maritalStatus = 'Single';
            } elseif ($maritalStatus == 2) {
                $maritalStatus = 'Married';
            } elseif ($maritalStatus == 3) {
                $maritalStatus = 'Divorce';
            }

            return [
                'Employee ID' => $employee->employee_id,
                'Employee Code' => $employee->employee_code,
                'Employee Name' => $employee->employee_name,
                'Email Address' => $employee->email_address,
                'Gender' => $gender,
                'Date of Birth' => $employee->date_of_birth,
                'Marital Status' => $maritalStatus,
                'Address' => $employee->address,

            ];
        });
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
        return 'Employee Lists';
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
        return ['Employee ID', 'Employee Code', 'Employee Name', 'Email Address', 'Gender', 'Date of Birth', 'Marital Status', 'Address'];
    }

    /**
     * Define style
     * 
     * @author Thu Nandar Aye Min
     * @created 23/06/2023
     * @param none
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);

        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H' . ($this->employees->count() + 1))->getAlignment()->setHorizontal('center');

        $sheet->getStyle('H')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A:H')->getAlignment()->setVertical('center');

    }
}
