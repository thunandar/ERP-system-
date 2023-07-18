<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeRegistrationController;
use App\Http\Controllers\LanguageChangeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('employees.login');
});

//User login
Route::get('/login', [EmployeeController::class, 'loginForm']);

//Check user login
Route::post('/check-validations', [EmployeeController::class, 'checkEmployeeLogin']);

// User Logout
Route::get('/logout', [EmployeeController::class, 'logout']);

Route::middleware(['lan', 'login'])->group(function () {
    //Show form when user clicks register
    Route::get('/show-forms', [EmployeeController::class, 'showRegistrationForm']);

    //Show excel Registration form
    Route::get('/excel-registrations', [EmployeeController::class, 'showExcelRegistration']);

    // Show employee list
    Route::get('/show-employees', [EmployeeController::class, 'getAllEmployees']);

    //Save employee to database
    Route::post('/save-employees', [EmployeeController::class, 'saveEmployee']);

    //Download excel employee registration file
    Route::get('/export-employees', [EmployeeRegistrationController::class, 'exportEmployee']);

    //Import excel registration file
    Route::post('/import-employees', [EmployeeRegistrationController::class, 'importEmployee']);

    //Edit an employee
    Route::get('/edit-employees/{id}', [EmployeeController::class, 'editEmployee']);

    //Update an employee
    Route::patch('/update-employees/{id}', [EmployeeController::class, 'updateEmployee']);

    //Show employee details
    Route::get('/employee-details/{id}', [EmployeeController::class, 'showEmployeeDetail']);

    //Deleting an employee
    Route::delete('/delete-employees/{id}', [EmployeeController::class, 'deleteEmployee']);

    //Soft delete active to inactive
    Route::delete('/delete-active-employees/{id}', [EmployeeController::class, 'activeEmployee']);

    //Soft delete inactive to active
    Route::patch('/restore-employees/{id}', [EmployeeController::class, 'restoreEmployee']);

    //Search Employee
    Route::get('/search-employees', [EmployeeController::class, 'searchEmployee']);

    //Download search result in excel format
    Route::get('/export-search-employees', [EmployeeController::class, 'exportSearchResults']);

    //Download serach result in pdf format
    Route::get('/pdf-download-employees', [EmployeeController::class, 'generateSearchResults']);
});

//Language Change 
Route::post('/languages', [LanguageChangeController::class, 'changeLanguage']);
