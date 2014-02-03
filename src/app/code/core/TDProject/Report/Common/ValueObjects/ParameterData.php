<?php

/**
 * TDProject_Report_Common_ValueObjects_ParameterData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Model/Interfaces/LightValue.php';
require_once 'TDProject/Report/Common/Helper/Format.php';
require_once 'TDProject/Report/Common/Helper/Unit.php';
require_once 'TDProject/Report/Common/ValueObjects/ReportLightValue.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the report renderer.
 *
 * @category   	TDProject
 * @package     TDProject_Report
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Common_ValueObjects_ParameterData 
    extends TDProject_Report_Common_ValueObjects_ReportLightValue 
    implements TechDivision_Model_Interfaces_LightValue {
    
    /**
     * The report params.
     * @var array
     */
    protected $_params = array();
    
    /**
     * The report format.
     * @var TDProject_Report_Common_Helper_Format
     */
    protected $_format = '';
    
    /**
     * The ID of the user that renders the report.
     * @var TechDivision_Lang_String
     */
    protected $_userId = null;
        
    /**
     * Sets the report format.
     * 
     * @param string $data The report format
     * @return void
     */
    public function setFormat(
        TDProject_Report_Common_Helper_Format $format) {
        $this->_format = $format;
    }
        
    /**
     * Returns the report format.
     * 
     * @return TDProject_Report_Common_Helper_Format 
     * 		The preview format
     */
    public function getFormat() 
    {
        return $this->_format;
    }
        
    /**
     * Sets the report unit.
     * 
     * @param TechDivision_Lang_String $data The report unit
     * @return void
     */
    public function setUnit(
        TechDivision_Lang_String $unit) {
        $this->_unit = $unit;
    }
        
    /**
     * Returns the report unit.
     * 
     * @return TechDivision_Lang_String
     * 		The report unit
     */
    public function getUnit() 
    {
        return $this->_unit;
    }
        
    /**
     * Sets the report params.
     * 
     * @param array $data The report params
     * @return void
     */
    public function setParams(array $params = null) 
    {
        if (is_array($params)) {
            $this->_params = $params;
        }
    }
        
    /**
     * Returns the report params.
     * 
     * @return array The report params
     */
    public function getParams()
    {
        return $this->_params;
    }
        
    /**
     * Sets the ID of the user that renders the report.
     * 
     * @param TechDivision_Lang_Integer $userId 
     * 		The ID of the user that renders the report
     * @return void
     */
    public function setUserId(TechDivision_Lang_Integer $userId) 
    {
        $this->_userId = $userId;
    }
        
    /**
     * Returns the ID of the user that renders the report.
     * 
     * @return TechDivision_Lang_Integer The ID of the user that renders the report
     */
    public function getUserId()
    {
        return $this->_userId;
    }
}