<?php

/**
 * TDProject_Report_Common_ValueObjects_ReportFieldData
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
 * @copyright  	Copyright (c) 2011 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Markus Berwanger <m.berwanger@techdivision.com>
 */
class TDProject_Report_Common_ValueObjects_ReportFieldData
    extends TDProject_Report_Common_ValueObjects_ReportFieldClassLightValue
    implements TechDivision_Model_Interfaces_Value {
    
    /**
     * Holds the name of the appropriate entry-field
     * @var TechDivision_Lang_String
     */
    protected $_name = null;
    
    /**
    * Holds the stored collection of data
    * @var TechDivision_Collections_Interfaces_Collection
    */
    protected $_data;
    
    /**
     * The constructor intializes the DTO with the
     * values passed as parameter.
     *
     * @param TDProject_Project_Model_Entities_Project $lvo
     * @return void
     */
    public function __construct(
        TDProject_Report_Common_ValueObjects_ReportFieldClassLightValue $lvo)
    {
        // call the parents constructor
        parent::__construct($lvo);
    }

    /**
     * Sets the name for the entry-field
     * @param TechDivision_Lang_String $name
     * @return void
     */
    public function setName(TechDivision_Lang_String $name)
    {
        $this->_name = $name;
    }
    
    /**
     * Returns the name of the entry-field.
     * @return TechDivision_Lang_String
     */
    public function getName()
    {
        return $this->_name;
        
    }
    
    /**
    * Sets the collection of stored data
    * @param TechDivision_Collections_Interfaces_Collection
    * @return void
    */
    public function setData($data)
    {
        $this->_data = $data;
    }
    
    /**
     * Returns the collection of stored data
     * @param void
     * @return TechDivision_Collections_Interfaces_Collection
     */
    public function getData()
    {
        return $this->_data;
    }
}