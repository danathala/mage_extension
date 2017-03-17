<?php

/**
 * Baggage Freight Module 
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */

class Di_Bagshipping_Block_Bagshipping extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getBagshipping() {
        if (!$this->hasData('bagshipping')) {
            $this->setData('bagshipping', Mage::registry('bagshipping'));
        }
        return $this->getData('bagshipping');
    }

}