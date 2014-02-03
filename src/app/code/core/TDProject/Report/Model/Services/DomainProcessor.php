<?php

/**
 * TDProject_Report_Model_Services_DomainProcessor
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
class TDProject_Report_Model_Services_DomainProcessor
    extends TDProject_Report_Model_Services_AbstractDomainProcessor
{

	/**
	 * This method returns the logger of the requested
	 * type for logging purposes.
	 *
     * @param string The log type to use
	 * @return TechDivision_Logger_Logger Holds the Logger object
	 * @throws Exception Is thrown if the requested logger type is not initialized or doesn't exist
	 * @deprecated 0.6.25 - 2011/12/19
	 */
    protected function _getLogger(
        $logType = TechDivision_Logger_System::LOG_TYPE_SYSTEM)
    {
    	return $this->getLogger();
    }   
    
    /**
     * This method returns the logger of the requested
     * type for logging purposes.
     *
     * @param string The log type to use
     * @return TechDivision_Logger_Logger Holds the Logger object
     * @since 0.6.26 - 2011/12/19
     */
    public function getLogger(
    	$logType = TechDivision_Logger_System::LOG_TYPE_SYSTEM)
    {
    	return $this->getContainer()->getLogger();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/Project/Common/Delegates/Interfaces/DomainProcessorDelegate#getReportOverviewData()
     */
	public function getReportOverviewData()
	{
	    try {
    		// assemble and return the Collection
    		return TDProject_Report_Model_Assembler_Report::create($this->getContainer())
    		    ->getReportLightValues();
	    } 
	    catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#getReportViewData(TechDivision_Lang_Integer $reportId = null)
     */
	public function getReportViewData(TechDivision_Lang_Integer $reportId = null)
	{
    	try {
    		// assemble and return the initialized VO
    		return TDProject_Report_Model_Assembler_Report::create($this->getContainer())
    		    ->getReportViewData($reportId);
	    } 
	    catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/Project/Common/Delegates/Interfaces/DomainProcessorDelegate#saveReport(TDProject_Report_Common_ValueObjects_ReportLightValue $lvo)
     */
	public function saveReport(
        TDProject_Report_Common_ValueObjects_ReportLightValue $lvo) {
		try {
			// begin the transaction
			$this->beginTransaction();
			// lookup report ID
			$reportId = $lvo->getReportId();
			// store the report
			if ($reportId->equals(new TechDivision_Lang_Integer(0))) {
	            // create a new report
				$report = TDProject_Report_Model_Utils_ReportUtil::getHome($this->getContainer())
				    ->epbCreate();
				// set the data
				$report->setName($lvo->getName());
				$report->setDescription($lvo->getDescription());
				$report->setUnit($lvo->getUnit());
				$reportId = $report->create();
			} else {
			    // update the report
				$report = TDProject_Report_Model_Utils_ReportUtil::getHome($this->getContainer())
				    ->findByPrimaryKey($reportId);
				$report->setName($lvo->getName());
				$report->setDescription($lvo->getDescription());
				$report->setUnit($lvo->getUnit());
				$report->update();
			}
			// commit the transaction
			$this->commitTransaction();
			// return the report ID
			return $reportId;
		} 
		catch(TechDivision_Model_Interfaces_Exception $e) {
			// rollback the transaction
			$this->rollbackTransaction();
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

    /**
     * (non-PHPdoc)
     * @see TDProject/Project/Common/Delegates/Interfaces/DomainProcessorDelegate#deleteReport(TechDivision_Lang_Integer $reportId)
     */
    public function deleteReport(TechDivision_Lang_Integer $reportId) {
        try {
            // start the transaction
            $this->beginTransaction();
            // load the project
            $report = TDProject_Report_Model_Utils_ReportUtil::getHome($this->getContainer())
                ->findByPrimaryKey($reportId);
            // delete the report itself
            $report->delete();
            // commit the transcation
            $this->commitTransaction();
        } 
        catch(TechDivision_Model_Interfaces_Exception $e) {
			// rollback the transaction
			$this->rollbackTransaction();
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/Project/Common/Delegates/Interfaces/DomainProcessorDelegate#view(TDProject_Report_Common_ValueObjects_ParameterData $dto)
     */
	public function renderReport(
		TDProject_Report_Common_ValueObjects_ParameterData $dto)
	{
	    try {
            // start the transaction
            $this->beginTransaction();	    	
    		// load the report and return it
    		$dto = TDProject_Report_Model_Assembler_Report::create($this->getContainer())
    			->renderReport($dto);
            // commit the transcation
            $this->commitTransaction();
            // return the DTO with the report data
            return $dto;
	    } 
	    catch(TechDivision_Model_Interfaces_Exception $e) {
			// rollback the transaction
			$this->rollbackTransaction();
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#getProjectViewData(TechDivision_Lang_Integer $projectId)
     */
	public function getProjectViewData(TechDivision_Lang_Integer $projectId)
	{
    	try {
    		// assemble and return the initialized DTO
    		return TDProject_Report_Model_Assembler_Report::create($this->getContainer())
    		    ->getProjectViewData($projectId);
	    } 
	    catch(TechDivision_Model_Interfaces_Exception $e) {
	    	// log the exception message
	    	$this->_getLogger()->error($e->__toString());
	    	// throw a new exception
	    	throw new TDProject_Core_Common_Exceptions_SystemException(
	    		$e->__toString()
	    	);
	    }
	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject/Report/Common/Delegates/Interfaces/DomainProcessorDelegate#getReportFieldViewData(TechDivision_Lang_Integer $reportFieldId = null)
	 */
	public function getReportFieldViewData(
		TechDivision_Lang_Integer $reportFieldId = null)
	{
		try {
			// assemble and return the initialized VO
			return TDProject_Report_Model_Assembler_ReportField::create($this->getContainer())
				->getReportFieldViewData($reportFieldId);
		}
		catch(TechDivision_Model_Interfaces_Exception $e) {
			// log the exception message
			$this->_getLogger()->error($e->__toString());
			// throw a new exception
			throw new TDProject_Core_Common_Exceptions_SystemException(
				$e->__toString()
			);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject/Report/Common/Delegates/Interfaces/DomainProcessorDelegate#saveReportField(TDProject_Report_Common_ValueObjects_ReportFieldLightValue $lvo)
	 */
	public function saveReportField(
		TDProject_Report_Common_ValueObjects_ReportFieldLightValue $lvo)
	{
		try {
			// start the transaction
			$this->beginTransaction();
			// save the report field
			$reportFieldId = TDProject_Report_Model_Actions_ReportField::create($this->getContainer())
				->saveReportField($lvo);
			// commit the transcation
			$this->commitTransaction();
			// return the ID
			return $reportFieldId;
		} 
		catch(TechDivision_Model_Interfaces_Exception $e) {
			// rollback the transaction
			$this->rollbackTransaction();
			// log the exception message
			$this->_getLogger()->error($e->__toString());
			// throw a new exception
			throw new TDProject_Core_Common_Exceptions_SystemException(
				$e->__toString()
			);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject/Report/Common/Delegates/Interfaces/DomainProcessorDelegate#deleteReportField(TechDivision_Lang_Integer $reportFieldId)
	 */
	public function deleteReportField(
		TechDivision_Lang_Integer $reportFieldId)
	{
		try {
			// start the transaction
			$this->beginTransaction();
			// load the report field
			$reportField = TDProject_Report_Model_Utils_ReportFieldUtil::getHome($this->getContainer())
				->findByPrimaryKey($reportFieldId);
			// delete the report field itself
			$reportField->delete();
			// commit the transcation
			$this->commitTransaction();
		} 
		catch(TechDivision_Model_Interfaces_Exception $e) {
			// rollback the transaction
			$this->rollbackTransaction();
			// log the exception message
			$this->_getLogger()->error($e->__toString());
			// throw a new exception
			throw new TDProject_Core_Common_Exceptions_SystemException(
				$e->__toString()
			);
		}
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#getReportRenderedViewData(TechDivision_Lang_Integer $reportRenderedId)
     */
	public function getReportRenderedViewData(
		TechDivision_Lang_Integer $reportRenderedId)
	{
    	try {
    		// assemble and return the initialized DTO
    		return TDProject_Report_Model_Assembler_ReportRendered::create($this->getContainer())
    		    ->getReportRenderedViewData($reportRenderedId);
	    } 
	    catch(TechDivision_Model_Interfaces_Exception $e) {
	    	// log the exception message
	    	$this->_getLogger()->error($e->__toString());
	    	// throw a new exception
	    	throw new TDProject_Core_Common_Exceptions_SystemException(
	    		$e->__toString()
	    	);
	    }
	}
}