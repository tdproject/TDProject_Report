<?php

/**
 * TDProject_Report_Controller_Report_View
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Controller/Util/GlobalForwardKeys.php';
require_once 'TDProject/Report/Common/Helper/Unit.php';
require_once 'TDProject/Report/Common/Helper/Format.php';
require_once 'TDProject/Report/Controller/Abstract.php';
require_once 'TDProject/Report/Controller/Util/WebRequestKeys.php';
require_once 'TDProject/Report/Controller/Util/WebSessionKeys.php';
require_once 'TDProject/Report/Controller/Util/MessageKeys.php';
require_once 'TDProject/Report/Controller/Util/ErrorKeys.php';
require_once 'TDProject/Report/Common/ValueObjects/ParameterData.php';
require_once 'TDProject/Report/Block/Report/Render.php';
require_once 'TDProject/Report/Common/Exceptions/InvalidUnitException.php';

/**
 * @category   	TDProject
 * @package    	TDProject_Report
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Controller_Report_View
    extends TDProject_Report_Controller_Abstract {

	/**
	 * The key for the ActionForward to the render the input fields.
	 * @var string
	 */
	const INPUT = "Input";

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Controller_Abstract::preDispatch()
	 */
	public function preDispatch()
	{
		// load the report ID from the request
		$reportId = $this->_getRequest()->getAttribute(
			TDProject_Report_Controller_Util_WebRequestKeys::REPORT_ID
		);
		if ($reportId == null) {
			$reportId = $this->_getRequest()->getParameter(
				TDProject_Report_Controller_Util_WebRequestKeys::REPORT_ID,
				FILTER_VALIDATE_INT
			);
		}
		// initialize the ActionForm with the data from the DTO
		$this->_getActionForm()->populate(
			$dto = $this->_getDelegate()->getReportViewData(
				TechDivision_Lang_Integer::valueOf(
					new TechDivision_Lang_String($reportId)
				)
			)
		);
		// set the DTO with the data to preinitialize the form
		$this->getContext()->setAttribute(
			TDProject_Report_Controller_Util_WebRequestKeys::VIEW_DATA,
			$dto
		);
	}

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load a list with with available reports.
	 *
	 * @return void
	 */
	public function __defaultAction()
	{
		// set the DTO with the data to preinitialize the form
		$dto = $this->getContext()->getAttribute(
			TDProject_Report_Controller_Util_WebRequestKeys::VIEW_DATA
		);
		// populate the ActionForm with the DTO data
		$this->_getActionForm()->populate($dto);
		// go to the standard page
		return $this->_findForward(
		    TDProject_Report_Controller_Report_View::INPUT
		);
	}
	
	/**
	 * This method is automatically invoked by the controller and implements the
	 * functionality render the requested report.
	 *
	 * @return void
	 */
	public function renderReportAction()
	{
	    try {
	        // get the given data from the request and add it to the dto
	        $dto = new TDProject_Report_Common_ValueObjects_ParameterData();	        
	        // load the ActionForm
	        $actionForm = $this->_getActionForm();
            // validate the ActionForm with the report data
            $actionErrors = $actionForm->validate();
            if (($errorsFound = $actionErrors->size()) > 0) {
            	$this->_saveActionErrors($actionErrors);
				// go to the report edit page
				return $this->__defaultAction();
            }            
	        // load the ParameterData-object from the actionForm
	        $dto = $actionForm->repopulate($this->_getSystemUser());
            // load the DTO with the preview data
            $this->_getRequest()->setAttribute(
                TDProject_Report_Controller_Util_WebRequestKeys::VIEW_DATA,
                $this->_getDelegate()->renderReport($dto)
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
        // go to the report edit page
        return $this->__defaultAction();
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
	    // register the Block in the Request
	    $this->_getRequest()
	        ->setAttribute($path, $this->getContext()->getActionForm());
	}
}