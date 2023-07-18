<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Manage the employee upload database
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 21/06/2023
 *
 */
class EmployeeUpload extends Model
{
    protected $fillable = ['file_size'];
}
