<?php

/**
 * TDProject_Report_Block_Report_View_Input
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
 * @author      Markus Berwanger <m.berwanger@techdivision.com>
 */
class TDProject_Report_Block_Report_View_Input
    extends TDProject_Core_Block_Widget_Form_Ajax_Abstract {
	
	/**
	 * The ID of the report to render the input fields for.
	 * @var TechDivision_Lang_Integer
	 */
	protected $_reportId = null;
	
	/**
	 * The name of the report unit to render the input fields for.
	 * @var TechDivision_Lang_String
	 */
	protected $_unit = null;
	
	/**
	 * A collection with already rendered reports
	 * @var TechDivision_Collections_Interfaces_Collection
	 */
	protected $_reportsRendered = null;
	
	/**
	 * Array to store the dynamic report fields.
	 * @var array
	 */
	protected $_dynamicParameters = array();

	/**
	 * Array with the values of the dynamic fields ('name' => 'value').
	 * @var array
	 */
	protected $_parameterValues = array();
	 
	/**
	 * Returns the value of the class member reportId.
	 *
	 * @return TechDivision_Lang_Integer Holds the value of the class member reportId
	 */
	public function getReportId()
	{
		return $this->_reportId;
	}

	/**
	 * Sets the value for the class member reportId.
	 *
	 * @param string $string Holds the value for the class member reportId
	 */
	public function setReportId($string)
	{
		$this->_reportId = TechDivision_Lang_Integer::valueOf(new TechDivision_Lang_String($string));
	}

	/**
	 * Returns the value of the class member unit.
	 *
	 * @return TechDivision_Lang_String Holds the value of the class member unit
	 */
	public function getUnit()
	{
		return $this->_unit;
	}

	/**
	 * Sets the value for the class member unit.
     *
     * @param string $string Holds the value for the class member unit
     */
    public function setUnit($string)
    {
    	$this->_unit = new TechDivision_Lang_String($string);
    }

	/**
	 * Returns the value of the class member unit.
	 *
	 * @return TechDivision_Lang_String Holds the value of the class member unit
	 */
	public function getReportsRendered()
	{
		return $this->_reportsRendered;
	}

	/**
	 * Sets the value for the class member unit.
     *
     * @param string $string Holds the value for the class member unit
     */
    public function setReportsRendered(
    	TechDivision_Collections_Interfaces_Collection $collection)
    {
    	$this->_reportsRendered = $collection;
    }
    
	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout()
    {
    	// create and add a new fieldset
		$this->addBlock(
	    	$fieldset = new TDProject_Core_Block_Widget_Fieldset(
	    		$this->getContext(),
	    		'printReports',
	    		'Input Fields'
	    	)
		)
		->addElement(
		    $this->getElement('hidden', 'reportId')
		)
		->addElement(
		    $this->getElement('hidden', 'unit')
		);
		// get the view data from the request
		$viewData = $this->getContext()->getAttribute(
			TDProject_Report_Controller_Util_WebRequestKeys::VIEW_DATA
		);    	
    	// add the button to the Toolbar
    	$this->getToolbar()->addButton(
	    	$button = new TDProject_Core_Block_Widget_Button(
	    		$this->getContext(),
	    		'printReport',
	    		'Print Report'
	    	)
    	);
    	// set the buttons click event
    	$button->setOnClick(
    		'return printReport();'
    	);
    	$button->setIcon('ui-icon-disk');
		// if dynamic fields are available add an fieldset to display them
		if ($viewData->getFields()->size() !== 0) {			
    		// get the list of fields from the request
    		foreach ($viewData->getFields() as $field) {
    		    // get the name of the block-class
    		    $blockClass = $field->getClassBlock()->stringValue();
    		    //get the name of the field
    		    $name = $field->getName()->stringValue();
    		    // add the element to the fieldset
    		    $fieldset->addElement(
    		        new $blockClass(
    		            $this, 
    		            $name, 
    		            $this->translate(
    		            	'page.content.tabs.reports.reports.' . $name
    		            ),
    		            $field->getData()
    		        )
    		    );
    		}
		}
    	// add the grid with the already rendered reports
    	$this->addGrid($this->_prepareReportRenderedGrid());    	
		// call the parent method
    	return parent::prepareLayout();;
    }

    /**
     * Initializes and returns the grid for the report fields.
     *
     * @return TDProject_Core_Block_Widget_Grid
     * 		The initialized grid
     */
    protected function _prepareReportRenderedGrid()
    {
    	// instanciate the grid
    	$grid = new TDProject_Core_Block_Widget_Grid($this, 'reportRenderedGrid', 'Rendered Reports');
    	// set the collection with the data to render
    	$grid->setCollection($this->getReportsRendered());
    	// add the columns
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'reportRenderedId', 'ID', 10
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'username', 'Username', 20
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'format', 'Format', 10
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'createdAt', 'Created At', 45
    	    )
    	)->setFormatter(TDProject_Core_Formatter_Date::get());;
    	// add the actions
    	$action = new TDProject_Core_Block_Widget_Grid_Column_Actions(
    		'actions', 'Actions', 15
    	);
    	$action->addAction(
    	    new TDProject_Core_Block_Widget_Grid_Column_Actions_Print(
    	    	$this->getContext(),
    	    	'reportRenderedId',
    	    	'?path=/downloadReport'
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
    public function validate()
    {
        // initialize the ActionErrors
        $errors = new TechDivision_Controller_Action_Errors();
        // get the view data from the request
        $viewData = $this->getContext()->getAttribute(
        	TDProject_Report_Controller_Util_WebRequestKeys::VIEW_DATA
        );
        // if dynamic fields are available add an fieldset to display them
        if ($viewData->getFields()->size() !== 0) {
        	// 
        	foreach ($viewData->getFields() as $field) {
        		
        		$validator = $this->getApp()->newInstance($field->getClassValidation()->stringValue());
        		
        		$fieldName = $field->getName()->stringValue();
        		
        		$value = $this->_parameterValues[$fieldName];
        		
        		if ($validator->validate($value) === false) {
        			
        			$errors->addActionError(
        				new TechDivision_Controller_Action_Error(
        					$fieldName,
        					$this->translate($fieldName)
        				)
        			);
        		}
        	}
        }
        
        // return the ActionErrors
        return $errors;
    }
    
    /**
    * Populates the form with the data of the
    * passed ViewData-object
    *
    * @param TDProject_Report_Common_ValueObjects_ReportViewData $vdo
    * 		The ViewData-object.
    * @return TDProject_Report_Block_Abstract_Report
    * 		The instance itself
    */
    public function populate(TDProject_Report_Common_ValueObjects_ReportViewData $vdo) 
    {
        $this->_reportId = $vdo->getReportId();
        $this->_unit = $vdo->getUnit();
        $this->_reportsRendered = $vdo->getReportsRendered();
        // get the parameters out of the fields
        $parameters = array();
        $fields = $vdo->getFields();
        for ($i = 0; $i < $fields->size(); $i++)
        {
            $parameters[] = $fields->get($i);
        }
        $this->_dynamicParameters = $parameters;
        
        return $this;
    }
    
    /**
     * Initializes a new LVO with the data from
     * the form and returns it.
     * 
     * @param TDProject_Core_Common_ValueObjects_System_UserValue
     * 		The system user that renders the report
     * @return TDProject_Report_Common_ValueObjects_ReportFieldLightValue
     * 		The LVO initialized with the data of the form
     */
    public function repopulate(
    	TDProject_Core_Common_ValueObjects_System_UserValue $systemUser)
    {        
        $dto = new TDProject_Report_Common_ValueObjects_ParameterData();
        $dto->setUnit(new TechDivision_Lang_String($this->_unit));
        $dto->setUserId($systemUser->getUserId());
        //select format and save it in the dto
        $format = TDProject_Report_Common_Helper_Format::create(
            TDProject_Report_Common_Helper_Format::PDF
        );
        $dto->setFormat($format);
        //set the reportId
        $dto->setReportId($this->_reportId);
        
        //hand over the parameters to the dto
        $dto->setParams($this->_parameterValues);
        return $dto;
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Form_View::getBackUrl()
     */
    public function getBackUrl()
    {
        $params = array(
                'path' => '/report'
        );
        return $this->getUrl($params);
    }
    
    /**
    * (non-PHPdoc)
    * @see TDProject_Core_Interfaces_Block_Widget_Form_View::getDeleteUrl()
    */
    public function getDeleteUrl() 
    {
        // nothing to do - deleting not possible here, no button available
    }
    
    /**
    * (non-PHPdoc)
    * @see TDProject_Core_Interfaces_Block_Form::getValueByProperty()
    */
    public function getValueByProperty($name)
    {
        //add an underline to the property-name to compare
        $underlineName = '_'.$name;
        //create a refraction-object
        $reflectionObject = new ReflectionObject($this);
        //check if requested property is one of the class' properties
        if ($reflectionObject->hasProperty($underlineName)) {
            return parent::getValueByProperty($name);
        }
        //check if the requested property was 'path'
        elseif ($name == 'path') {
            return '/renderReport';
        }
        //check if the requested property was method
        elseif ($name == 'method') {
            return 'renderReport';
        }
        //check if requested property is one of the parameters 
        elseif (key_exists($name, $this->_dynamicParameters)) {
            return $this->_dynamicParameters[$name];
        }
        else {
            return '';
        }
    } 
    
    /**
    * @see TechDivision_Controller_Interfaces_Form::init()
    */
    public function init() 
    {
        //initialize the static values:
        // get the field names to initialize
        $reflectionObject = new ReflectionObject($this);
        // load all properties of the ActionForm
        $properties = $reflectionObject->getProperties();
        $propertyNames = array();
        // iterate over all fields and add the value from the Request
        for ($i = 0; $i < sizeof($properties); $i++) {
            // load the next property
            $reflectionProperty = $properties[$i];
            // concatenate the property name
            $propertyName = str_replace('_', '', $reflectionProperty->getName());
            $propertyNames[] = $propertyName;
            if ($propertyName !== 'parameters') {
                // try to load the property value from the Request
                $value = $this->_getRequestValue($propertyName);
                // check if a value for the property was found in the request
                if ($value !== null) {
                    // concatenate the method name
                    $methodName = 'set' . ucfirst($propertyName);
                    // set the value
                    if ($reflectionObject->hasMethod($methodName)) {
                        $reflectionMethod = $reflectionObject->getMethod($methodName);
                        $reflectionMethod->invokeArgs($this, array($value));
                    }
                }
            }
        }
        //create an array of all fields that were already handled
        $handledFields = $propertyNames;
        //manually add path and method, to avoid them from being added to parameters
        $handledFields[] = 'path';
        $handledFields[] = 'method';
        //initialize the dynamic fields:
        //get all parameters that were handed over
        $requestArray = $_REQUEST;
        $parameters = array();

        foreach ($requestArray as $key => $value) {
            // if the given value was not already handled it is a dynamic field
            if (!in_array($key, $handledFields)){
                $parameters[$key] = $value;
            }
        }
        
        $this->_getLogger()->error(var_export($requestArray, true));
        $this->_getLogger()->error(var_export($parameters, true));
        
        $this->_parameterValues = $parameters;
    }
}