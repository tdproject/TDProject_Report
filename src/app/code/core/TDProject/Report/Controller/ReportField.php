<?php

/**
 * TDProject_Report_Controller_ReportField
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
class TDProject_Report_Controller_ReportField
    extends TDProject_Report_Controller_Abstract
{

	/**
	 * The key for the ActionForward to the report field view template.
	 * @var string
	 */
	const REPORT_FIELD_VIEW = "ReportFieldView";

	/**
	 * The key for the ActionForward to the JavaScript redirect page.
	 * @var string
	 */
	const REDIRECT = "Redirect";

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load the report field data with the id passed in 
	 * the Request for editing it.
	 *
	 * @return void
	 */
	public function editAction()
	{
        try {
            // load the report field ID from the request
            $reportFieldId = $this->_getRequest()->getAttribute(
                TDProject_Report_Controller_Util_WebRequestKeys::REPORT_FIELD_ID
            );
            if ($reportFieldId == null) {
                $reportFieldId = $this->_getRequest()->getParameter(
                    TDProject_Report_Controller_Util_WebRequestKeys::REPORT_FIELD_ID,
                    FILTER_VALIDATE_INT
                );
            }
            // initialize the ActionForm with the data from the DTO
            $this->_getActionForm()->populate(
                $dto = $this->_getDelegate()->getReportFieldViewData(
                    TechDivision_Lang_Integer::valueOf(
                        new TechDivision_Lang_String($reportFieldId)
                    )
                )
            );
        }
        catch(Exception $e) {
			// create and add and save the error
			$errors = new TechDivision_Controller_Action_Errors();
			$errors->addActionError(
			    new TechDivision_Controller_Action_Error(
                    TDProject_Report_Controller_Util_Errorkeys::SYSTEM_ERROR,
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
        // return to the report field detail page
        return $this->_findForward(
            TDProject_Report_Controller_ReportField::REPORT_FIELD_VIEW
        );
	}

    /**
     * This method is automatically invoked by the controller and implements
     * the functionality to create a new report field.
     *
	 * @return void
     */
    public function createAction()
    {
        try {
            // initialize the ActionForm with the data from the DTO
            $this->_getActionForm()->initialize(
            	$this->_getDelegate()->getReportFieldViewData()
            );
        }
        catch(Exception $e) {
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
        // return to the report field detail page
        return $this->_findForward(
            TDProject_Report_Controller_ReportField::REPORT_FIELD_VIEW
        );
    }

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to save the passed report field data.
	 *
	 * @return void
	 */
	public function saveAction() 
	{
		try {
		    // load the ActionForm
		    $actionForm = $this->_getActionForm();
		    // validate the ActionForm with the address data
            $actionErrors = $actionForm->validate();
            if (($errorsFound = $actionErrors->size()) > 0) {
                $this->_saveActionErrors($actionErrors);
                return $this->createAction();
            }
			// save the report field
			$reportFieldId = $this->_getDelegate()
			    ->saveReportField($actionForm->repopulate());
			// store the ID of the report field in the Request
			$this->_getRequest()->setAttribute(
                TDProject_Report_Controller_Util_WebRequestKeys::REPORT_FIELD_ID,
                $reportFieldId->intValue()
            );
			// create the affirmation message
	        $actionMessages = new TechDivision_Controller_Action_Messages();
            $actionMessages->addActionMessage(
                new TechDivision_Controller_Action_Message(
                    TDProject_Report_Controller_Util_MessageKeys::AFFIRMATION,
                    $this->translate('reportFieldUpdate.successfull')
                )
            );
            // save the ActionMessages in the request
            $this->_saveActionMessages($actionMessages);
            // set the redirect URL
            $this->_getRequest()->setAttribute(
            	TDProject_Report_Controller_Util_WebRequestKeys::REDIRECT_URL, 
            	$this->getRedirectUrl($actionForm->getReportIdFk())
            );
            // replace the ActionForm in the request
            $this->getContext()->setActionForm(
            	new TDProject_Report_Block_ReportField_Redirect($this->getContext())
            );
		} 
		catch(Exception $e) {
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
        // return to the report field detail page
        return $this->_findForward(
            TDProject_Report_Controller_ReportField::REDIRECT
        );
	}
	
	/**
	 * Returns the URL to redirect to after saving the report field.
	 * 
	 * @param TechDivision_Lang_Integer $reportId The report ID necessary to build the URL
	 * @return string The URL to redirect to
	 */
	public function getRedirectUrl(TechDivision_Lang_Integer $reportId)
	{
		// prepare the URL parameter to return to after deleting the report field
		return $this->getUrl(
			array(
				'path' => '/report',
		    	'method' => 'edit',
		    	'reportId' => $reportId
			)
		);
	}

	/**
     * This method is automatically invoked by the controller and implements
     * the functionality to delete the report field with the passed ID.
     *
	 * @return void
     */
    public function deleteAction() {
        try {
            // load the report field ID from the request
        	$reportFieldId = $this->_getRequest()->getParameter(
                TDProject_Report_Controller_Util_WebRequestKeys::REPORT_FIELD_ID,
                FILTER_VALIDATE_INT
            );
            // delete the report field
            $this->_getDelegate()->deleteReportField(
                TechDivision_Lang_Integer::valueOf(
                    new TechDivision_Lang_String($reportFieldId)
                )
            );
        } 
        catch(Exception $e) {
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
        // return to the detail page
        return $this->createAction();
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