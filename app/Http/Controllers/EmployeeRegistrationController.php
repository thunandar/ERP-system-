<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ImportEmployee;
use App\Exceptions\NoFieldException;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Exports\ExportEmployeeMultipleSheet;
use App\Exceptions\RowLimitExceededException;
use Illuminate\Validation\ValidationException;

/**
 * Manage the employees excel registration format
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 23/06/2023
 *
 */
class EmployeeRegistrationController extends Controller
{
    /**
     * Export the employee data to excel format.
     * 
     * @author Thu Nandar Aye Min
     * @created 23/06/2023
     * @param none
     * @return EmployeeRegistration.xlsx
     */
    public function exportEmployee()
    {
        return Excel::download(new ExportEmployeeMultipleSheet, 'employee-registration.xlsx');
    }

    /**
     * Import the employee data from excel and handle the errors.
     * 
     * @author Thu Nandar Aye Min
     * @created 23/06/2023
     * @param Request $request
     * @return redirect
     */
    public function importEmployee(Request $request)
    {
        $file = $request->file('excel_upload');

        // Check if a file was uploaded
        if (!$file) {
            return redirect()->back()->withErrors(['No file uploaded'])->with('NoFileError', true);
        }

        // Check the file format
        $extension = $file->getClientOriginalExtension();
        $allowedFormats = ['xls', 'xlsx'];

        if (!in_array($extension, $allowedFormats)) {
            return redirect()->back()->withErrors(['Invalid file format. Only Excel files (xls, xlsx) are allowed.'])->with('allowedFormatError', true);
        }

        try {
            Excel::import(new ImportEmployee, $request->excel_upload);
            Session::flash("success", "Save Successfully.");

            return redirect()->back();
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->with('importError', true);
        } catch (RowLimitExceededException $e) {
            return redirect()->back()->withErrors([$e->getMessage()])->with('rowLimitError', true);
        } catch (NoFieldException $e) {
            return redirect()->back()->withErrors([$e->getMessage()])->with('NoFieldError', true);
        }
    }
}
