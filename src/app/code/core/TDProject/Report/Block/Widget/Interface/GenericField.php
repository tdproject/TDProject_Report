<?php
/**
* TDProject_Report_Block_Widget_Interface_GenericField
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

interface TDProject_Report_Block_Widget_Interface_GenericField 
{
    /**
     * Creates a new dynamic field with the given required parameters
     * @param TDProject_Core_Interfaces_Block_Widget_Form The ActionForm instance the element is bound to
     * @param string $blockName The block name of the element, alias the property
     * @param string $blockTitle The block title of the element, alias the lable
     * @param TechDivision_Collections_Interfaces_Collection $data
     * @param TDProject_Report_Block_Widget_Interface_Validation $validation
     * @return void
     */
    public function __construct(
        TDProject_Core_Interfaces_Block_Widget_Form $form, 
        $blockName, 
        $blockTitle,
        TechDivision_Collections_Interfaces_Collection $data = null,
        TDProject_Report_Block_Widget_Interface_Validation $validation = null
    );
}