<?php
/**
* TDProject_Report_Block_Widget_Interface_Validation
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
* @author      	Markus Berwanger <m.berwanger@techdivision.com>
*/

interface TDProject_Report_Block_Widget_Interface_Validation 
{
    /**
     * Validates the given value
     * @param mixed $value
     * @return boolean true if value is valid, false if not
     */
    public function validate($value);
}