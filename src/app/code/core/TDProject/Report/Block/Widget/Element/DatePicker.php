<?php
/**
* TDProject_Report_Block_Widget_Element_DatePicker
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

class TDProject_Report_Block_Widget_Element_DatePicker
    extends TDProject_Core_Block_Widget_Element_Input_Textfield
    implements TDProject_Report_Block_Widget_Interface_GenericField
{
     /**
     * Holds the reference to class that is implementing the 
     * TDProject_Report_Block_Widget_Interface_Validation-interface that takes 
     * over the validation of the entries.
     * @var TDProject_Report_Block_Widget_Interface_Validation
     */
    protected $_validation;
    
    /**
    * Creates a new date-picker
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
        TDProject_Report_Block_Widget_Interface_Validation $validation = null)
    {
        //call parent constructor
        parent::__construct($form, $blockName, $blockTitle);
        //set the different css-template
        $this->_setTemplate('www/design/report/templates/widget/element/date_picker.phtml');
        //store other given values
        $this->_validation = $validation;      
    }
}