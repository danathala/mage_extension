<?php

/**
 * Baggage Freight Module - Order Model
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */

class Di_Bagshipping_Model_Order extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('bagshipping/order');
    }

}