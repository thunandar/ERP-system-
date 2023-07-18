<?php

namespace App\DBTransactions\EmployeeUpload;

use App\Classes\DBTransaction;
use App\Models\EmployeeUpload;

/**
 * Save an employee image and related data to the database.
 * 
 * @author Thu Nandar Aye Min
 * @create 22/06/2023
 */
class SaveEmployeeUpload extends DBTransaction
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
     * Save Employee's image to the database
     * 
     * @author Thu Nandar Aye Min
     * @create 22/06/2023
     * @return array
     */
    public function process()
    {
        $request = $this->request;
           
        $employeeUpload = new EmployeeUpload();
        
        if ($image = $request->file('photo')) {
            $employeeUpload->file_size = $image->getSize();

            $destinationPath = public_path('images'); // Set the destination path to the public/images folder
            $profileImage = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);

            $employeeUpload->employee_id = $request->employee_id;
            $employeeUpload->file_name = $profileImage;
            $employeeUpload->file_path = $destinationPath;
            
            $employeeUpload->file_extension = $image->getClientOriginalExtension();
            $employeeUpload->save();
        } 

        if (!$employeeUpload) {
            return ['status' => false, 'error' => 'Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}
