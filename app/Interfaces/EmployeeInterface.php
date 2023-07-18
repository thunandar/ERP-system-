<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface EmployeeInterface
{
    /**
     * Get all employee data from the database. 
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param none
     * @return all employees
     */
    public function getAllEmployees();

    /**
     * Get an employee data from the database by the specified ID. 
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param $id
     * @return $id
     */
    public function getEmployeeById($id);

    /**
     * Get an employee data from the database by the specified employee ID. 
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param Request $request
     * @return employee
     */
    public function getEmployeeByEmployeeId(Request $request);
    
    /**
     * Get the max employee id from the datatbase
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param none
     * @return id
     */
    public function getLatestEmployeeID();

    /**
     * Get all employee number from the database. 
     * 
     * @author Thu Nandar Aye Min
     * @created 22/06/2023
     * @param none
     * @return array
     */
    public function getAllEmployeesCount();

    /**
     * Get all employees data from the database by the specified input search without pagination.
     * 
     * @author Thu Nandar Aye Min
     * @created 24/06/2023
     * @param Request $request
     * @returnarray
     */
    public function getAllEmployeesBySearch(Request $request);
    
    /**
     * Get all employees data from the database by the specified input search. 
     * 
     * @author Thu Nandar Aye Min
     * @created 24/06/2023
     * @param Request $request
     * @return object
     */
    public function getEmployeeBySearch(Request $request);

    /**
     * Get all employees data from the database by the specified input search with pagination
     * 
     * @author Thu Nandar Aye Min
     * @created 12/07/2023
     * @param Request $request
     * @return object
     */
    public function getEmployeeBySearchWithPagination(Request $request, $page);

}