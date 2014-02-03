<?php

/**
 * TDProject_Report_Common_ValueObjects_ProjectViewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TechDivision/Collections/ArrayList.php';
require_once 'TechDivision/Model/Interfaces/Value.php';
require_once 'TDProject/Project/Model/Entities/Project.php';
require_once 'TDProject/Project/Common/ValueObjects/ProjectValue.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the report handling 
 * for the project reports.
 *
 * Each class member reflects a database field and
 * the values of the related dataset.
 *
 * @category   	TDProject
 * @package     TDProject_Project
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Common_ValueObjects_ProjectViewData 
    extends TDProject_Project_Common_ValueObjects_ProjectValue 
    implements TechDivision_Model_Interfaces_Value {
    
    /**
     * The reports available for the project.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_reports = null;
    
    /**
     * The available system users.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_users = null;
    
    /**
     * The constructor intializes the DTO with the
     * values passed as parameter.
     *
     * @param TDProject_Project_Model_Entities_Project $project 
     * 		The project to initialize the DTO with
     * @return void
     */
    public function __construct(TDProject_Project_Model_Entities_Project $project)
    {
        // call the parents constructor
        parent::__construct($project);
        // initialize the ValueObject with the passed data
        $this->_reports = new TechDivision_Collections_ArrayList();
        $this->_users = new TechDivision_Collections_ArrayList();
    }
        
    /**
     * Sets the reports available for the project.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $projects
     * 		The reports available for the project
     * @return void
     */
    public function setReports(
        TechDivision_Collections_Interfaces_Collection $reports) {
        $this->_reports = $reports;
    }
        
    /**
     * Returns the reports available for the project.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The reports available for the project
     */
    public function getReports()
    {
        return $this->_reports;
    }
        
    /**
     * Sets the available system users.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $users
     * 		The available system users
     * @return void
     */
    public function setUsers(
        TechDivision_Collections_Interfaces_Collection $users) {
        $this->_users = $users;
    }
        
    /**
     * Returns the available system users.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The available system users
     */
    public function getUsers()
    {
        return $this->_users;
    }
}