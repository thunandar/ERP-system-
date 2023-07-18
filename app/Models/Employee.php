<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Manage the employee database
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 21/06/2023
 *
 */
class Employee extends Model
{
    protected $guarded = [];
    use SoftDeletes;
}
