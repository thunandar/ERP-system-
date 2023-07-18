<?php

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create( [
            'employee_id' => '10001',
            'employee_code' => '001',
            'employee_name' => 'Thu Thu',
            'nrc_number' => '9/KhaMaSa(N)086473',
            'password' => Hash::make('123456'),
            'email_address' => 'mtk@gmail.com',
            'gender' => '1',
            'date_of_birth' => '2001/6/22',
            'marital_status' => '1',
            'address' => 'Yangon',
        ]); 
    }
}
