<?php
/**
* TDProject_Report_Model_Widget_SelectOption
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


class TDProject_Report_Model_Widget_SelectOption
    implements TDProject_Core_Interfaces_Block_Widget_Element_Select_Option
{
    protected $_label;
    protected $_value;
    protected $_isSelected;
    
    public function __construct(
        TechDivision_Lang_String $label, 
        TechDivision_Lang_String $value,
        $isSelected = false)
    {
        $this->_label = $label;
        $this->_value = $value;
        $this->_isSelected = $isSelected;
        
    }
    /**
    * Returns the option's value to render.
    *
    * @return TechDivision_Lang_String
    * 		The option's value to render
    */
    public function getOptionValue()
    {
        return $this->_value;
        
    }
    
    /**
     * Returns the option's label to render.
     *
     * @return TechDivision_Lang_String
     * 		The option's label to render
     */
    public function getOptionLabel()
    {
        return $this->_label;
    }
    
    /**
     * Returns TRUE if the option has to be rendered as
     * selected else FALSE.
     *
     * @param TechDivision_Lang_Object $value
     * 		The value to compare the options ID to
     * @return boolean
     * 		TRUE if the option has to be rendered selected, else FALSE
     */
    public function isSelected(TechDivision_Lang_Object $value = null){
        return false;
    }
    
    
}
