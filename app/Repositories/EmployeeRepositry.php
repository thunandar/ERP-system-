<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\EmployeeInterface;

/**
 * Manage the EmployeeInterface to interact with the database.
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 22/06/2023
 *
 */
class EmployeeRepositry implements EmployeeInterface
{
    /**
     * Get all employee data from the database. 
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param none
     * @return all employees
     */
    public function getAllEmployees()
    {
        $employee = Employee::withTrashed()->paginate(20);
        return $employee;
    }

    /**
     * Get an employee data from the database by the specified ID. 
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param $id
     * @return $id
     */
    public function getEmployeeById($id)
    {
        return Employee::withTrashed()->find($id);
    }

    /**
     * Get an employee data from the database by the specified employee ID. 
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param Request $request
     * @return employee
     */
    public function getEmployeeByEmployeeId(Request $request)
    {
        return Employee::where("employee_id", $request->employee_id)->first();
    }

    /**
     * Get the max employee id from the datatbase
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param none
     * @return id
     */
    public function getLatestEmployeeID()
    {
        $latestId = DB::table('employees')->max('employee_id');

        return $latestId ? ($latestId + 1) : 10001;
    }

    /**
     * Get all employee number from the database. 
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param none
     * @return array
     */
    public function getAllEmployeesCount()
    {
        $employee = Employee::withTrashed()->count();
        return $employee;
    }

    /**
     * Get all employees data from the database by the specified input search without pagination.
     * 
     * @author Thu Nandar Aye Min
     * @created 24/06/2023
     * @param Request $request
     * @return array
     */
    public function getAllEmployeesBySearch(Request $request)
    {
        $employee = Employee::query();

        //check the input field is not empty and return the matching value with the entered value 
        if ($request->filled('employee_id')) {
            $employee->where('employee_id', 'LIKE', '%' . $request->input('employee_id') . '%');
        }

        if ($request->filled('employee_code')) {
            $employee->where('employee_code', 'LIKE', '%' . $request->input('employee_code') . '%');
        }

        if ($request->filled('employee_name')) {
            $employee->where('employee_name', 'LIKE', '%' . $request->input('employee_name') . '%');
        }

        if ($request->filled('email_address')) {
            $employee->where('email_address', 'LIKE', '%' . $request->input('email_address') . '%');
        }

        return $employee->withTrashed()->get();
    }

    /**
     * Get all employees data from the database by the specified input search. 
     * 
     * @author Thu Nandar Aye Min
     * @created 24/06/2023
     * @param Request $request
     * @return object
     */
    public function getEmployeeBySearch(Request $request)
    {
        $employee = Employee::query();

        //check the input field is not empty and return the matching value with the entered value
        if ($request->filled('employee_id')) {
            $employee->where('employee_id', 'LIKE', '%' . $request->input('employee_id') . '%');
        }

        if ($request->filled('employee_code')) {
            $employee->where('employee_code', 'LIKE', '%' . $request->input('employee_code') . '%');
        }

        if ($request->filled('employee_name')) {
            $employee->where('employee_name', 'LIKE', '%' . $request->input('employee_name') . '%');
        }

        if ($request->filled('email_address')) {
            $employee->where('email_address', 'LIKE', '%' . $request->input('email_address') . '%');
        }

        $employees = $employee->withTrashed()->paginate(20);

        return $employees->appends([
            'employeeId' => $request->employeeId,
            'employeeCode' => $request->employeeCode,
            'employeeName' => $request->employeeName,
            'email' => $request->email,
        ]);
    }

    /**
     * Get all employees data from the database by the specified input search with pagination
     * 
     * @author Thu Nandar Aye Min
     * @created 12/07/2023
     * @param Request $request
     * @return object
     */
    public function getEmployeeBySearchWithPagination(Request $request, $page)
    {
        $employee = Employee::query();

        //check the input field is not empty and return the matching value with the entered value
        if ($request->filled('employee_id')) { 
            $employee->where('employee_id', 'LIKE', '%' . $request->input('employee_id') . '%');
        }

        if ($request->filled('employee_code')) {
            $employee->where('employee_code', 'LIKE', '%' . $request->input('employee_code') . '%');
        }

        if ($request->filled('employee_name')) {
            $employee->where('employee_name', 'LIKE', '%' . $request->input('employee_name') . '%');
        }

        if ($request->filled('email_address')) {
            $employee->where('email_address', 'LIKE', '%' . $request->input('email_address') . '%');
        }

        $employees = $employee->withTrashed()->paginate(20, ['*'], 'page', $page);

        return $employees->appends([
            'employeeId' => $request->employeeId,
            'employeeCode' => $request->employeeCode,
            'employeeName' => $request->employeeName,
            'email' => $request->email,
        ]);
    }
}
