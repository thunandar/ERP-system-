<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Manage the validatiion for editing theemployee registration form
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 21/06/2023
 *
 */
class EditEmployeeRequest extends FormRequest
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
        $employeeId = $this->route('id');
        $rules = [
            'employee_code' => 'required|max:50',
            'employee_name' => 'required|max:50',
            'nrc_number' => 'required|regex:/^[a-zA-Z0-9\/()]+$/',
            'date_of_birth' => 'required|date_format:Y-m-d|before_or_equal:today',
            'email_address' => 'required|email|max:255|unique:employees,email_address,'. $employeeId,
            'photo' => 'mimes:jpeg,png,jpg,gif|max:10485760', // 10MB
            'address' => 'max:255'
        ];
        return $rules;
    }

    /**
     * Define error messages.
     * 
     * @author Thu Nandar Aye Min
     * @created 03/07/2023
     * @param none
     * @return array
     */
    public function messages()
    {
        return [
            'employee_code.required' => 'Please enter an employee code.',
            'employee_code.max' => 'The employee code must not exceed 50 characters.',
            'employee_name.required' => 'Please enter an employee name.',
            'employee_name.max' => 'The employee name must not exceed 50 characters.',
            'nrc_number.required' => 'Please enter a nrc number.',
            'nrc_number.regex' => 'The NRC number is invalid.',
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
