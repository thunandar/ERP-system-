<?php

namespace App\DBTransactions\EmployeeUpload;

use App\Models\Employee;
use App\Classes\DBTransaction;
use App\Models\EmployeeUpload;
use Illuminate\Support\Facades\File;

/**
 * Delete an employee image from the database.
 * 
 * @author Thu Nandar Aye Min
 * @create 22/06/2023
 */
class DeleteEmployeeUpload extends DBTransaction
{
    private $id;

     /**
     * Constructor to assign interface to variable
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Delete Employee's image from the database
     * 
     * @author Thu Nandar Aye Min
     * @create 22/06/2023
     * @return array
     */
    public function process()
    {
        $id = $this->id;

        $employee = Employee::withTrashed()->find($id);

        $employeeUpload = EmployeeUpload::where('employee_id', $employee->employee_id)->first();
        if ($employeeUpload) {
            $fileName = $employeeUpload->file_name;
            $filePath = public_path('images/' . $fileName);

            if (File::exists($filePath)) {
                File::delete($filePath);

                $delete = $employeeUpload->delete();
            }

            if ($delete) {
                return ['status' => true, 'error' => ''];
            } else {
                return ['status' => false, 'error' => ''];
            }
        }
    }
}
