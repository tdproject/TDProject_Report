<?php

/**
 * TDProject_Report_Model_Widget_Interfaces_Converter
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Interface for all converters that transforms user input values
 * in a representation, ready for JasperServer report generation.
 * 
 * @category   	TDProject
 * @package    	TDProject_Report
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Report_Model_Widget_Interfaces_Converter
{
	
    /**
     * Returns the user input of the passed report field for 
     * usage as a JasperServer SOAP parameter.
     * 
     * @param TDProject_Report_Model_Widget_Interfaces_ReportField $reportField The report field instance
     * @return void
     */
    public function convert(
    	TDProject_Report_Model_Widget_Interfaces_ReportField $reportField);
}