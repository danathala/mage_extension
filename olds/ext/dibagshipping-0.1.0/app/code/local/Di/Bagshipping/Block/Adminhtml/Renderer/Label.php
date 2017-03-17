<?php

/**
 * Baggage Freight Module 
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */
class Di_Bagshipping_Block_Adminhtml_Renderer_Label extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        $value = $row->getData($this->getColumn()->getIndex());
        $baggae_url = "http://www.baggagefreight.com.au/api/getLabel.aspx?orderid=" . $value['BOrderId'];
        $reponse_code = file_get_contents($baggae_url);

        $returnString = '';
        if ($reponse_code == "0" || $reponse_code == "") {
            $returnString = "N.A";
        } else {
            $returnString = '<a href = "http://www.baggagefreight.com.au/shipping-label/' . $reponse_code . '" target = "_blank">View Label</a>';
        }

        return $returnString;
    }

}

?>