<?php

/**
 * TDProject_Report_Model_Assembler_ReportRendered
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
class TDProject_Report_Model_Assembler_ReportRendered
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
        return new TDProject_Report_Model_Assembler_ReportRendered($container);
    }
        
    /**
     * Returns a VO with the data of the report
     * with the passed ID.
     * 
     * @param TechDivision_Lang_Integer $reportRenderedId
     * 		The ID of the report to return the DTO for
     * @return TDProject_Report_Common_ValueObjects_ReportRenderedViewData
     * 		The requested DTO
     */
    public function getReportRenderedViewData(
        TechDivision_Lang_Integer $reportRenderedId) {
        // load the LocalHome
        $reportRendered = TDProject_Report_Model_Utils_ReportRenderedUtil::getHome($this->getContainer())
        	->findByPrimaryKey($reportRenderedId);
        // create new DTO with the data from the report
        $dto = new TDProject_Report_Common_ValueObjects_ReportRenderedViewData(
        	$reportRendered
        );
        // initialize the format helper
        $format = TDProject_Report_Common_Helper_Format::create(
        	$reportRendered->getFormat()
       	);
        // set the content type
        $dto->setContentType($format->getContentType());
        // load the filename for the report
        $filename = TDProject_Report_Model_Actions_ReportRendered::create($this->getContainer())
        	->getFilename($dto->getFilename());
        // set the download URL
        $dto->setDownloadUrl(new TechDivision_Lang_String($filename));
        // return the assembled DTO
		return $dto;
    }
}