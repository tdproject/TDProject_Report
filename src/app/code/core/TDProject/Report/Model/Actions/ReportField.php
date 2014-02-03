<?php

/**
 * TDProject_Report_Model_Actions_ReportField
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
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Model_Actions_ReportField
    extends TDProject_Core_Model_Actions_Abstract {

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_Report_Model_Actions_ReportField($container);
    }
    
    /**
     * Save/Update the report field with the given values.
     * 
     * @param TDProject_Report_Common_ValueObjects_ReportFieldLightValue $lvo
     * @return TechDivision_Lang_Integer The ID of the saved/updated report field
     */
    public function saveReportField(
        TDProject_Report_Common_ValueObjects_ReportFieldLightValue $lvo)
    {
        // look up report field ID
        $reportFieldId = $lvo->getReportFieldId();
        // load the report field class (to set the type)
        $reportFieldClass = TDProject_Report_Model_Utils_ReportFieldClassUtil::getHome($this->getContainer())
        	->findByPrimaryKey($lvo->getReportFieldClassIdFk());
        // store the report field
        if ($reportFieldId->equals(new TechDivision_Lang_Integer(0))) {
            // create a new report field
            $reportField = TDProject_Report_Model_Utils_ReportFieldUtil::getHome($this->getContainer())
                ->epbCreate();
            // set the data
            $reportField->setReportIdFk($lvo->getReportIdFk());
            $reportField->setName($lvo->getName());
            $reportField->setParameterName($lvo->getParameterName());
            $reportField->setReportFieldClassType($reportFieldClass->getType());
            $reportField->setReportFieldClassIdFk($lvo->getReportFieldClassIdFk());
            $reportFieldId = $reportField->create();
        } else {
            // update the report field
            $reportField = TDProject_Report_Model_Utils_ReportFieldUtil::getHome($this->getContainer())
                ->findByPrimaryKey($reportFieldId);
            $reportField->setReportIdFk($lvo->getReportIdFk());
            $reportField->setName($lvo->getName());
            $reportField->setParameterName($lvo->getParameterName());
            $reportField->setReportFieldClassType($reportFieldClass->getType());
            $reportField->setReportFieldClassIdFk($lvo->getReportFieldClassIdFk());
            $reportField->update();
        }
        return $reportFieldId;
    }
}