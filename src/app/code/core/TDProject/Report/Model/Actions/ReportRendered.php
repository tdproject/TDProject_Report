<?php

/**
 * TDProject_Report_Model_Actions_ReportRendered
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
class TDProject_Report_Model_Actions_ReportRendered
    extends TDProject_Core_Model_Actions_Abstract {
	
	/**
	 * The path for the directory to store the rendered reports to.
	 * @var string
	 */
	const DIRECTORY = '/Reports/Rendered/';

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_Report_Model_Actions_ReportRendered($container);
    }
    
    /**
     * Returns the PEAR system configuration instance.
     * 
     * @return PEAR_Config The PEAR system configuration
     */
    public function getSystemConfig()
    {
    	return $this->getContainer()->getSystemConfig();
    }

	/**
	 * Loads the media directory from the system settings.
	 *
	 * @return string The path to the media directory
	 */
	public function getMediaDirectory()
	{
		// load the data directory
		$dataDir = $this->getSystemConfig()->get('data_dir');
		// initialize a new LocalHome to load the settings
		$settings = TDProject_Core_Model_Utils_SettingUtil::getHome($this->getContainer())
			->findAll();
		// return the directory for storing media data
		foreach ($settings as $setting) {
			return $dataDir . DIRECTORY_SEPARATOR .  $setting->getMediaDirectory();
		}
	}

	/**
	 * Concatenates the passed filename to the path
	 * with the media directory and returns it.
	 *
	 * @param string $filename The filename of the calculation
	 * @return The full path to store the file
	 */
	public function getFilename($filename)
	{
		return $this->getMediaDirectory() . self::DIRECTORY . $filename;
	}

    /**
     * Connects to the JasperServer, loads the report with the passed
     * data and returns the result, usually a PDF binary.
     * 
     * @param TDProject_Report_Common_ValueObjects_ParameterData $dto
     * 		The DTO with the requested report unit and the parameters 
     * @return TechDivision_Lang_Integer The ID of the rendered report
     * @throws TDProject_Report_Common_Exceptions_InvalidUnitException
     * 		Is thrown if the passed report is not available in the JasperServer
     */
    public function renderReport(
    	TDProject_Report_Common_ValueObjects_ParameterData $dto)
    {
		// load the user
		$user = TDProject_Core_Model_Utils_UserUtil::getHome($this->getContainer())
			->findByPrimaryKey($userId = $dto->getUserId());
    	// load the report to render
    	$report = TDProject_Report_Model_Utils_ReportUtil::getHome($this->getContainer())
    		->findByUnit(
		    	$unit = new TechDivision_Lang_String(
		    		$dto->getUnit()->__toString()
		    	)
    		);
    	// check if the passed report was found
    	if ($report === null) {
    		throw new TDProject_Report_Common_Exceptions_InvalidUnitException(
	        	'Can\'find report unit ' . $unit->__toString()
    		);
    	}
    	// set the JasperServer connection data
    	$jasperUrl = "http://<jasperserver>:<jasperverport>/jasperserver/services/repository?wsdl";
    	$jasperUsername = "tdproject";
    	$jasperPassword = "tdproject";
    	// initialize the JasperServer client
    	$client = new TDProject_Report_Model_Services_JasperReports_Client(
    		$jasperUrl,
    		$jasperUsername,
    		$jasperPassword
    	);
    	// set the paramter
    	$reportUnit = $report->getUnit()->__toString();
    	$reportFormat = $dto->getFormat()->__toString();
    	// create a HashMap with the passed user values
    	$reportParams = TechDivision_Collections_HashMap::fromArray($dto->getParams());
    	// prepare params
    	foreach ($report->getReportFields() as $reportField) {
    		TDProject_Report_Model_Widget_ReportField::create($this->getContainer())
	    		->setReportField($reportField)
	    		->setParams($reportParams)
	    		->init()
	    		->convert();
    	}
    	// prepare the report format
    	$format = $dto->getFormat()->toString()->toLowerCase();
    	// initialize the filename
    	$filename = $this->getFilename(
    		$report->getReportId() . '-' . date('Ymd-His', time()) . '.' . $format
    	);
    	// load and return the report   	
    	$data = $client->printReport($reportUnit, $reportFormat, $reportParams);
		// create a new renedered report entity
		$reportRendered = TDProject_Report_Model_Utils_ReportRenderedUtil::getHome($this->getContainer())
			->epbCreate();
		// set the data
		$reportRendered->setReportIdFk($reportId = $report->getReportId());
		$reportRendered->setUserIdFk($userId);
		$reportRendered->setUsername($user->getUsername());
		$reportRendered->setFilename(new TechDivision_Lang_String(basename($filename)));
		$reportRendered->setFormat($format);
		$reportRendered->setCreatedAt(new TechDivision_Lang_Integer(time()));
		// store the report entity
		$reportRendered->create();
    	// save the report
    	if (!file_put_contents($filename, $data, true)) {
    		throw new Exception("Can't render report $filename");
    	}
		// return the ID of the rendered report
		return $reportId;
    }
}