<?php

/**
 * TDProject_Report_Model_Widget_UserSelectorSource
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
class TDProject_Report_Model_Widget_UserSelectorSource
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
     * Returns the list of available users.
     * @param void
     * @return TechDivision_Collections_Interfaces_Collection
     */
    public function getData()
    {
        //get the user overview data from the assembler
        $userAssembler = TDProject_Core_Model_Assembler_User::create($this->getContainer());
        $userList = $userAssembler->getUserOverviewData();        
        return $userList;
    }
}