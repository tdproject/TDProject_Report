<?php

/**
 * TDProject_Report_Block_ReportField_Redirect
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category    TDProject
 * @package     TDProject_Report
 * @copyright   Copyright (c) 2011 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Block_ReportField_Redirect
	extends TDProject_Core_Block_Abstract
{

    /**
     * Initialize the block with the apropriate 
     * template and name.
     *
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context) {
        // set the template name
        $this->_setTemplate('www/design/report/templates/report_field/redirect.phtml');
        // call the parent constructor
        parent::__construct($context);
    }
}