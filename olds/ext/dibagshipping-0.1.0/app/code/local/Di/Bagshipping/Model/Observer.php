<?php

class Di_Bagshipping_Model_Observer {

	public function saveOrderinBagshipping($observer) {
	
		$orderId = (int)current($observer->getEvent()->getOrderIds());
        $order = null;
		if($orderId){
			$oOrder = Mage::getModel('sales/order')->load($orderId);
		} else {
			$incrementId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
			$oOrder = Mage::getModel('sales/order')->loadByIncrementId($incrementId);
		}

		
		$shipping_method = $oOrder->getShippingMethod();
		$special_instruction = $oOrder->getCustomerNote();
		
		if($shipping_method=="bagshipping_bagshipping" || $shipping_method=="bagshipping_bagshipping1")
		{
			$_totalData =$oOrder->getData();
			$shipping_address = $_totalData['shipping_address_id'];
			$address = Mage::getModel('sales/order_address')->load($shipping_address);
			
			
			$base_subtotal = $_totalData['base_subtotal'];
			$base_grand_total = $_totalData['base_grand_total'];
			$base_shipping_amount = Mage::getSingleton('core/session')->getBfShipCost();

			
			$collection = Mage::getModel('bagshipping/owner')->getCollection();
			$id = $collection->getFirstItem()->getOwnerId();
			$model = Mage::getModel('bagshipping/owner')->load($id);
			
			
			/*
				$resource = Mage::getSingleton('core/resource');
				$readConnection = $resource->getConnection('core_read');
				$table = $resource->getTableName('bagshipping/storeowner');
				$write = Mage::getSingleton('core/resource');
				$writeConnection = $resource->getConnection('core_write');
				$table_excel = $resource->getTableName('bagshipping/excel');
				$table_order = $resource->getTableName('bagshipping/order');	
				$sql = "SELECT * FROM $table LIMIT 1";
				//$data = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($sql);
			*/


			
			$Country_name = $model->getData('collect_country');
			$strCollectCompany = $model->getData('company');
			$strCollContactName = $model->getData('contact_name');
			$strCollectAddress = $model->getData('address');
			$strCollectAddress1 = $model->getData('address1');
			$strCollectCity = $model->getData('collect_city');
			$strCollectState = $model->getData('collect_state');
			$strCollectZip = $model->getData('collect_zip');
			$strCollectEmail = $model->getData('collect_email');
			$strCollectPhNo = $model->getData('collect_phno');
			$strEmail = $model->getData('email');
			$strPassword = $model->getData('password');
			$strCollectCountry = $Country_name;
			$strUrl = $_SERVER['HTTP_HOST'];
	



			$strDestContactName = $address->getData('firstname')." ".$address->getData('lastname');
			$strDestEmail = $address->getData('email');
			$strDestPhNo = $address->getData('telephone');
			$strDestCompany = $address->getData('company');
			$strDestAddress = $address->getData('street');
			$strDestAddress1 = '';

			$strDestCity = $address->getData('city');
			$strDestState = $address->getRegionCode();
			$strDestZip =  $address->getData('postcode');
			$strDestCountry = $address->getCountryModel()->getName();
			$address->getData('street');

			$Data = Mage::getSingleton('core/session')->getMyFullShipDetails();
			$urlWeight = Mage::getSingleton('core/session')->getArrWeight();
			$urlLength = Mage::getSingleton('core/session')->getArrLength();
			$urlWidth = Mage::getSingleton('core/session')->getArrWidth();
			$urlHeight = Mage::getSingleton('core/session')->getArrHeight();
			$urlUnit = Mage::getSingleton('core/session')->getArrUnit();
			$strDescription = Mage::getSingleton('core/session')->getStrDescription();
			$value = explode(':',$Data);
			
			if($shipping_method=="bagshipping_bagshipping")
			{
			    $coverCost = 0.00;
			}
			else
			{
			    $coverCost = floatval(Mage::getSingleton('core/session')->getBfWarranty());
			}
			
			$strTransitTime = Mage::getSingleton('core/session')->getBfTransit();



			$data = array(
					'strInvoiceNumber' => $oOrder->getIncrementId(),
					'strCarrier' => $value[1],
					'strService' => $value[2],
					'strTotalBookingRate' => $base_subtotal,
					'strBookingAmount' => $base_shipping_amount,
					'special_instruction' => $special_instruction,
					'strCollectCompany' => $strCollectCompany,
					'strCollContactName' => $strCollContactName,
					'strCollectAddress' => $strCollectAddress,
					'strCollectAddress1' => $strCollectAddress1,
					'strCollectCity' => $strCollectCity,
					'strCollectState' => $strCollectState,
					'strCollectZip' => $strCollectZip,
					'strCollectCountry' => $strCollectCountry,
					'strCollectEmail' => $strCollectEmail,
					'strCollectPhNo' => $strCollectPhNo,
					'strEmail' => $strEmail,
					'strPassword' => $strPassword,
					'strDestContactName' => $strDestContactName,
					'strDestEmail' => $strDestEmail,
					'strDestPhNo' => $strDestPhNo,
					'strDestCompany' => $strDestCompany,
					'strDestAddress' => $strDestAddress,
					'strDestAddress1' => $strDestAddress1,
					'strDestCity' => $strDestCity,
					'strDestState' => $strDestState,
					'strDestZip' => $strDestZip,
					'strDestCountry' => $strDestCountry,
					'coverCost' => $coverCost,
					'strTransitTime' => $value[5],
					'strDescription' => $strDescription,
					'arrWeight' => $urlWeight,
					'arrLength' => $urlLength,
					'arrWidth' => $urlWidth,
					'arrHeight' => $urlHeight,
					'arrUnit' => $urlUnit,
					'strUrl' => $strUrl
					); 

				
				$ch = curl_init('http://www.baggagefreight.com.au/api/doBooking.aspx');
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
				curl_setopt($ch, CURLOPT_POST, 1);               
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);     
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
				$result = curl_exec($ch);

				$user_id = Mage::helper('customer')->getCustomer()->getId();	
			   if($result>0)
				{
					$order = Mage::getModel('bagshipping/order');
					$order->setData('increment_id',$oOrder->getIncrementId());
					$order->setData('carrier',$value[1]);
					$order->setData('service',$value[2]);
					$order->setData('booking_price',$base_grand_total);
					$order->setData('shipping_price',$base_shipping_amount);
					$order->setData('user_id',$user_id);
					$order->setData('border_id',$result);
					$order->save();
				}	
		}
	}
}