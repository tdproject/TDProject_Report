<?php

/**
 * TDProject_Report_Model_Widget_ProjectSelectorSource
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
 * @copyright  	Copyright (c) 2011 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Markus Berwanger <m.berwanger@techdivision.com>
 */
class TDProject_Report_Model_Widget_ProjectSelectorSource
    implements TDProject_Report_Model_Widget_DataSource
{
	
	/**
	 * Default constructor to avoid ReflectionException.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		// nothing to do	
	}
	
    /**
     * Returns the list of available projects.
     * @param void
     * @return TechDivision_Collections_Interfaces_Collection
     */
    public function getData()
    {
        //get the project overview data form the assembler
        $projectAssembler = TDProject_Project_Model_Assembler_Project::create($this->getContainer());
        $projectList = $projectAssembler->getProjectOverviewData();      
        return $projectList;
    }
}