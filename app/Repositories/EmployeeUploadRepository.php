<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Models\EmployeeUpload;
use App\Interfaces\EmployeeUploadInterface;

/**
 * Implements the EmployeeUploadInterface and provides methods to interact with the database.
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 22/06/2023
 *
 */
class EmployeeUploadRepository implements EmployeeUploadInterface
{
    /**
     * Retrieve all employee uploads records from the database. 
     * 
     * @author Thu Nandar Aye Min
     * @created 22/6/2023
     * @param none
     * @return all employees
     */
    public function getAllEmployeeUploads()
    {
        return EmployeeUpload::all();
    }

     /**
     * Retrieve an employee image record from the database based on the specified ID. 
     * 
     * @author Thu Nandar Aye Min
     * @created 22/6/2023
     * @param $id
     * @return $id
     */
    public function getEmployeeUploadById($id) 
    {
        return EmployeeUpload::find($id);
    }

    /**
     * Retrieve an employee record from the database based on the specified employee ID. 
     * 
     * @author Thu Nandar Aye Min
     * @created 22/6/2023
     * @param $id
     * @return $id
     */
    public function getEmployeeUploadByEmployeeId($id)
    {
        $employee = Employee::withTrashed()->find($id);

       return EmployeeUpload::where("employee_id", $employee->employee_id)->first();       
    }
}
