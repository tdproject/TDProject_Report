<?php

/**
 * TDProject_Report_Common_ValueObjects_ReportData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Model/Interfaces/Value.php';
require_once 'TDProject/Report/Common/Helper/Format.php';
require_once 'TDProject/Report/Common/ValueObjects/ReportValue.php';

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
class TDProject_Report_Common_ValueObjects_ReportData 
    extends TDProject_Report_Common_ValueObjects_ReportValue 
    implements TechDivision_Model_Interfaces_Value {
    
    /**
     * The report data.
     * @var string
     */
    protected $_data = null;
    
    /**
     * The report format.
     * @var TDProject_Report_Common_Helper_Format
     */
    protected $_format = null;
        
    /**
     * Sets the report format.
     * 
     * @param TDProject_Report_Common_Helper_Format $format
     * 		The report format
     * @return void
     */
    public function setFormat(
        TDProject_Report_Common_Helper_Format $format) {
        $this->_format = $format;
    }
    
    /**
     * Returns the report's content type.
     * 
     * @return string
     * 		The report's content type
     */
    public function getContentType()
    {
        return $this->_format->getContentType();
    }
    
    /**
     * Returns the report filename.
	 *
	 * @return string The report's filename
     */
    public function getFilename()
    {
        return $this->getName() . '-' . date('YmdHis') . '.' . $this->_format->getFileSuffix();
    }
        
    /**
     * Sets the report data.
     * 
     * @param string $data The report data
     * @return void
     */
    public function setData($data) {
        $this->_data = $data;
    }
        
    /**
     * Returns the report data.
     * 
     * @return string The report data
     */
    public function getData()
    {
        return $this->_data;
    }
}