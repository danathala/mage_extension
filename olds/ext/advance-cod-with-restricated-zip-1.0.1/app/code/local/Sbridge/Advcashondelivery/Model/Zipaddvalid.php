<?php

    /**
    * Setubridge Technolabs
    * http://www.setubridge.com/
    * @author SetuBridge
    * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
    **/
?>
<?php
class Sbridge_Advcashondelivery_Model_Zipaddvalid
{

    /**
    * Options getter
    *
    * @return array
    */
    public function toOptionArray()
    {
        return array(
        /*array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Yes')),*/

        /*array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('No')),*/
        array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('Billing Address')),
        array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Shipping Address')),
        );
    }

    /**
    * Get options in "key-value" format
    *
    * @return array
    */
    public function toArray()
    {
        return array(
        0 => Mage::helper('adminhtml')->__('Billing Address'),
        1 => Mage::helper('adminhtml')->__('Shipping Address'),
        );
    }

}
