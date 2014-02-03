<?php

/**
 * TDProject_Report_Common_ValueObjects_ProjectViewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TechDivision/Collections/ArrayList.php';
require_once 'TechDivision/Model/Interfaces/Value.php';
require_once 'TDProject/Project/Model/Entities/Project.php';
require_once 'TDProject/Project/Common/ValueObjects/ProjectValue.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the report handling 
 * for the project reports.
 *
 * Each class member reflects a database field and
 * the values of the related dataset.
 *
 * @category   	TDProject
 * @package     TDProject_Project
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Common_ValueObjects_ReportViewData 
    extends TDProject_Report_Common_ValueObjects_ReportData
    implements TechDivision_Model_Interfaces_Value {
    
    /**
     * The entry-fields
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_fields = null;
    
    /**
     * The constructor intializes the DTO with the
     * values passed as parameter.
     *
     * @param TDProject_Report_Common_ValueObjects_ReportValue $reportValue 
     * 		The project to initialize the DTO with
     * @return void
     */
    public function __construct(
        TDProject_Report_Common_ValueObjects_ReportValue $reportValue)
    {
        // call the parents constructor
        parent::__construct($reportValue);
        // initialize the ValueObject with the passed data
        $this->_fields = new TechDivision_Collections_ArrayList();
    }
    
    /**
     * Sets the entry-fields.
     * @param TechDivision_Collections_Interfaces_Collection $fields
     */
    public function setFields(
        TechDivision_Collections_Interfaces_Collection $fields)
    {
        $this->_fields = $fields;
    }
    
    /**
     * Retruns the entry-fields.
     * @return TechDivision_Collections_Interfaces_Collection
     */
    public function getFields()
    {
        return $this->_fields;
    }
}