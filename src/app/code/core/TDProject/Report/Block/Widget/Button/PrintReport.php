<?php

/**
 * TDProject_Report_Block_Widget_Button_CleanCache
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Button.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Button.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Form.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2011 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Markus Berwanger <m.berwanger@techdivision.com>
 */
class TDProject_Report_Block_Widget_Button_PrintReport
    extends TDProject_Core_Block_Widget_Button
    implements TDProject_Core_Interfaces_Block_Widget_Button {

    /**
     * The unique block name.
     * @var string
     */
    const BLOCK_NAME = 'printReport';

    /**
     * Initialize the button with the context.
     *
     * @param string $blockTitle The button label
     * @return void
     */
    public function __construct(
        TDProject_Core_Interfaces_Block_Widget_Form $form,
        $blockTitle) {
        // call the parent constructor
        parent::__construct($form->getContext(), self::BLOCK_NAME, $blockTitle);
    	// set the icon to use
		$this->setIcon('ui-icon-print');
		// set the onClick event
		$this->setOnClick(
			'$("#' . $form->getFormName() . '").submit(); return false;'
		);
    }
}