<?php

/**
 * Baggage Freight Module 
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */
class Di_Bagshipping_Block_Adminhtml_Signup extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'bagshipping';
        $this->_controller = 'adminhtml';
        $this->_mode = 'signup';

        $this->_updateButton('save', 'label', Mage::helper('bagshipping')->__('Store Owner Signup'));
    }

    public function getHeaderText() {

        if (Mage::registry('owner_data') && Mage::registry('owner_data')->getOwnerId()) {
            return Mage::helper('bagshipping')->__("Edit Owner's Data -  '%s'", $this->htmlEscape(Mage::registry('owner_data')->getContactName()));
        } else {
            return Mage::helper('bagshipping')->__('Store Owner Setup');
        }
    }

}