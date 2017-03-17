<?php
class Attribute_Attribute_Model_Mysql4_Attribute extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("attribute/attribute", "attribute_id");
    }
}