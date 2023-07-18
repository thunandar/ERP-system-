<?php

namespace App\Imports;

use App\Models\Employee;
use App\Exceptions\NoFieldException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Exceptions\RowLimitExceededException;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Import the employee data from an excel file to database.
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 26/06/2023
 *
 */
class ImportEmployee implements WithMultipleSheets, WithHeadingRow
{
    /**
     * Define sheets
     * 
     * @author Thu Nandar Aye Min
     * @created 26/06/2023
     * @param none
     * @return array
     */
    public function sheets(): array
    {
        return [
            0 => new EmployeeRegistrationSheet()
        ];
    }
}

/**
 * Import the employee data from an excel file to database.
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 26/06/2023
 *
 */
class EmployeeRegistrationSheet implements ToCollection
{
    /**
     * Collect the employee data to be imported.
     * 
     * @author Thu Nandar Aye Min
     * @created 26/06/2023
     * @param none
     * @return $validEmployees
     */
    public function collection(Collection $rows)
    {
        $validEmployees = [];
        $dataRows = $rows->slice(1);

        // Check if data is empty
        if ($dataRows->isEmpty()) {
            throw new NoFieldException('No data rows found in the Excel file.');
        }

        //check number of rows are greater than 100
        if ($dataRows->count() > 100) {
            throw new RowLimitExceededException('The number of rows exceeds or equals the allowed limit of 100.');
        }

        foreach ($dataRows as $row) {
            //Define rules
            $rules = [
                '0' => "required|max:50", //emp code
                '1' => 'required|max:50', //emp name
                '2' => 'required|regex:/^[a-zA-Z0-9\/()]+$/', //nrc
                '3' => 'required', //pwd
                '4' => 'required|email|max:255|unique:employees,email_address', //email
                '5' => 'nullable|integer:1,2', // gender
                '6' => 'required', //date
                '7' => 'nullable|integer:1,2,3', //marital status
                '8' => 'nullable|max:255' //addreess
            ];

            //Define error messages
            $messages = [
                '0.required' => 'Please enter an employee code.',
                '0.max' => 'The employee code must not exceed 50 characters.',
                '1.required' => 'Please enter an employee name.',
                '1.max' => 'The employee name must not exceed 50 characters.',
                '2.required' => 'Please enter a NRC number.',
                '2.regex' => 'Please enter a valid NRC number.',
                '3.required' => 'Please enter a password.',
                '4.required' => 'Please enter an email address',
                '4.max' => 'The email address must not exceed 255 characters.',
                '4.unique' => 'Please enter a unique email address.',
                '5.integer' => 'Please enter a valid integer for gender (1,2)',
                '6.required' => 'Please enter a date of birth',
                '7.integer' => 'Please enter a valid integer for marital status (1,2,3)',
                '8.max' => 'The address must not exceed 255 characters.',
            ];

            //Validate the data
            $validator = Validator::make($row->toArray(), $rules, $messages);

            //Check if validation fails
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            //Get the max employee id from datatbase
            $latestId = DB::table('employees')->max('employee_id');

            //Incrase latest id plus one or default 10001
            $newId = $latestId ? ($latestId + 1) : 10001;

            //Check all fields are not empty and at least 9 columns
            if (count($row) >= 9 && isset($row[0]) && isset($row[1]) && isset($row[2]) && isset($row[3]) && isset($row[4]) && isset($row[5]) && isset($row[6]) && isset($row[7]) && isset($row[8])) {
                $employee = new Employee();
                $employee->employee_id = $newId;
                $employee->employee_code = $row[0];
                $employee->employee_name = $row[1];
                $employee->nrc_number = $row[2];
                $employee->password = Hash::make($row[3]);
                $employee->email_address = $row[4];
                $employee->gender = $row[5];

                $employee->date_of_birth = Date::excelToDateTimeObject($row[6])->format('Y-m-d');
                $employee->marital_status = $row[7];

                $employee->address = $row[8];
                $employee->save();

                $validEmployees[] = $employee; // Return newly created employee object
                $newId++;
            }
        }
        return $validEmployees; // Return null if it's not valid data rows
    }
}

