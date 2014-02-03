<?php

/**
 * TDProject_Report_Block_ReportField_View
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
class TDProject_Report_Block_ReportField_View
	extends TDProject_Core_Block_Widget_Form_Ajax_Abstract
{

	/**
	 * The available report field classes.
	 * @var TechDivision_Collections_Interfaces_Collection
	 */
	protected $_reportFieldClasses = null;

	/**
	 * @var TechDivision_Lang_Integer
	 */
	protected $_reportFieldId = null;

	/**
	 * @var TechDivision_Lang_Integer
	 */
	protected $_reportIdFk = null;

	/**
	 * @var TechDivision_Lang_String
	 */
	protected $_name = null;

	/**
	 * @var TechDivision_Lang_String
	 */
	protected $_parameterName = null;

	/**
	 * @var TechDivision_Lang_Integer
	 */
	protected $_reportFieldClassIdFk = null;

	/**
	 * @var TDProject_Report_Common_ValueObjects_ReportFieldClassLightValue
	 */
	protected $_reportFieldClass = null;
	
	/**
	 * Sets the available report field classes.
	 * 
	 * @param TechDivision_Collections_Interfaces_Collection $reportFieldClasses
	 * 		The available report field classes
	 * @return void
	 */
	public function setReportFieldClasses(
		TechDivision_Collections_Interfaces_Collection $reportFieldClasses)
	{
		$this->_reportFieldClasses = $reportFieldClasses;
	}
	
	/**
	 * Returns the available report field classes.
	 * 
	 * @return TechDivision_Collections_Interfaces_Collection
	 * 		The available report field classes
	 */
	public function getReportFieldClasses()
	{
		return $this->_reportFieldClasses;
	}
		
	/**
	 * Returns the value of the class member reportFieldId.
	 *
	 * @return TechDivision_Lang_Integer Holds the value of the class member reportFieldId
	 */
	public function getReportFieldId()
	{
		return $this->_reportFieldId;
	}
		
	/**
	 * Sets the value for the class member reportFieldId.
	 *
	 * @param string $string Holds the value for the class member reportFieldId
	 */
	public function setReportFieldId($string) {
		$this->_reportFieldId = TechDivision_Lang_Integer::valueOf(new TechDivision_Lang_String($string));
	}

	/**
	 * Returns the value of the class member reportIdFk.
	 *
	 * @return TechDivision_Lang_Integer Holds the value of the class member reportIdFk
	 */
	public function getReportIdFk()
	{
		return $this->_reportIdFk;
	}
		
	/**
	 * Sets the value for the class member reportIdFk.
	 *
	 * @param string $string Holds the value for the class member reportIdFk
	 */
	public function setReportIdFk($string) {
		$this->_reportIdFk = TechDivision_Lang_Integer::valueOf(new TechDivision_Lang_String($string));
	}

	/**
	 * Returns the value of the class member name.
	 *
	 * @return TechDivision_Lang_String Holds the value of the class member name
	 */
	public function getName()
	{
		return $this->_name;
	}
		
	/**
	 * Sets the value for the class member name.
	 *
	 * @param string $string Holds the value for the class member name
	 */
	public function setName($string) {
		$this->_name = new TechDivision_Lang_String($string);
	}

	/**
	 * Returns the value of the class member parameterName.
	 *
	 * @return TechDivision_Lang_String Holds the value of the class member parameterName
	 */
	public function getParameterName()
	{
		return $this->_parameterName;
	}
		
	/**
	 * Sets the value for the class member parameterName.
	 *
	 * @param string $string Holds the value for the class member parameterName
	 */
	public function setParameterName($string) {
		$this->_parameterName = new TechDivision_Lang_String($string);
	}

	/**
	 * Returns the value of the class member reportFieldClassIdFk.
	 *
	 * @return TechDivision_Lang_Integer Holds the value of the class member reportFieldClassIdFk
	 */
	public function getReportFieldClassIdFk()
	{
		return $this->_reportFieldClassIdFk;
	}
		
	/**
	 * Sets the value for the class member reportFieldClassIdFk.
	 *
	 * @param string $string Holds the value for the class member reportFieldClassIdFk
	 */
	public function setReportFieldClassIdFk($string) {
		$this->_reportFieldClassIdFk = TechDivision_Lang_Integer::valueOf(new TechDivision_Lang_String($string));
	}

	/**
	 * Sets the
	 *
	 * @param TDProject_Report_Common_ValueObjects_ReportFieldClassLightValue Holds the
	 */
	public function setReportFieldClass(TDProject_Report_Common_ValueObjects_ReportFieldClassLightValue $lvo)
	{
		$this->_reportFieldClass = $lvo;
	}

	/**
	 * Returns the
	 *
	 * @return TDProject_Report_Common_ValueObjects_ReportFieldClassLightValue Holds the
	 */
	public function getReportFieldClass()
	{
		return $this->_reportFieldClass;
	}


	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Block_Abstract::reset()
	 */
	public function reset()
	{
		$this->_reportFieldId = new TechDivision_Lang_Integer(0);
		$this->_reportIdFk = new TechDivision_Lang_Integer(0);
		$this->_name = new TechDivision_Lang_String();
		$this->_parameterName = new TechDivision_Lang_String();
		$this->_reportFieldClassIdFk = new TechDivision_Lang_Integer(0);
		$this->_reportFieldClass = null;
		$this->_reportFieldClasses = new TechDivision_Collections_ArrayList();
	}
		
	/**
	 * Populates the form with the data of the
	 * passed LVO.
	 *
	 * @param TDProject_Report_Common_ValueObjects_ReportFieldLightValue $lvo
	 * 		The LVO to populate the form with
	 * @return TDProject_Report_Block_Abstract_ReportField
	 * 		The instance itself
	 */
	public function populate(
		TDProject_Report_Common_ValueObjects_ReportFieldValue $vo)
	{
		$this->_reportFieldId = $vo->getReportFieldId();
		$this->_reportIdFk = $vo->getReportIdFk();
		$this->_name = $vo->getName();
		$this->_parameterName = $vo->getParameterName();
		$this->_reportFieldClassIdFk = $vo->getReportFieldClassIdFk();
		$this->_reportFieldClass = $vo->getReportFieldClass();
		$this->setReportFieldClasses($vo->getReportFieldClasses());
		return $this;
	}
		
	/**
	 * Initializes a new LVO with the data from
	 * the form and returns it.
	 *
	 * @return TDProject_Report_Common_ValueObjects_ReportFieldLightValue
	 * 		The LVO initialized with the data of the form
	 */
	public function repopulate()
	{
		$lvo = new TDProject_Report_Common_ValueObjects_ReportFieldLightValue();
		$lvo->setReportFieldId($this->getReportFieldId());
		$lvo->setReportIdFk($this->getReportIdFk());
		$lvo->setName($this->getName());
		$lvo->setParameterName($this->getParameterName());	
		$lvo->setReportFieldClassIdFk($this->getReportFieldClassIdFk());
		return $lvo;
	}
	
	/**
	 * Initializes the ActionForm with the
	 * data from the passed DTO.
	 * 
	 * @param TDProject_Report_Common_ValueObjects_ReportFieldViewData $dto
	 * 		The data to initialize the ActionForm with
	 * @return TDProject_Report_Block_ReportField_View
	 * 		The instance itself
	 */
	public function initialize(
		TDProject_Report_Common_ValueObjects_ReportFieldViewData $dto)
	{
		$this->setReportFieldClasses($dto->getReportFieldClasses());
		return $this;
	}
	
	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout()
    {	
    	
    	$this->addBlock(
    		new TDProject_Report_Block_ReportField_View_JavaScript($this)
    	);
    	
    	// add the hidden fields
    	$this->addElement($this->getElement('hidden', 'reportIdFk'));
    	$this->addElement($this->getElement('hidden', 'reportFieldId'));
    	// initialize the fieldset
    	$fieldset = new TDProject_Core_Block_Widget_Fieldset(
    	    $this->getContext(),
    	    'reportField',
    	    'Report Field'
    	);
    	// add the elements
    	$fieldset
        	->addElement(
        	    $this->getElement(
        	    	'textfield',
        	    	'name',
        	    	'Name'
        	    )->setMandatory()
        	)
    		->addElement(
    		    $this->getElement(
    		    	'textfield',
    		    	'parameterName',
    		    	'Parameter Name (JasperServer)'
    		    )->setMandatory()
    		)
        	->addElement(
        	    $this->getElement(
        	    	'select',
        	    	'reportFieldClassIdFk',
        	    	'Field Type'
        	    )->setOptions($this->getReportFieldClasses())
        	);
        // add the fieldset
        $this->addBlock($fieldset);
        // add the button to the Toolbar
        $this->getToolbar()->addButton(
        	$button = new TDProject_Core_Block_Widget_Button(
        	    $this->getContext(),
        	    'saveReportField',
        	    'Save Report Field'
        	)
        );
        // set the buttons click event
        $button->setOnClick(
        	'return saveReportField();'
        );
        $button->setIcon('ui-icon-disk');
	    // return the instance itself
	    return parent::prepareLayout();
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
        // check if a name is passed
        if ($this->getName()->length() == 0) {
        	$errors->addActionError(
        		new TechDivision_Controller_Action_Error(
	        		TDProject_Report_Controller_Util_ErrorKeys::NAME,
	        		$this->translate('report-field-name.none')
	        	)
        	);
        }
        // check if a parameter name for the JasperServer is passed
        if ($this->getParameterName()->length() == 0) {
        	$errors->addActionError(
        		new TechDivision_Controller_Action_Error(
	        		TDProject_Report_Controller_Util_ErrorKeys::PARAMETER_NAME,
	        		$this->translate('report-field-parameter-name.none')
	        	)
        	);
        }
        // return the ActionErrors
        return $errors;
    } 
}