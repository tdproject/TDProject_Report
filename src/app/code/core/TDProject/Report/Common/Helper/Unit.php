<?php

/**
 * TDProject_Report_Common_Helper_Unit
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package     TDProject_Report
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */

class TDProject_Report_Common_Helper_Unit
{
    /**
     * The key for the task overview report unit.
     * @var string
     */
    const TASK_OVERVIEW = '/reports/tdproject/task_overview';
    
    const EMPLOYEE_TIME = '/reports/tdproject/employee_time';
    
    const EMPLOYEE_TIME_SINGLE = '/reports/tdproject/employee_time_single';
    
    const PROJECT_TASK = '/reports/tdproject/project_task';
    
    const PROJECT_TASK_1 = '/reports/tdproject/project_task_1';
    
    const ALL_ACCOUNTS = '/reports/samples/AllAccounts';
    
    
	
    /**
     * The report unit name.
     * @var string
     */
	protected $_unit = '';
	
	/**
	 * Array with all available report units.
	 * @var array
	 */
	protected $_units = array(
	    TDProject_Report_Common_Helper_Unit::TASK_OVERVIEW,
	    TDProject_Report_Common_Helper_Unit::EMPLOYEE_TIME,
	    TDProject_Report_Common_Helper_Unit::EMPLOYEE_TIME_SINGLE,
	    TDProject_Report_Common_Helper_Unit::PROJECT_TASK,
	    TDProject_Report_Common_Helper_Unit::PROJECT_TASK_1,
	    TDProject_Report_Common_Helper_Unit::ALL_ACCOUNTS
	);
	
	/**
	 * Private constructor for marking
	 * the class as utiltiy.
	 *
	 * @return void
	 */
	protected function __construct(TechDivision_Lang_String $unit) 
	{
	    if ($unit->length() === 0) {
    	    throw new Exception("No unit requested");
	    } else {
    	    if (!in_array($unit->__toString(), $this->_units)) {
    	        throw new Exception("Invalid unit '$unit' requested");
    	    }
	    
            $this->_unit = $unit->__toString();
	    }
	}
	
	/**
	 * Factory method for creating a new report Unit.
	 * 
	 * @param string $unit The reports unit name
	 * @return TDProject_Report_Common_Helper_Unit
	 * 		The Unit instance
	 */
	public static function create(
	    $unit = TDProject_Report_Common_Helper_Unit::TASK_OVERVIEW) {
	    return new TDProject_Report_Common_Helper_Unit(
	        new TechDivision_Lang_String($unit)
	    );
	}
	
	/**
	 * Returns the report's unit name as string.
	 * 
	 * @return string The unit name
	 */
	public function __toString()
	{
	    return $this->_unit;
	}
}