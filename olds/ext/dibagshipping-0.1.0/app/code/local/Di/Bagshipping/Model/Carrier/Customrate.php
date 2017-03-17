<?php

class Di_Bagshipping_Model_Carrier_Customrate extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface {

    protected $_code = 'bagshipping';
    protected $_isFixed = true;

    public function collectRates(Mage_Shipping_Model_Rate_Request $request) {

        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $result = Mage::getModel('shipping/rate_result');

        $method = Mage::getModel('shipping/rate_result_method');
        $method->setCarrier('bagshipping');
        $method->setCarrierTitle($this->getConfigData('title'));
        $method->setMethod('bagshipping');
        $method->setMethodTitle($this->getConfigData('name'));
		
		$method1 = Mage::getModel('shipping/rate_result_method');
        $method1->setCarrier('bagshipping');
		$method1->setCarrierTitle($this->getConfigData('title'));
        $method1->setMethod('bagshipping1');
		$method1->setMethodTitle($this->getConfigData('name'));
		

        $quote = Mage::getSingleton('checkout/session')->getQuote();

        $shippingAddress = $quote->getShippingAddress();
        $sName = $shippingAddress->getName();
        $sCompany = $shippingAddress->getData("company");
        $sStreet = $shippingAddress->getData("street");
        $sPostcode = $shippingAddress->getData("postcode");
        $sCity = $shippingAddress->getData("city");
        $sRegionCode = $shippingAddress->getRegionCode();
        $sRegion = $shippingAddress->getRegion();
        $sCountry = $shippingAddress->getCountry();
        $sCountryModelName = $shippingAddress->getCountryModel()->getName();


        $cartItems = $quote->getAllVisibleItems();
        $weight = 0;
        $name['baggage'] = array();
        $cartGrossTotal = 0;

        
        foreach ($cartItems as $item) {
            $quantity = $item->getQty();
            $weightPerItem = $item->getWeight();
            $weight += ($item->getWeight() * $item->getQty());

            for ($i = 1; $i <= $item->getQty(); $i++) {
                $name['baggage'][] = $item->getName();
                $unitPrice['baggage'][] = $item->getPrice();
                $sku['baggage'][] = $item->getSku();
                $ids['baggage'][] = $item->getProductId();
                $qty['baggage'][] = $item->getQty();
            //    $weight['baggage'][] = $item->getWeight();
                $cal_unit['baggage'][] = 'cm';
            }
            $cal_weight['baggage'][] = $item->getWeight() * $item->getQty();
            $cartGrossTotal += $item->getPriceInclTax() * $item->getQty();

            //get the data from excel file database if there

            $bProduct = Mage::getModel('bagshipping/bagshipping')->getCollection()->addProductFilter($item->getProductId());
            $mItem = $bProduct->getFirstItem();

            for ($i = 1; $i <= $item->getQty(); $i++) {
                if (count($mItem) > 0) {
                    if (!($mItem->getData('length'))) {
                        $excel_length['baggage'][] = 0;
                    } else {
                        $excel_length['baggage'][] = $mItem->getData('length');
                    }
                    if (!($mItem->getData('width'))) {
                        $excel_width['baggage'][] = 0;
                    } else {
                        $excel_width['baggage'][] = $mItem->getData('width');
                    }
                    if (!($mItem->getData('height'))) {
                        $excel_height['baggage'][] = 0;
                    } else {
                        $excel_height['baggage'][] = $mItem->getData('height');
                    }

                    if (!($mItem->getData('weight'))) {
                        $excel_weight['baggage'][] = $item->getWeight();
                    } else {
                        $excel_weight['baggage'][] = $mItem->getData('weight');
                    }
                } else {
                    $excel_weight['baggage'][] = $item->getWeight();
                    $excel_height['baggage'][] = 0;
                    $excel_width['baggage'][] = 0;
                    $excel_length['baggage'][] = 0;
                }
            }
        } //end of foreach

        
        $urlWeight = implode(',', $excel_weight['baggage']);
        $urlLength = implode(',', $excel_length['baggage']);
        $urlWidth = implode(',', $excel_width['baggage']);
        $urlHeight = implode(',', $excel_height['baggage']);
        $urlUnit = implode(',', $cal_unit['baggage']);
        $cartSku = implode(',', $sku['baggage']);
        $urlAmount = $cartGrossTotal;


//get the store owner information for collection information 

        $store_owner_info = Mage::getModel('bagshipping/owner')->getCollection();
        $owner = $store_owner_info->getFirstItem();

        $cCountry = $owner->getData('collect_country');
        $cState = $owner->getData('collect_state');
        $cCity = $owner->getData('collect_city');
        $cPin = $owner->getData('collect_zip');
      
        


        $data = array('cCountry' => $cCountry,
            'cState' => $cState,
            'cCity' => $cCity,
            'cPin' => $cPin,
            'dCountry' => $sCountryModelName,
            'dState' => $sRegionCode,
            'dCity' => $sCity,
            'dPin' => $sPostcode,
            'Weight' => $urlWeight,
            'Length' => $urlLength,
            'Width' => $urlWidth,
            'Height' => $urlHeight,
            'Unit' => $urlUnit,
            'Amount' => $urlAmount,
        );
		



        $ch = curl_init('http://www.baggagefreight.com.au/api/minrate.aspx');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $value = curl_exec($ch);



        curl_close($ch);
        $shipvalues = explode(':', $value);

        //keping all the req information in the seiion

        Mage::getSingleton('core/session')->setMyFullShipDetails($value);
        Mage::getSingleton('core/session')->setArrWeight($urlWeight);
        Mage::getSingleton('core/session')->setArrLength($urlLength);
        Mage::getSingleton('core/session')->setArrWidth($urlWidth);
        Mage::getSingleton('core/session')->setArrHeight($urlHeight);
        Mage::getSingleton('core/session')->setArrUnit($urlUnit);
        Mage::getSingleton('core/session')->setStrDescription($cartSku);


		$carrier = $shipvalues[1];
		$service = $shipvalues[2];
		$transit = $shipvalues[4];
		$arrTransit = explode(" ",$transit);
		$transit = $arrTransit[0];
		$warranty = $shipvalues[5];
		$show_ship_cost = $shipvalues[0];
		
		$cost_with_warranty = floatval($show_ship_cost)+floatval($warranty);
		
		Mage::getSingleton('core/session')->setBfShipCost($shipvalues[0]);
		Mage::getSingleton('core/session')->setBfWarranty($warranty);
		Mage::getSingleton('core/session')->setBfTransit($transit);
		Mage::getSingleton('core/session')->setBfCarrier($carrier);
		Mage::getSingleton('core/session')->setBfService($service);
		
		$show_carrier_1 = $carrier."[".$service."] ( Without Transit Warranty )";
		$show_carrier_2 = $carrier."[".$service."] ( With Transit Warranty )";

        $method->setPrice($show_ship_cost);
        $method->setCost(2);

        $method->setCarrierTitle($carrier);
        $method->setMethodTitle($show_carrier_1);

        $result->append($method);
		
		if(floatval($warranty)>0)
		{ 
				$method1->setPrice($cost_with_warranty);
				$method1->setCost(2);
				
				$method1->setCarrierTitle($carrier);
				$method1->setMethodTitle($show_carrier_2);
				 
				$result->append($method1);
		}

        return $result;
    }

    public function getAllowedMethods() {
        return array('bagshipping' => $this->getConfigData('name'));
    }

}