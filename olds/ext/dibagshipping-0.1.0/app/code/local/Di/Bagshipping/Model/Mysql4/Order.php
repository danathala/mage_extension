<?php

/**
 * Baggage Freight Module 
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */

class Di_Bagshipping_Model_Mysql4_Order extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct() {
        $this->_init('bagshipping/order', 'order_id');
    }

}