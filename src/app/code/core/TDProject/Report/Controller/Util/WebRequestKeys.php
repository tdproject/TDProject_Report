<?php

/**
 * TDProject_Report_Controller_Util_WebRequestKeys
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Common/Util/WebRequestKeys.php';

/**
 * @category   	TDProject
 * @package    	TDProject_Report
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Controller_Util_WebRequestKeys
	extends TDProject_Common_Util_WebRequestKeys {

	/**
	 * The Request parameter key for the Controller method to invoke.
	 * @var string
	 */
	const METHOD = "method";

	/**
	 * The Request parameter key for the report's preview format.
	 * @var string
	 */
	const FORMAT = "format";

	/**
	 * The Request parameter key with the report ID.
	 * @var string
	 */
	const REPORT_ID = "reportId";

	/**
	 * The Request parameter key with the report's params.
	 * @var string
	 */
	const PARAMS = "params";

	/**
	 * The Request parameter key for the report's unit name.
	 * @var string
	 */
	const UNIT = "unit";
    
	/**
	 * The Request parameter key for storing the DTO with the report data.
	 * @var string
	 */
	const REPORT_DATA = "reportData";

	/**
	 * The Request parameter key with the report field ID.
	 * @var string
	 */
	const REPORT_FIELD_ID = "reportFieldId";
	
	/**
	 * Request key for the URL to redirect to.
	 * @var string
	 */
	const REDIRECT_URL = "redirectUrl";
	
	/**
	 * Request key for the ID of the report to download.
	 * @var string
	 */
	const REPORT_RENDERED_ID = "reportRenderedId";
}