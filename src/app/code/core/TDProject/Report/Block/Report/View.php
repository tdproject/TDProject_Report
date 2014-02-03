<?php

/**
 * TDProject_Report_Block_Report_View
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Controller/Action/Error.php';
require_once 'TechDivision/Controller/Action/Errors.php';
require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TechDivision/Collections/ArrayList.php';
require_once 'TDProject/Core/Controller/Util/ErrorKeys.php';
require_once 'TDProject/Core/Block/Widget/Element/Input/Hidden.php';
require_once 'TDProject/Report/Block/Abstract/Report.php';

/**
 * @category    TDProject
 * @package     TDProject_Report
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Block_Report_View
    extends TDProject_Report_Block_Abstract_Report {

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout()
    {
    	// initialize the tabs
    	$tabs = $this->addTabs(
    		'tabs', 
    		$this->translate('report.view.tabs.label.report')
    	);
        // add the tab for the LDAP settings
		$tabs->addTab(
			'reports',
			$this->translate('report.view.tab.label.report')
		)
		->addFieldset(
			'reports',
			$this->translate('report.view.fieldset.label.report')
		)
    	->addElement(
    	    $this->getElement(
    	    	'textfield', 
    	    	'name', 
    	    	$this->translate('report.view.label.name')
    	    )->setMandatory())
    	->addElement(
    	    $this->getElement(
    	    	'textfield', 
    	    	'unit', 
    	    	$this->translate('report.view.label.unit')
    	    )->setMandatory())
    	->addElement(
    	    $this->getElement(
    	    	'textarea', 
    	    	'description', 
    	    	$this->translate('report.view.label.description')
    	    )->setMandatory()
    	);
		// check if a new Report will be created, if so do NOT render report fields
		if ($this->getReportId()->equals(new TechDivision_Lang_Integer(0)) === false) {
			// add the tab for the report fields
			$tabReportFields = $tabs->addTab('reportFields', 'Report Fields')
				->addGrid($this->_prepareReportFieldGrid())
				->addBlock(
					new TDProject_Report_Block_Report_View_ReportField($this)
				);
			// add the button to create a new address
			$button = new TDProject_Core_Block_Widget_Button(
				$this->getContext(),
				'createReportField',
				'New Report Field'
			);
			// bind the button to the Toolbar
			$button
				->setOnClick('createReportField(' . $this->getReportId() . '); return false;')
				->bindToTab($tabReportFields);
			// add the button to the toolbar
			$this->getToolbar()->addButton($button);			
			// add the tab for the report fields
			$tabPrint = $tabs->addTab('printTab', 'Print');
			$tabPrint->addBlock(
				new TDProject_Report_Block_Report_View_Print($this)
			);
			// add the button to the toolbar
			$this->getToolbar()->addButton($button);
		}
		// call the parent method
    	return parent::prepareLayout();
    }

    /**
     * Initializes and returns the grid for the report fields.
     *
     * @return TDProject_Core_Block_Widget_Grid
     * 		The initialized grid
     */
    protected function _prepareReportFieldGrid()
    {
    	// instanciate the grid
    	$grid = new TDProject_Core_Block_Widget_Grid($this, 'reportFieldGrid', 'Report Fields');
    	// set the collection with the data to render
    	$grid->setCollection($this->getReportFields());
    	// add the columns
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'reportFieldId', 'ID', 10
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'name', 'Name', 20
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'parameterName', 'Parameter Name', 25
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'reportFieldClassType', 'Type', 30
    	    )
    	);
    	// add the actions
    	$action = new TDProject_Core_Block_Widget_Grid_Column_Actions(
    		'actions', 'Actions', 15
    	);
    	// to avoid the usual redirect, because using AJAX in this case
    	$action->setOnChange('javascript:void(0);');
    	$action->addAction(
    	    new TDProject_Core_Block_Widget_Grid_Column_Actions_JavaScript(
    	        $this->getContext(),
    	        'reportFieldId',
    	        'Delete',
    	        'deleteReportField(' . $this->getReportId() . ', $(this).val()); return false;'
    	    )
    	);
    	$action->addAction(
    		new TDProject_Core_Block_Widget_Grid_Column_Actions_JavaScript(
	    		$this->getContext(),
	    		'reportFieldId',
	    		'Edit',
	    	    'return loadReportField($(this).val());'
	    	)
    	);
    	$grid->addColumn($action);
    	// return the initialized instance
    	return $grid;
    }

    /**
     * This method checks if the values in the member variables
     * holds valiid data. If not, a ActionErrors container will
     * be initialized an for every incorrect value a ActionError
     * object with the apropriate error message will be added.
     *
     * @return ActionErrors Returns a ActionErrors container with ActionError objects
     */
    function validate()
    {
        // initialize the ActionErrors
        $errors = new TechDivision_Controller_Action_Errors();
        // check if a report name was entered
        if ($this->_name->length() == 0) {
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Report_Controller_Util_ErrorKeys::NAME,
                    $this->translate('report-name.none')
                )
            );
        }
        // check if a report description was entered
        if ($this->_description->length() == 0) {
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Report_Controller_Util_ErrorKeys::DESCRIPTION,
                    $this->translate('report-description.none')
                )
            );
        }
        // check if a report unit was entered
        if ($this->_unit->length() == 0) {
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Report_Controller_Util_ErrorKeys::UNIT,
                    $this->translate('report-unit.none')
                )
            );
        }
        // return the ActionErrors
        return $errors;
    }
}