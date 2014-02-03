<?php

/**
 * TDProject_Report_Model_Assembler_ReportFieldClass
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
class TDProject_Report_Model_Assembler_ReportFieldClass
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
        return new TDProject_Report_Model_Assembler_ReportFieldClass($container);
    }
        
    /**
     * Returns an ArrayList with the DTO's of the available
     * report fields.
     * 
     * @return TechDivision_Collections_ArrayList
     * 		The ArrayList with the requested DTO's
     */
    public function getReportFieldClassOverviewData()
    {
    	// initialize the ArrayList for the DTO's
    	$list = new TechDivision_Collections_ArrayList();
        // load the available report field classes
        $reportFieldClasses = TDProject_Report_Model_Utils_ReportFieldClassUtil::getHome($this->getContainer())
        	->findAll();
		// prepare the DTO's and add them to the ArrayList
		foreach ($reportFieldClasses as $reportFieldClass) {
			$list->add(
				new TDProject_Report_Common_ValueObjects_ReportFieldClassOverviewData(
					$reportFieldClass
				)
			);
		}
        // return the assembled DTO's
		return $list;
    }
}