<?php

namespace App\DBTransactions\Employee;

use App\Models\Employee;
use App\Classes\DBTransaction;
use Illuminate\Support\Facades\Hash;

/**
 * Save an employee data to the database.
 * 
 * @author Thu Nandar Aye Min
 * @create 22/06/2023
 */
class SaveEmployee extends DBTransaction
{
    private $request;

    /**
     * Constructor to assign interface to variable
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Save Employee's info to the database
     * 
     * @author Thu Nandar Aye Min
     * @create 22/06/2023
     * @return array
     */
    public function process()
    {
        $request = $this->request;
        
        $employee = new Employee();
        $employee->employee_id = $request->employee_id;
        $employee->employee_code = $request->employee_code;
        $employee->employee_name = $request->employee_name;
        $employee->nrc_number = $request->nrc_number;
        $employee->password =Hash::make( $request->password);
        $employee->email_address = $request->email_address;
        $employee->gender = $request->gender;
        $employee->date_of_birth = $request->date_of_birth;
        $employee->marital_status = $request->marital_status;
        $employee->address = $request->address;
        $employee->save();
           
        if (!$employee) {
            return ['status' => false, 'error' => 'Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}
