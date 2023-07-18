<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\Employee;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportSearchEmployee;
use App\Interfaces\EmployeeInterface;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\EditEmployeeRequest;
use App\Http\Requests\EmployeeLoginRequest;
use App\Interfaces\EmployeeUploadInterface;
use App\DBTransactions\Employee\SaveEmployee;
use App\DBTransactions\Employee\DeleteEmployee;
use App\DBTransactions\Employee\UpdateEmployee;
use App\DBTransactions\EmployeeUpload\SaveEmployeeUpload;
use App\DBTransactions\EmployeeUpload\DeleteEmployeeUpload;
use App\DBTransactions\EmployeeUpload\UpdateEmployeeUpload;

/**
 * Manage the employees data
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 21/06/2023
 *
 */
class EmployeeController extends Controller
{
    use ResponseAPI;

    protected $employeeInterface, $employeeUploadInterface;

    /**
     * Constructor to assign interface to variable
     */
    public function __construct(EmployeeInterface $employeeInterface, EmployeeUploadInterface $employeeUploadInterface)
    {
        $this->employeeInterface = $employeeInterface;
        $this->employeeUploadInterface = $employeeUploadInterface;
    }

    /**
     * Display the login form for employees.
     * 
     * @author Thu Nandar Aye Min
     * @created 21/06/2023
     * @param none
     * @return view
     */
    public function loginForm()
    {
        return view('/employees.login');
    }

    /**
     * Validate employee login credentials and redirect to the employee list page if successful.
     * 
     * @author Thu Nandar Aye Min
     * @created 21/06/2023
     * @param EmployeeLoginRequest $request
     * @return redirect
     */
    public function checkEmployeeLogin(EmployeeLoginRequest $request)
    {
        $employee = $this->employeeInterface->getEmployeeByEmployeeId($request);

        if ($employee) {
            if (Hash::check($request->password, $employee->password)) {
                session()->put('employee', $employee); //store the login employee in a session

                return redirect('/show-employees');
            } else {
                return redirect()->back()->withErrors(['password' => 'Please enter an correct password.']);
            }
        } 
    }

    /**
     * Log out an employee by deleting the session and redirect to the login page.
     * 
     * @author Thu Nandar Aye Min
     * @created 21/06/2023
     * @param none
     * @return redirect
     */
    public function logout()
    {
        session()->forget('employee');
        session()->forget('prevUrl');

        return redirect('/login');
    }

    /**
     * Display the normal registration form for employees.
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param none
     * @return view
     */
    public function showRegistrationForm()
    {
        $newId = $this->employeeInterface->getLatestEmployeeID();

        return view('employees.register', compact('newId'));
    }

    /**
     * Display the excel registration form for employees.
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param none
     * @return view
     */
    public function showExcelRegistration()
    {
        return view('employees.excelRegister');
    }

    /**
     * Get all employee data from the database and display them in the index view 
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param Request $request
     * @return view
     */
    public function getAllEmployees(Request $request)
    {
        $employees = $this->employeeInterface->getAllEmployees();
        $employeeCount = $this->employeeInterface->getAllEmployeesCount();

        //check current page is greater than last page
        if ($employees->currentPage() > $employees->lastPage()) {
            $page = $employees->lastPage(); //assign the value of last page number to page

            $employees = $this->employeeInterface->getEmployeeBySearchWithPagination($request, $page);
        }

        return view('employees.index', compact('employees', 'employeeCount'));
    }

    /**
     * Save the employee data from the incoming request to the database.
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param EmployeeRequest $request
     * @return redirect
     */
    public function saveEmployee(EmployeeRequest $request)
    {
        $save = new SaveEmployee($request);
        $saveUpload = new SaveEmployeeUpload($request);

        $save = $save->executeProcess();
        $saveUpload = $saveUpload->executeProcess();

        return redirect()->back()->with('success', 'Save Successfully.');
    }

    /**
     *  Display the form to edit an employee's information.
     * 
     * @author Thu Nandar Aye Min
     * @created 03/07/2023
     * @param $id
     * @return view
     */
    public function editEmployee(Request $request, $id)
    {      
        //check previous url and current url is different
        if (url()->previous() !== url()->current()) {
            Session::put('prevUrl' . $id, url()->previous()); //store the previous url with incomimg id in a session
        }

        $prevUrl = Session::get('prevUrl' . $id);   
               
        $employee = $this->employeeInterface->getEmployeeById($id);

        if (!$employee || $employee->deleted_at !== null) {
            return redirect()->to($prevUrl)->with('error', 'Unable to edit an employee information.');
        }

        $employeeUpload = $this->employeeUploadInterface->getEmployeeUploadByEmployeeId($id);

        return view('employees.edit', compact('employee', 'employeeUpload'));
    }

    /**
     * Update an employee's information in the database.
     * 
     * @author Thu Nandar Aye Min
     * @created 03/07/2023
     * @param EditEmployeeRequest $request, $id
     * @return redirect
     */
    public function updateEmployee(EditEmployeeRequest $request, $id)
    {
        $prevUrl = Session::get('prevUrl' . $id); //get previous url with incoming id from session
       
        $employee = $this->employeeInterface->getEmployeeById($id);

        if (!$employee || $employee->deleted_at !== null) {
            return redirect()->to($prevUrl)->with('error', 'Unable to update an employee information.');
        }

        $employeeUpload = $this->employeeUploadInterface->getEmployeeUploadByEmployeeId($id);

        if (!$employeeUpload) {
            $saveUpload = new SaveEmployeeUpload($request);
            $saveUpload = $saveUpload->executeProcess();
        }

        $updateEmployee = new UpdateEmployee($request, $id, $employee);
        $updateEmployee->executeProcess();

        $updateEmployeeUpload = new UpdateEmployeeUpload($request, $id);
        $updateEmployeeUpload->executeProcess();

        return redirect()->to($prevUrl)->with('success', 'Employee updated successfully.');
    }

