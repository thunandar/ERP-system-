<?php

namespace App\DBTransactions\Employee;

use App\Models\Employee;
use App\Classes\DBTransaction;

/**
 * Delete an employee data from the database.
 * 
 * @author Thu Nandar Aye Min
 * @create 22/06/2023
 */
class DeleteEmployee extends DBTransaction
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
     * Delete Employee's info
     * 
     * @author Thu Nandar Aye Min
     * @create 22/06/2023
     * @return array
     */
    public function process()
    {
        $id = $this->id;

        $employee = Employee::find($id);

        $deleteEmployee = $employee->forceDelete();


        if ($deleteEmployee) {
            return ['status' => true, 'error' => ''];
        } else {

            return ['status' => false, 'error' => ''];
        }
    }
}
