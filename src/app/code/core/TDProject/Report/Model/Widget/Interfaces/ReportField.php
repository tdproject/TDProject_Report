<?php

/**
 * TDProject_Report_Model_Widget_Interfaces_ReportField
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Interface for the dynamic report fields necessary to handle
 * the user input to render a report.
 * 
 * @category   	TDProject
 * @package    	TDProject_Report
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Report_Model_Widget_Interfaces_ReportField
{

	/**
	 * Converts the value and replaces the original 
	 * in the parameter array.
	 * 
	 * @return TDProject_Report_Model_Widget_Interfaces_ReportField
	 * 		The report field instance
	 */
	public function convert();
	
	/**
	 * Returns the report field instance to handle
	 * the conversion for.
	 * 
	 * @return TDProject_Report_Model_Entities_ReportField The report field
	 */
	public function getReportField();
	
	/**
	 * The report fields parameter Map.
	 * 
	 * @return TechDivision_Collections_Interfaces_Map
	 * 		The Map with the fields parameters
	 */
	public function getParams();
	
	/**
	 * Returns the field name of the HTML input field.
	 * 
	 * @return TechDivision_Lang_String 
	 * 		The HTML input field name
	 */
	public function getOldKey();
	
	/**
	 * Returns the name of the JasperServer parameter
	 * necessary to print the report.
	 * 
	 * @return TechDivision_Lang_String
	 * 		The JasperServer report parameter name
	 */
	public function getNewKey();
	
	/**
	 * Returns the value of the report field instance 
	 * with the passed key.
	 * 
	 * @param TechDivision_Lang_String $key
	 * 		The key to return the value for
	 */
	public function getValue(TechDivision_Lang_String $key);
	
	/**
	 * Sets the passed value with the passed key in the report field.
	 * 
	 * @param TechDivision_Lang_String $key The key to set the passed value under
	 * @param TechDivision_Lang_Object $value The value to set
	 * @return TDProject_Report_Model_Widget_Interfaces_ReportField
	 * 		The report field instance
	 */
	public function setValue(
		TechDivision_Lang_String $key, 
		TechDivision_Lang_Object $value);
	
	/**
	 * Removes the value with the passed key from the
	 * report fields parameter Map.
	 * 
	 * @param TechDivision_Lang_String $key
	 * 		Key of the value to remove
	 */
	public function removeValue(TechDivision_Lang_String $key);
}