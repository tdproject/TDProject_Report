<?php

/**
 * TDProject_Report_Model_Assembler_ReportField
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
class TDProject_Report_Model_Assembler_ReportField
    extends TDProject_Core_Model_Assembler_Abstract {

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_Report_Model_Assembler_ReportField($container);
    }
        
    /**
     * Returns a DTO with the data of the report field
     * with the passed ID.
     * 
     * @param TechDivision_Lang_Integer $reportFieldId
     * 		The report field ID to return the DTO for
     * @return TDProject_Report_Common_ValueObjects_ReportFieldViewData
     * 		The requested DTO
     */
    public function getReportFieldViewData(
        TechDivision_Lang_Integer $reportFieldId = null)
    {
        // load the LocalHome
        $home = TDProject_Report_Model_Utils_ReportFieldUtil::getHome($this->getContainer());
		// check if a report ID was passed
		if ($reportFieldId == null) {
    		// if not, initialize a new report field
    		$reportField = $home->epbCreate();
		} else {
		    // if yes, load the report field
			$reportField = $home->findByPrimaryKey($reportFieldId);
		}
		// initialize a new DTO
		$dto = new TDProject_Report_Common_ValueObjects_ReportFieldViewData(
			$reportField
		);
		// set the report field classes
		$dto->setReportFieldClasses(
			TDProject_Report_Model_Assembler_ReportFieldClass::create($this->getContainer())
				->getReportFieldClassOverviewData()
		);
        // return the assembled DTO
		return $dto;
    }
}