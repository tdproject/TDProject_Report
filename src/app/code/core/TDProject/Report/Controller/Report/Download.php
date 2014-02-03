<?php

/**
 * TDProject_Report_Controller_Report_Download
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
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Controller_Report_Download
    extends TDProject_Report_Controller_Abstract
{
	
	/**
	* The key for the ActionForward to the render-view
	* @var string
	*/
	const DOWNLOAD = "Download";

	/**
	 * This method is automatically invoked by the controller and implements the
	 * functionality to display the required fields to print a report.
	 *
	 * @return void
	 */
	public function __defaultAction()
	{
		try {
            // load the report ID from the request
            $reportRenderedId = $this->_getRequest()->getAttribute(
                TDProject_Report_Controller_Util_WebRequestKeys::REPORT_RENDERED_ID
            );
            if ($reportRenderedId == null) {
                $reportRenderedId = $this->_getRequest()->getParameter(
                    TDProject_Report_Controller_Util_WebRequestKeys::REPORT_RENDERED_ID,
                    FILTER_VALIDATE_INT
                );
            }
            // register the DTO in the context
            $this->getContext()->setAttribute(
                TDProject_Report_Controller_Util_WebRequestKeys::VIEW_DATA,
               $dto = $this->_getDelegate()->getReportRenderedViewData(
                    TechDivision_Lang_Integer::valueOf(
                        new TechDivision_Lang_String($reportRenderedId)
                    )
                )
            );
		} 
		catch(Exception $e) {
			// create and add and save the error
			$errors = new TechDivision_Controller_Action_Errors();
			$errors->addActionError(new TechDivision_Controller_Action_Error(
                TDProject_Report_Controller_Util_ErrorKeys::SYSTEM_ERROR,
                $e->__toString())
            );
			// adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
		}
		// go to the report download page
		return $this->_findForward(
		    TDProject_Report_Controller_Report_Download::DOWNLOAD
		);
	}

    /**
	 * Tries to load the Block class specified as path parameter
	 * in the ActionForward. If a Block was found and the class
	 * can be instanciated, the Block was registered to the Request
	 * with the path as key.
	 *
	 * @param TechDivision_Controller_Action_Forward $actionForward
	 * 		The ActionForward to initialize the Block for
	 * @return void
	 */
	protected function _getBlock(
	    TechDivision_Controller_Action_Forward $actionForward) {
	    // check if the class required to initialize the Block is included
	    if (!class_exists($path = $actionForward->getPath())) {
	        return;
	    }
	    // initialize the messages and add the Block
	    $page = new $path($this->getContext());
	    // register the Block in the Request
	    $this->_getRequest()->setAttribute($path, $page);
	}
}