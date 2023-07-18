<?php

namespace App\DBTransactions\EmployeeUpload;

use App\Models\Employee;
use App\Classes\DBTransaction;
use App\Models\EmployeeUpload;
use Illuminate\Support\Facades\File;

/**
 * Update an employee image to the database.
 * 
 * @author Thu Nandar Aye Min
 * @create 22/06/2023
 */
class UpdateEmployeeUpload extends DBTransaction
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
     * Update Employee's image from the database
     * 
     * @author Thu Nandar Aye Min
     * @create 22/06/2023
     * @return array
     */
    public function process()
    {
        $request = $this->request;
        $id = $this->id;

        $employee = Employee::withTrashed()->find($id);
        $employeeUpload =  EmployeeUpload::where("employee_id", $employee->employee_id)->first();

        if ($image = $request->file('photo')) {
            $destinationPath = public_path('images');
            $profileImage = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $fileExtension = $image->getClientOriginalExtension();
            $fileSize = $image->getSize();
            $image->move($destinationPath, $profileImage);
        }
        
        //if previous image exists, delete the image
        if ($employeeUpload && isset($profileImage)) {
            $fileName = $employeeUpload->file_name;
            $filePath = public_path('images/' . $fileName);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            
            $update = EmployeeUpload::where("employee_id", $employee->employee_id)->update([
                "file_name" => $profileImage,
                "file_path" => $destinationPath,
                "file_size" => $fileSize,
                "file_extension" => $fileExtension,
            ]);
        } else {
            $newEmp = new EmployeeUpload();
            $newEmp->employee_id = $employee->employee_id;
            $newEmp->file_name = $profileImage;
            $newEmp->file_path = $destinationPath;
            $newEmp->file_size = $fileSize;
            $newEmp->file_extension = $image->getClientOriginalExtension();
            $newEmp->save();
            $image->move($destinationPath, $profileImage);
        }
        
        if (!$update) {
            return ['status' => false, 'error' => 'Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}
