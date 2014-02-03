<?php

/**
 * TDProject_Report_Model_Widget_Interfaces_ReportField
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Implementation of aynamic report field wrapper to handle necessary
 * conversion of the user input, e. g. a date has to be converted into 
 * a timestamp in milliseconds.
 * 
 * @category   	TDProject
 * @package    	TDProject_Report
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 * @see 		TDProject_Report_Model_Widget_Converter_DateToMilliseconds::convert()
 */
class TDProject_Report_Model_Widget_ReportField
	implements TDProject_Report_Model_Widget_Interfaces_ReportField
{
    
    /**
     * Reference to the container instance.
     * @var TechDivision_Model_Interfaces_Container
     */
    protected $_container = null;
	
	/**
	 * The report field entity to handle conversion for.
	 * @var TDProject_Report_Model_Entities_ReportField
	 */
	protected $_reportField = null;
	
	/**
	 * The params with the user input to convert.
	 * @var array
	 */
	protected $_params = array();
	
	/**
	 * The field name of the HTML input field
	 * @var TechDivision_Lang_String
	 */
	protected $_oldKey = null;
	
	/**
	 * The JasperServer parameter name.
	 * @var TechDivision_Lang_String
	 */
	protected $_newKey = null;
	
	/**
	 * Protected to avoid direct intialization use
	 * factory method 
	 * <code>
	 * $reportField = TDProject_Report_Model_Widget_ReportField::create($container)
	 * </code>
	 * instead.
	 * 
     * @param TechDivision_Model_Interfaces_Container $container The container instance
	 * @return void
	 * @see TDProject_Report_Model_Widget_ReportField::create()
	 */
	public function __construct(TechDivision_Model_Interfaces_Container $container)
    {
        $this->_container = $container;
	}
	
	/**
	 * Factory method to create a new report field wrapper instance.
	 * 
     * @param TechDivision_Model_Interfaces_Container $container The container instance
	 * @return TDProject_Report_Model_Widget_ReportField
	 * 		The wrapper instance
	 */
	public static function create(TechDivision_Model_Interfaces_Container $container)
	{
		return new TDProject_Report_Model_Widget_ReportField($container);
	}
	
	/**
	 * Initializes the keys with the values from the
	 * passed report field.
	 * 
	 * @return TDProject_Report_Model_Widget_ReportField The instance
	 * @see TDProject_Report_Model_Widget_ReportField::setReportField()
	 */
	public function init()
	{
		// load the old key (input field name)
		$this->setOldKey($this->getReportField()->getName());
		// load the new key (JasperServer report parameter name)
		$this->setNewKey($this->getReportField()->getParameterName());
		// return the instance itself
		return $this;
	}
	
	/**
	 * Invokes the converter if available or leaves the parameter untouched.
	 * 
	 * @return void
	 */
	public function convert()
	{
		// load the converter class name
		$classConverter = $this->getReportField()->getReportFieldClass()->getClassConverter();
		// check if a converter is available for the report field
		if ($classConverter && !$classConverter->equals(new TechDivision_Lang_String())) {
			$this->init()->newInstance($classConverter)->convert($this);
		}
		// return the report field instance itself
		return $this;
	}
	
	/**
	 * Creates a new instance of the passed converter class name and
	 * returns it.
	 * 
	 * @return TDProject_Report_Model_Widget_Interfaces_Converter
	 * 		The converter class instance
	 */
	public function newInstance(TechDivision_Lang_String $classConverter)
	{
		return TechDivision_Model_Container_Implementation::getContainer()
			->newInstance($classConverter->stringValue());
	}
	
	/**
	 * Sets the field name of the HTML input field.
	 * 
	 * @param TechDivision_Lang_String $oldKey The HTML input field name
	 * @return TDProject_Report_Model_Widget_ReportField
	 * 		The instance itself
	 */
	public function setOldKey(TechDivision_Lang_String $oldKey)
	{
		$this->_oldKey = $oldKey;
		return $this;
	}
	
	/**
     * (non-PHPdoc)
	 * @see TDProject_Report_Model_Widget_Interfaces_ReportField::getOldKey()
	 */
	public function getOldKey()
	{
		return $this->_oldKey;
	}
	
	/**
	 * Sets the name of the JasperServer parameter
	 * necessary to print the report
	 * 
	 * @param TechDivision_Lang_String $oldKey The JasperServer parameter name
	 * @return TDProject_Report_Model_Widget_ReportField
	 * 		The instance itself
	 */
	public function setNewKey(TechDivision_Lang_String $newKey)
	{
		$this->_newKey = $newKey;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Report_Model_Widget_Interfaces_ReportField::getNewKey()
	 */
	public function getNewKey()
	{
		return $this->_newKey;
	}
	
	/**
	 * Sets the report fields parameter Map.
	 * 
	 * @param TechDivision_Collections_Interfaces_Map $params
	 * 		The report fields parameter Map
	 * @return TDProject_Report_Model_Widget_ReportField
	 * 		The instance itself
	 */
	public function setParams(TechDivision_Collections_Interfaces_Map $params)
	{
		$this->_params = $params;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Report_Model_Widget_Interfaces_ReportField::getParams()
	 */
	public function getParams()
	{
		return $this->_params;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Report_Model_Widget_Interfaces_ReportField::setValue()
	 */
	public function setValue(TechDivision_Lang_String $key, TechDivision_Lang_Object $value)
	{
		$this->getParams()->add($key, $value);
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Report_Model_Widget_Interfaces_ReportField::getValue()
	 */
	public function getValue(TechDivision_Lang_String $key)
	{
		return $this->getParams()->get($key);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Report_Model_Widget_Interfaces_ReportField::removeValue()
	 */
	public function removeValue(TechDivision_Lang_String $key)
	{
		$this->getParams()->remove($key);
		return $this;
	}
	
	/**
	 * Sets the report field instance to handle
	 * the conversion for.
	 * 
	 * @return TDProject_Report_Model_Entities_ReportField
	 * 		The report field entity
	 */
	public function setReportField(TDProject_Report_Model_Entities_ReportField $reportField)
	{
		$this->_reportField = $reportField;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Report_Model_Widget_Interfaces_ReportField::getReportField()
	 */
	public function getReportField()
	{
		return $this->_reportField;
	}
}