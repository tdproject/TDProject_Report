<?php

/**
 * TDProject_Report_Model_Assembler_Report
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
class TDProject_Report_Model_Assembler_Report 
    extends TDProject_Core_Model_Assembler_Abstract {

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_Report_Model_Assembler_Report($container);
    }
        
    /**
     * Returns a VO with the data of the report
     * with the passed ID.
     * 
     * @param TechDivision_Lang_Integer $reportId
     * 		The report ID to return the VO for
     * @return TDProject_Report_Common_ValueObjects_ReportViewData
     * 		The requested VO
     */
    public function getReportViewData(
        TechDivision_Lang_Integer $reportId = null) {
        // load the LocalHome
        $home = TDProject_Report_Model_Utils_ReportUtil::getHome($this->getContainer());
		// check if a report ID was passed
		if ($reportId == null) {
    		// if not, initialize a new report
    		$reportViewData = $home->epbCreate();
		} else {
		    // if yes, load the report
			$report = $home->findByPrimaryKey($reportId);
    		//create new reportViewData-object with the data from the report
    		$reportViewData 
    		    = new TDProject_Report_Common_ValueObjects_ReportViewData(
    			    $report);	
    		//get the entry-fields for the report
    		$reportFields = $this->getReportFieldData($reportId);
    		//add the fields to the vo
    		$reportViewData->setFields($reportFields);
		}
        // return the assembled VO
		return $reportViewData;
    }

    
    /**
     * Returns an ArrayList with all reports 
     * assembled as LVO's.
     * 
     * @return TechDivision_Collections_ArrayList
     * 		The requested reports LVO's
     */
    public function getReportLightValues() 
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the reports
        $reports = TDProject_Report_Model_Utils_ReportUtil::getHome($this->getContainer())
            ->findAll();
        // assemble the reports
        foreach ($reports as $report) {
            $list->add($report->getLightValue());
        }
        // return the ArrayList with the ReportLightValues
        return $list;
    }

    /**
     * Creates a list of all entry-fields for the report with the given id.
     * 
     * @param TechDivision_Lang_Integer $reportId
     * @return TechDivision_Collections_ArrayList
     */
    public function getReportFieldData(TechDivision_Lang_Integer $reportId)
    {
        //find alle fields for the report with the given id
        $fieldList = TDProject_Report_Model_Utils_ReportFieldUtil::getHome($this->getContainer())
        	->findAllByReportIdFk($reportId);
        //create collection to store the results
        $list = new TechDivision_Collections_ArrayList();
        // iterate over the fieldlist and prepare the data (to render HTML values)
        foreach ($fieldList as $field) {
            // initialize the DTO
            $dto = new TDProject_Report_Common_ValueObjects_ReportFieldData(
            	$field->getReportFieldClass()
            );
            // set the field-name
            $dto->setName($field->getName());            
            // get the data for the field if available
            $dataSourceName = $dto->getClassDataSource();
            // if a datasource is available
            if ($dataSourceName && !$dataSourceName->equals(new TechDivision_Lang_String()))  {
	            // add the data to the DTO
	            $dto->setData($this->newInstance($dataSourceName)->getData());
            }
            //add the report field DTO to the Collection
            $list->add($dto);
        }
        // return the initialized Collection
        return $list;
    }
        
    /**
     * Returns a DTO with the data of the project with the passed ID, 
     * attached with the available reports.
     * 
     * @param TechDivision_Lang_Integer $reportId
     * 		The report ID to return the DTO for
     * @return TDProject_Report_Common_ValueObjects_ProjectViewData
     * 		The requested DTO
     */
    public function getProjectViewData(
        TechDivision_Lang_Integer $projectId) {
        // load the LocalHome
        $home = TDProject_Project_Model_Utils_ProjectUtil::getHome($this->getContainer());
	    // if yes, load the project
		$project = $home->findByPrimaryKey($projectId);
        // assembled the DTO		
		$dto = new TDProject_Report_Common_ValueObjects_ProjectViewData(
			$project
		);
		// set the available reports for the project
		$dto->setReports($this->getReportLightValues());
		// set the system users
		$dto->setUsers(
			TDProject_Core_Model_Assembler_User::create($this->getContainer())
				->getUserLightValues()
		);
		// return the assembled DTO
		return $dto;
    }

    /**
     * Connects to the JasperServer, loads the report with the passed
     * data and returns the result, usually a PDF binary.
     * 
     * @param TDProject_Report_Common_ValueObjects_ParameterData $dto
     * 		The DTO with the requested report unit and the parameters
     * @return TDProject_Report_Common_ValueObjects_ReportViewData
     * 		The requested VO
     * @throws TDProject_Report_Common_Exceptions_InvalidUnitException
     * 		Is thrown if the passed report is not available in the JasperServer
     */
    public function renderReport(
   		TDProject_Report_Common_ValueObjects_ParameterData $dto)
    {
    	// render the report and return the ID
		$reportId = TDProject_Report_Model_Actions_ReportRendered::create($this->getContainer())
				->renderReport($dto);
		// load the DTO and return it
    	return $this->getReportViewData($reportId);
    }
	
	/**
	 * Creates a new instance of the requested class and
	 * returns it.
	 * 
	 * @param TechDivision_Lang_String $className
	 * 		Name of the class to create and return a new instance for
	 * @return TechDivision_Lang_Object The requested class instance
	 */
	public function newInstance(TechDivision_Lang_String $className)
	{
		return $this->getContainer()->newInstance($className->stringValue());
	}
}