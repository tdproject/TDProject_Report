<?php

/**
 * TDProject_Report_Common_Helper_Format
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package     TDProject_Report
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Common_Helper_Format
{
	
	/**
	 * JasperServer key for PDF format
	 * @var string
	 */
	const PDF = 'PDF';
	
	/**
	 * JasperServer key for HTML format
	 * @var string
	 */
	const HTML = 'HTML';
	
    /**
     * The report format.
     * @var string
     */
	protected $_format = '';
	
	/**
	 * The content type of the report format.
	 * @var string
	 */
	protected $_contentType = '';
	
	/**
	 * Array with all available report formats.
	 * @var array
	 */
	protected $_formats = array(
	    TDProject_Report_Common_Helper_Format::PDF => 'application/pdf',
	    TDProject_Report_Common_Helper_Format::HTML => 'text/html' 
	);
	
	/**
	 * Private constructor for marking
	 * the class as utiltiy.
	 *
	 * @return void
	 */
	protected function __construct(TechDivision_Lang_String $format) 
	{
	    if ($format->length() === 0) {
    	    throw new Exception("No preview format requested");
	    } else {
    	    if (!array_key_exists($format->toUpperCase()->__toString(), $this->_formats)) {
    	        throw new Exception("Invalid preview format '$format' requested");
    	    }
	    
            $this->_format = $format->__toString();
            $this->_contentType = new TechDivision_Lang_String(
                $this->_formats[$format->__toString()]
            );
	    }
	}
	
	/**
	 * Factory method for creating a new report Format.
	 * 
	 * @param string $unit The reports format key
	 * @return TDProject_Report_Common_Helper_Format
	 * 		The Format instance
	 */
	public static function create(
	    $format = TDProject_Report_Common_Helper_Format::PDF) {
	    return new TDProject_Report_Common_Helper_Format(
	        new TechDivision_Lang_String($format)
	    );
	}
	
	/**
	 * Returns the report's format key as string.
	 * 
	 * @return string The format key
	 */
	public function __toString()
	{
	    return $this->_format;
	}
	
	/**
	 * Returns the report's format key as String.
	 * 
	 * @return TechDivision_Lang_String The format key
	 */
	public function toString()
	{
		return new TechDivision_Lang_String($this->_format);
	}
	
	/**
	 * Returns the format's content type as string.
	 * 
	 * @return string The format's content type.
	 */
	public function getContentType()
	{
	    return $this->_contentType;
	}
	
	/**
	 * File suffix for the report format as string.
	 * 
	 * @return string The file suffix for the report format.
	 */
	public function getFileSuffix()
	{
	    return end(explode('/', $this->_contentType));
	}
}