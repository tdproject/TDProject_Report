<?php

/**
 * TDProject_Report_Model_Widget_Converter_DateToMilliseconds
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package    	TDProject_Report
 * @copyright  	Copyright (c) 2011 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Model_Widget_Converter_DateToMilliseconds
    implements TDProject_Report_Model_Widget_Interfaces_Converter
{
	
	/**
	 * Default constructor to avoid ReflectionException.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		// nothing to do	
	}
	
    /**
     * Sets the passed value converted in an integer that represents 
     * the date as milliseconds since 01/01/1970.
     * 
     * @param TDProject_Report_Model_Widget_Interfaces_ReportField $reportField The report field instance
     * @see TDProject_Report_Model_Widget_Interfaces_Converter::convert()
     */
    public function convert(
    	TDProject_Report_Model_Widget_Interfaces_ReportField $reportField)
    {
    	// load the old/new keys from the passed report field
    	$oldKey = $reportField->getOldKey();
    	$newKey = $reportField->getNewKey();
    	// create a new Zend_Date instance of the passed value 
    	$date = new Zend_Date($reportField->getValue($oldKey));
    	// create the millisecond value and return it as Integer
    	$value = new TechDivision_Lang_Integer($date->getTimestamp() * 1000);
        // convert the passed value and return it
        $reportField->removeValue($oldKey)->setValue($newKey, $value);
    }
}