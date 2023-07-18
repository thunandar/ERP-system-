<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Manage the employee data exporting to an excel file with multiple sheets
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 23/06/2023
 *
 */
class ExportEmployeeMultipleSheet implements WithMultipleSheets
{
    /**
     * Get an array of sheet to be exported for employee.
     * 
     * @author Thu Nandar Aye Min
     * @created 23/06/2023
     * @param none
     * @return an array
     */
    public function sheets(): array
    {
        return [
            'Employee Registration' => new ExportEmployee(),
            'Gender' => new ExportEmployeeGender(),
            'Marital Status' => new ExportEmployeeMaritalStatus(),
        ];
    }
}
