<?php

/**
 * TDProject_Report_Controller_Util_ErrorKeys
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package     TDProject_Report
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Controller_Util_ErrorKeys
{
	/**
	 * Private constructor for marking
	 * the class as utiltiy.
	 *
	 * @return void
	 */
	private final function __construct() { /* Class is a utility class */ }
	
	/**
	 * The key for the system error.
	 * @var string
	 */
	const SYSTEM_ERROR = "systemError";
	
	/**
	 * The key for the name of e. g. a report.
	 * @var string
	 */
	const NAME = "name";
	
	/**
	 * The key for the description of e. g. a report.
	 * @var string
	 */
	const DESCRIPTION = "description";
	
	/**
	 * The key for the JasperServer unit of a report.
	 * @var string
	 */
	const UNIT = "unit";
	
	/**
	 * The key for the JasperServer parameter name.
	 * @var string
	 */
	const PARAMETER_NAME = "parameterName";
}