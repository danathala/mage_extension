<?php

/**
 * Baggage Freight Module 
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */
class Di_Bagshipping_Block_Adminhtml_Ordergrid extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_ordergrid';
        $this->_blockGroup = 'bagshipping';
        $this->_headerText = Mage::helper('bagshipping')->__('Order Manager');
        parent::__construct();
    }

}