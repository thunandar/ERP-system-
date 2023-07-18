<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Manage the validatiion for the employee registration form
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 21/06/2023
 *
 */
class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_id' => 'unique:employees,employee_id',
            'employee_code' => 'required|max:50',
            'employee_name' => 'required|max:50',
            'nrc_number' => 'required|regex:/^[a-zA-Z0-9\/()]+$/',
            'password' => 'required|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9]).{4,8}$/',
            'email_address' => 'required|email|unique:employees,email_address|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d|before_or_equal:today',
            'photo' => 'mimes:jpeg,png,jpg,gif|max:10485760', // 10MB
            'address' => 'max:255'
        ];
    }

    /**
     * Define error messages.
     * 
     * @author Thu Nandar Aye Min
     * @created 21/06/2023
     * @param none
     * @return array
     */
    public function messages()
    {
        return [
            'employee_id.unique' => "The employee id has already been taken.",
            'employee_code.required' => 'Please enter an employee code.',
            'employee_code.max' => 'The employee code must not exceed 50 characters.',
            'employee_name.required' => 'Please enter an employee name.',
            'employee_name.max' => 'The employee name must not exceed 50 characters.',
            'nrc_number.required' => 'Please enter a nrc number.',
            'nrc_number.regex' => 'The NRC number is invalid.',
            'password.required' => 'Please enter a password',
            'email_address.required' => 'Please enter an email address.',
            'email_address.unique' => 'The email address has already been taken.',
            'email_address.max' => 'The email address must not exceed 255 characters.',
            'date_of_birth.required' => 'Please choose date of birth.',
            'date_of_birth.before_or_equal' => 'Please enter a date before or equal to today.',
            'photo.mimes' => 'The file must be a file of type: jpeg, png, jpg, gif.',
            'photo.max' => 'The file size must not exceed 10 megabytes.',
            'address.max' => 'The address must not exceed 255 characters.',
        ];
    }
}
