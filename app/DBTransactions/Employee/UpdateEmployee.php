<?php

namespace App\DBTransactions\Employee;

use App\Models\Employee;
use App\Classes\DBTransaction;

/**
 * Update an employee data to the database.
 * 
 * @author Thu Nandar Aye Min
 * @create 03/07/2023
 */
class UpdateEmployee extends DBTransaction
{
    private $request, $id, $employee;

    /**
     * Constructor to assign interface to variable
     */
    public function __construct($request, $id)
    {
        $this->request = $request;
        $this->id = $id;
    }
    
     /**
     * Update Employee's info to the database
     * 
     * @author Thu Nandar Aye Min
     * @create 03/07/2023
     * @return array
     */
    public function process()
    {
        $request = $this->request;
        $id = $this->id;

        $update = Employee::where("id", $id)->update(
            [
                "employee_id" => $request->employee_id,
                "employee_code" => $request->employee_code,
                "employee_name" => $request->employee_name,
                "nrc_number" => $request->nrc_number,
                "email_address" => $request->email_address,
                "gender" => $request->gender,
                "date_of_birth" => $request->date_of_birth,
                "marital_status" => $request->marital_status,
                "address" => $request->address,
            ]
        );

        if (!$update) {
            return ['status' => false, 'error' => 'Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}
