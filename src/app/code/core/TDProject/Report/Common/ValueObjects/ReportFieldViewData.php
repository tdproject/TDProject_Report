<?php

/**
 * TDProject_Report_Common_ValueObjects_ReportFieldViewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * This class is the data transfer object between the
 * model and the controller for the report handling 
 * for the project reports.
 *
 * Each class member reflects a database field and
 * the values of the related dataset.
 *
 * @category   	TDProject
 * @package     TDProject_Report
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Common_ValueObjects_ReportFieldViewData 
    extends TDProject_Report_Common_ValueObjects_ReportFieldValue
    implements TechDivision_Model_Interfaces_Value
{
    
    /**
     * The available report field classes.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_reportFieldClasses = null;
    
    /**
     * The constructor intializes the DTO with the
     * values passed as parameter.
     *
     * @param TDProject_Report_Common_ValueObjects_ReportFieldValue $vo
     * 		The report field to initialize the DTO with
     * @return void
     */
    public function __construct(
        TDProject_Report_Common_ValueObjects_ReportFieldValue $vo)
    {
        // call the parents constructor
        parent::__construct($vo);
        // initialize the ValueObject with the passed data
        $this->setReportFieldClasses(new TechDivision_Collections_ArrayList());
    }
    
    /**
     * Sets the available report field classes.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $reportFieldClasses
     * 		 The available report field classes
     * @return void
     */
    public function setReportFieldClasses(
        TechDivision_Collections_Interfaces_Collection $reportFieldClasses)
    {
        $this->_reportFieldClasses = $reportFieldClasses;
    }
    
    /**
     * Retruns the available report field classes.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The  available report field classes
     */
    public function getReportFieldClasses()
    {
        return $this->_reportFieldClasses;
    }
}