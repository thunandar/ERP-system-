<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Manage the validatiion for the employee login form
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 21/06/2023
 *
 */
class EmployeeLoginRequest extends FormRequest
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
            "employee_id" => "required|integer|exists:employees,employee_id",
            "password" => 'required'
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Please enter an employee id.',
            'employee_id.integer' => 'Employee id must be an integer.',
            'employee_id.exists' => 'Please enter a correct employee id.',
            'password.required' => 'Please enter a password.',
        ];
    }

    
}
