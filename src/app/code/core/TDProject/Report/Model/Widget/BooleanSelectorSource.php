<?php

/**
 * TDProject_Report_Model_Widget_BooleanSelectorSource
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
class TDProject_Report_Model_Widget_BooleanSelectorSource
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
     * Returns a list of true and false as select options.
     * @param void
     * @return TechDivision_Collections_Interfaces_Collection
     */
    public function getData()
    {
        $options = new TechDivision_Collections_ArrayList;
        
        $true = new TDProject_Report_Model_Widget_SelectOption(
            new TechDivision_Lang_String('true'), 
            new TechDivision_Lang_String('1')
        );
        $options->add($true);
        
        $false = new TDProject_Report_Model_Widget_SelectOption(
            new TechDivision_Lang_String('false'), 
            new TechDivision_Lang_String('0')
        );
        $options->add($false);
        
        return $options;
    }   
}