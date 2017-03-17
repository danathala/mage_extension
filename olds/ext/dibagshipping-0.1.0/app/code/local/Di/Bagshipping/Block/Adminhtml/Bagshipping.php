<?php

/**
 * Baggage Freight Module 
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */
class Di_Bagshipping_Block_Adminhtml_Bagshipping extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_bagshipping';
        $this->_blockGroup = 'bagshipping';
        $this->_headerText = Mage::helper('bagshipping')->__('Product Manager');
        $this->_addButtonLabel = Mage::helper('bagshipping')->__('Upload CSV');
        parent::__construct();
    }

}