    /**
     * Display the detailed information of an employee.
     * 
     * @author Thu Nandar Aye Min
     * @created 30/06/2023
     * @param $id
     * @return view
     */
    public function showEmployeeDetail($id)
    {
        $employee = $this->employeeInterface->getEmployeeById($id);

        if (!$employee) {
            return redirect()->back()->with('error', 'Unable to view detail page');
        }

        $employee = $this->employeeInterface->getEmployeeById($id);
        $employeeUpload = $this->employeeUploadInterface->getEmployeeUploadByEmployeeId($id);

        return view('employees.detail', compact('employee', 'employeeUpload'));
    }

    /**
     *  Deletes an employee's information from the database.
     * 
     * @author Thu Nandar Aye Min
     * @created 02/07/2023
     * @param $id
     * @return redirect
     */
    public function deleteEmployee($id)
    {
        $employee = $this->employeeInterface->getEmployeeById($id);

        if (!$employee) {
            return redirect()->back()->with('error', 'Already deleted an employee.');
        }

        $employeeLogin = session()->get('employee'); //get the login employee from session

        //check login employee id is same with employee id
        if ($employeeLogin->employee_id == $employee->employee_id) {
            return redirect()->back()->with('error', 'You cannot delete your login employee.');
        }

        if ($employee->deleted_at !== null) {
            return redirect()->back()->with('error', 'Unable to delete an employee.');
        }

        $deleteEmployeeUpload = new DeleteEmployeeUpload($id);
        $deleteEmployee = new DeleteEmployee($id);

        $deleteEmployeeUpload->executeProcess();
        $deleteEmployee->executeProcess();

        return redirect()->back()->with('success', 'Employee deleted successfully.');
    }

    /**
     * Change an employee's state to inactive (soft delete)
     * 
     * @author Thu Nandar Aye Min
     * @created 28/06/2023
     * @param $id
     * @return redirect
     *  */
    public function activeEmployee($id)
    {
        $employee = $this->employeeInterface->getEmployeeById($id);

        if (!$employee) {
            return redirect()->back()->with('error', 'Unable to change Inactive state.');
        }

        $employeeLogin = session()->get('employee'); //get the login employee from session

        //check login employee id is same with employee id
        if ($employeeLogin->employee_id == $employee->employee_id) {
            return redirect()->back()->with('error', 'You cannot change to InActive state of your login employee.');
        }

        if ($employee->deleted_at == null) {
            $employee->delete();
            return redirect()->back()->with('success', 'Changed to Inactive state successfully.');
        } else {
            return redirect()->back()->with('error', 'Already Changed to InActivated state.');
        }
    }

    /**
     *  Restores an inactive employee to the active state.
     * 
     * @author Thu Nandar Aye Min
     * @created 28/06/2023
     * @param $id
     * @return redirect
     *  */
    public function restoreEmployee($id)
    {
        $employee = Employee::withTrashed()->find($id);

        if ($employee->deleted_at !== null) {
            $employee->restore();
            return redirect()->back()->with('success', 'Changed to Active state successfully');
        } else {
            return redirect()->back()->with('error', 'Already Change to Activated state.');
        }
    }

    /**
     * Search an employee's information based on the request parameters and displays the results.    
     * 
     * @author Thu Nandar Aye Min
     * @created 26/06/2023
     * @param Request $request
     * @return view
     */
    public function searchEmployee(Request $request)
    {
        $employees = $this->employeeInterface->getEmployeeBySearch($request);
        $employeeCount = $this->employeeInterface->getAllEmployeesCount();

         //check current page is greater than last page
        if ($employees->currentPage() > $employees->lastPage()) {
            $page = $employees->lastPage(); //assign the value of last page number to page

            $employees = $this->employeeInterface->getEmployeeBySearchWithPagination($request, $page);
        }

        return view('employees.index', compact('employees', 'employeeCount'));
    }

    /**
     * Download search results of employee's information to an excel format.
     * 
     * @author Thu Nandar Aye Min
     * @created 26/06/2023
     * @param Request $request
     * @return employee-lists.xlsx
     */
    public function exportSearchResults(Request $request)
    {
        $employees = $this->employeeInterface->getAllEmployeesBySearch($request);

        $exportData = new ExportSearchEmployee($employees);

        return Excel::download($exportData, 'employee-lists.xlsx');
    }

    /**
     * Download a search result of employee's information to an pdf format.
     * 
     * @author Thu Nandar Aye Min
     * @created 30/06/2023
     * @param Request $request
     * @return employee-lists.pdf
     */
    public function generateSearchResults(Request $request)
    {
        $employees = $this->employeeInterface->getAllEmployeesBySearch($request);

        $html = view('employees.downloadpdf', compact('employees'))->render();

        $mpdf = new Mpdf(["format" => "A4"]);
        $mpdf->WriteHTML($html);
        $filename = 'employee-lists.pdf';
        $mpdf->Output($filename, 'D');
    }
}
