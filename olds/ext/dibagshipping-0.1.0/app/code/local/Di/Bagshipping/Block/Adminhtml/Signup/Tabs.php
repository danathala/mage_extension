<?php

/**
 * Baggage Freight Module 
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */
class Di_Bagshipping_Block_Adminhtml_Signup_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('bagshipping_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bagshipping')->__('Signup'));
    }

    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('bagshipping')->__('Sign-up for Bagshipping Account'),
            'title' => Mage::helper('bagshipping')->__('Sign-up for Bagshipping Account'),
            'content' => $this->getLayout()->createBlock('bagshipping/adminhtml_signup_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}