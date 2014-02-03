<?php

class TDProject_Report_Block_Widget_Validator_Date
{
	
	
	/**
	 * Default constructor to avoid ReflectionExceptions.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// nothing to do
	}
	
	public function validate($value = null, $allowNull = false)
	{
		if ($value == null && $allowNull) {
			return true;
		}
		
		return Zend_Locale_Format::checkDateFormat($value);
	}
}