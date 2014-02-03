<?php

/**
 * TDProject_Report_Block_Report_View_Print
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
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Block_Report_View_Print
    extends TDProject_Core_Block_Abstract {
    
	/**
	 * The parent block.
	 * @var TDProject_Report_Block_Report_View
	 */
	protected $_block = null;
	
    /**
     * Initialize the block with the apropriate template 
     * and name.
     * 
     * @return void
     */
    public function __construct(
        TDProject_Report_Block_Report_View $block)
    {
        // set the internal name
        $this->_setBlockName('print');
        // set the parent block
        $this->_block = $block;
        // set the template name
        $this->_setTemplate(
        	'www/design/report/templates/report/view/print.phtml'
        );
        // call the parent constructor
        parent::__construct($block->getContext());
    }
    
    public function getReportId()
    {
    	return $this->_block->getReportId();
    }
}