<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface EmployeeUploadInterface
{
    public function getAllEmployeeUploads();

    public function getEmployeeUploadById($id);

    public function getEmployeeUploadByEmployeeId($id);
}