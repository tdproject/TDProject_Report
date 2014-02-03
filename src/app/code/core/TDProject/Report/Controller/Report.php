<?php

/**
 * TDProject_Report_Controller_Report
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Controller/Util/GlobalForwardKeys.php';
require_once 'TDProject/Report/Controller/Abstract.php';
require_once 'TDProject/Report/Controller/Util/WebRequestKeys.php';
require_once 'TDProject/Report/Controller/Util/WebSessionKeys.php';
require_once 'TDProject/Report/Controller/Util/MessageKeys.php';
require_once 'TDProject/Report/Controller/Util/ErrorKeys.php';
require_once 'TDProject/Report/Block/Report/Overview.php';
require_once 'TDProject/Report/Block/Report/View.php';

/**
 * @category   	TDProject
 * @package    	TDProject_Report
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Controller_Report
    extends TDProject_Report_Controller_Abstract {

	/**
	 * The key for the ActionForward to the report overview.
	 * @var string
	 */
	const REPORT_OVERVIEW = "ReportOverview";

	/**
	 * The key for the ActionForward to the report view.
	 * @var string
	 */
	const REPORT_VIEW = "ReportView";
	
	/**
	* The key for the ActionForward to the report view.
	* @var string
	*/
	const REPORT_INPUT_VIEW = "ReportInputView";

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load a list with with all reports.
	 *
	 * @return void
	 */
	function __defaultAction()
	{
		try {
			// replace the default ActionForm
			$this->getContext()->setActionForm(
				new TDProject_Report_Block_Report_Overview($this->getContext())
			);
            // load and register the report overview data
            $this->_getRequest()->setAttribute(
            	TDProject_Report_Controller_Util_WebRequestKeys::OVERVIEW_DATA,
            	$this->_getDelegate()->getReportOverviewData()
            );
		} catch(Exception $e) {
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
		// go to the standard page
		return $this->_findForward(
		    TDProject_Report_Controller_Report::REPORT_OVERVIEW
		);
	}

    /**
     * This method is automatically invoked by the controller and implements
     * the functionality to create a new project.
     *
	 * @return void
     */
    public function createAction()
    {
        try {
            // initialize the ActionForm with the data from the DTO
            $this->_getActionForm()->populate(
                $dto = $this->_getDelegate()->getReportViewData()
            );
            // register the DTO in the Request
            $this->_getRequest()->setAttribute(
                TDProject_Report_Controller_Util_WebRequestKeys::VIEW_DATA,
                $dto
            );
        } catch(Exception $e) {
            // create and add and save the error
            $errors = new TechDivision_Controller_Action_Errors();
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Report_Controller_Util_ErrorKeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
            // adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
        }
        // return to the project detail page
        return $this->_findForward(
            TDProject_Report_Controller_Report::REPORT_VIEW
        );
    }

	/**
	 * This method is automatically invoked by the controller and implements the
	 * functionality to edit the report with the ID passed as Request parameter.
	 *
	 * @return void
	 */
	public function editAction()
	{
		try {
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
            // register the DTO in the Request
            $this->_getRequest()->setAttribute(
                TDProject_Report_Controller_Util_WebRequestKeys::VIEW_DATA,
                $dto
            );
		} catch(Exception $e) {
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
		return $this->_findForward(
		    TDProject_Report_Controller_Report::REPORT_VIEW
		);
	}

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to save the passed report data.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	public function saveAction()
	{
		try {
		    // load the ActionForm
		    $actionForm = $this->_getActionForm();
		    // validate the ActionForm with the report data
            $actionErrors = $actionForm->validate();
            if (($errorsFound = $actionErrors->size()) > 0) {
                $this->_saveActionErrors($actionErrors);
                return $this->createAction();
            }
			// save the report
			$reportId = $this->_getDelegate()->saveReport(
			    $actionForm->repopulate()
			);
			// store the ID of the report in the Request
			$this->_getRequest()->setAttribute(
                TDProject_Report_Controller_Util_WebRequestKeys::REPORT_ID,
                $reportId->intValue()
            );
			// create the affirmation message
	        $actionMessages = new TechDivision_Controller_Action_Messages();
            $actionMessages->addActionMessage(
                new TechDivision_Controller_Action_Message(
                    TDProject_Report_Controller_Util_MessageKeys::AFFIRMATION,
                    $this->translate('reportUpdate.successfull')
                )
            );
            // save the ActionMessages in the request
            $this->_saveActionMessages($actionMessages);
		} catch(Exception $e) {
			// create and add and save the error
			$errors = new TechDivision_Controller_Action_Errors();
			$errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Report_Controller_Util_ErrorKeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
			// adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
		}
		// return to the report detail page
        return $this->editAction();
	}

	/**
     * This method is automatically invoked by the controller and implements
     * the functionality to delete the passed report.
     *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
     */
    public function deleteAction()
    {
        try {
            // load the report ID from the request
        	$reportId = $this->_getRequest()->getParameter(
                TDProject_Report_Controller_Util_WebRequestKeys::REPORT_ID,
                FILTER_VALIDATE_INT
            );
            // delete the report
            $this->_getDelegate()->deleteReport(
                TechDivision_Lang_Integer::valueOf(
                    new TechDivision_Lang_String($reportId)
                )
            );
        } catch(Exception $e) {
            // create and add and save the error
            $errors = new TechDivision_Controller_Action_Errors();
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Report_Controller_Util_ErrorKeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
            // adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
        }
        // return to the report overview page
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
	    // initialize the page and add the Block
	    $page = new TDProject_Core_Block_Page($this->getContext());
	    $page->setPageTitle($this->_getPageTitle());
	    $page->addBlock($this->getContext()->getActionForm());
	    // register the Block in the Request
	    $this->_getRequest()->setAttribute($path, $page);
	}
}