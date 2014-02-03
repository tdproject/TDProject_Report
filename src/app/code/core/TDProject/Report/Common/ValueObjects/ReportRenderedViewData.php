<?php

/**
 * TDProject_Report_Common_ValueObjects_ReportRenderedViewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * This class is the data transfer object between the model and the 
 * controller for the report handling for the reports rendered.
 *
 * @category   	TDProject
 * @package     TDProject_Report
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Common_ValueObjects_ReportRenderedViewData 
    extends TDProject_Report_Common_ValueObjects_ReportRenderedLightValue
    implements TechDivision_Model_Interfaces_Value {
    
    /**
     * The content type.
     * @var TechDivision_Lang_String
     */
    protected $_contentType = null;
    
    /**
     * The URL to download the rendered report.
     * @var TechDivision_Lang_String
     */
    protected $_downloadUrl = null;
    
    /**
     * The constructor intializes the DTO with the
     * values passed as parameter.
     *
     * @param TDProject_Report_Common_ValueObjects_ReportRenderedLightValue $lvo
     * 		The data to initialize the DTO with
     * @return void
     */
    public function __construct(
        TDProject_Report_Common_ValueObjects_ReportRenderedLightValue $lvo)
    {
        // call the parents constructor
        parent::__construct($lvo);
        // initialize the member variables
        $this->_contentType = new TechDivision_Lang_String();
        $this->_downloadUrl = new TechDivision_Lang_String();
    }
    
    /**
     * Sets the content type.
     * 
     * @param TechDivision_Lang_String $contentType
     */
    public function setContentType(TechDivision_Lang_String $contentType)
    {
        $this->_contentType = $contentType;
    }
    
    /**
     * Retruns the content type.
     * 
     * @return TechDivision_Lang_String The content type
     */
    public function getContentType()
    {
        return $this->_contentType;
    }
    
    /**
     * Sets the URL to download the rendered report.
     * 
     * @param TechDivision_Lang_String $downloadUrl
     */
    public function setDownloadUrl(TechDivision_Lang_String $downloadUrl)
    {
        $this->_downloadUrl = $downloadUrl;
    }
    
    /**
     * Retruns the URL to download the rendered report.
     * 
     * @return TechDivision_Lang_String The URL to download the rendered report
     */
    public function getDownloadUrl()
    {
        return $this->_downloadUrl;
    }
}