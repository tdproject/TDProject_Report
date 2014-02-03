<?php

class TDProject_Report_Block_Widget_Validator_Boolean
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
		
		return filter_var($value, FILTER_VALIDATE_BOOLEAN);
	}
}