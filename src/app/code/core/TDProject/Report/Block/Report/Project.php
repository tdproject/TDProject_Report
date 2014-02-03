<?php

/**
 * TDProject_Report_Block_Report_Project
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Abstract.php';
require_once 'TDProject/Core/Controller/Util/WebRequestKeys.php';
require_once 'TDProject/Project/Controller/Util/WebRequestKeys.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Report_Block_Report_Project
    extends TDProject_Core_Block_Abstract {

    /**
     * The DTO with the acutal company data.
     * @var TDProject_Project_Common_ValueObjects_ProjectViewData
     */
    protected $_dto = null;

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context) {
        // set the internal name
        $this->_setBlockName('reports');
        // set the template name
        $this->_setTemplate('www/design/report/templates/report/project.phtml');
        // call the parent constructor
        parent::__construct($context);
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout()
    {
        // load the DTO from the request
        $this->_dto = $app->getRequest()->getAttribute(
            TDProject_Core_Controller_Util_WebRequestKeys::VIEW_DATA
        );
        // call the parent constructor
        parent::prepareLayout();
        // return the instance itself
        return $this;
    }

    /**
     * Returns the URL to view the passed report unit.
	 *
     * @return string the preview URL for the passed report
     */
    public function getReportViewParams($unit)
    {
        // initialize the params to add to the URL
        $params = array(
            TDProject_Report_Controller_Util_WebRequestKeys::UNIT =>
                $unit,
            TDProject_Report_Controller_Util_WebRequestKeys::FORMAT =>
                TDProject_Report_Common_Helper_Format::PDF,
            TDProject_Report_Controller_Util_WebRequestKeys::PARAMS =>
                array(
                    TDProject_Project_Controller_Util_WebRequestKeys
                        ::PROJECT_ID =>
                    $this->_dto->getProjectId()->intValue()
                )
        );
        // create and return the URL
        return implode('&', $this->_app->processUrlParams($params));
    }

    /**
     * Returns the URL to view the passed report unit.
	 *
     * @return string the preview URL for the passed report
     */
    public function getReportViewUrl($unit)
    {
        // initialize the params to add to the URL
        $params = array(
            TechDivision_Controller_Action_Controller::ACTION_PATH =>
            	'/report/view',
            TDProject_Application::PACKAGE_MODULE =>
            	'Report',
            TDProject_Application::REPLACE_PACKAGE =>
            	0,
            TDProject_Report_Controller_Util_WebRequestKeys::UNIT =>
                $unit,
            TDProject_Report_Controller_Util_WebRequestKeys::FORMAT =>
                TDProject_Report_Common_Helper_Format::PDF,
            TDProject_Report_Controller_Util_WebRequestKeys::PARAMS =>
                array(
                    TDProject_Project_Controller_Util_WebRequestKeys
                        ::PROJECT_ID =>
                    $this->_dto->getProjectId()->intValue()
                )
        );
        // create and return the URL
        return $this->getUrl($params);
    }

    /**
     * Returns a Collection with the available
     * system users.
     *
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The Collection with the available system users
     */
    public function getUsers()
    {
    	return $this->_dto->getUsers();
    }
}