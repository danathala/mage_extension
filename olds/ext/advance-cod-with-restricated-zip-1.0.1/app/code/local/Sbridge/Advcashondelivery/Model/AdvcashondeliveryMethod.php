<?php
class Sbridge_Advcashondelivery_Model_AdvcashondeliveryMethod  extends Mage_Payment_Model_Method_Abstract {

	protected $_code  = 'advcashondelivery';  

	//Display Instructions 
	protected $_formBlockType = 'advcashondelivery/form_advcashondelivery';

	public function isAvailable($quote = null) {
		$checkResult = new StdClass;
		$isActive = (bool)(int)$this->getConfigData('active', $quote ? $quote->getStoreId() : null);
		$checkResult->isAvailable = $isActive;
		$checkResult->isDeniedInConfig = !$isActive; // for future use in observers
		$billEnabled=Mage::getStoreConfig('payment/advcashondelivery/zipvalidaddress');

		if($billEnabled==0) {
			$billingAddress = $quote->getBillingAddress();
			$zip = $billingAddress->getData(postcode);
			$backzip = Mage::getStoreConfig('payment/advcashondelivery/zip');
			$temp1 = split('[,]', $backzip);
			$s=sizeof($temp1);
			for($i=0; $i<= $s;$i++) {
			if($zip==$temp1[$i]) {
				Mage::dispatchEvent('payment_method_is_active', array(
					'result'          => $checkResult,
					'method_instance' => $this,
					'quote'           => $quote,
				));
				// disable method if it cannot implement recurring profiles management and there are recurring items in quote
				if ($checkResult->isAvailable) {
					$implementsRecurring = $this->canManageRecurringProfiles();
					// the $quote->hasRecurringItems() causes big performance impact, thus it has to be called last
					if ($quote && !$implementsRecurring && $quote->hasRecurringItems()) {
						$checkResult->isAvailable = false;
					}
				}
				return $checkResult->isAvailable;
			}
			}
		} else {
			$shippingAddress = $quote->getShippingAddress();
			$zip = $shippingAddress->getData(postcode);       
			$backzip = Mage::getStoreConfig('payment/advcashondelivery/zip');
			$temp1 = split('[,]', $backzip);
			$s=sizeof($temp1);
			for($i=0; $i<= $s;$i++) {
				if($zip==$temp1[$i]) {
					Mage::dispatchEvent('payment_method_is_active', array(
						'result'          => $checkResult,
						'method_instance' => $this,
						'quote'           => $quote,
					));
					// disable method if it cannot implement recurring profiles management and there are recurring items in quote
					if ($checkResult->isAvailable) {
						$implementsRecurring = $this->canManageRecurringProfiles();
						// the $quote->hasRecurringItems() causes big performance impact, thus it has to be called last
						if ($quote && !$implementsRecurring && $quote->hasRecurringItems()) {
							$checkResult->isAvailable = false;
						}
					}
					return $checkResult->isAvailable;
				}
			}

		}
		if($backzip=="" || $backzip== null) {
			Mage::dispatchEvent('payment_method_is_active', array(
			'result'          => $checkResult,
			'method_instance' => $this,
			'quote'           => $quote,
			));
			// disable method if it cannot implement recurring profiles management and there are recurring items in quote
			if ($checkResult->isAvailable) {
				$implementsRecurring = $this->canManageRecurringProfiles();
				// the $quote->hasRecurringItems() causes big performance impact, thus it has to be called last
				if ($quote && !$implementsRecurring && $quote->hasRecurringItems()) {
					$checkResult->isAvailable = false;
				}
			}
			return $checkResult->isAvailable;
		}
	}
	public function getInstructions() {
		return trim($this->getConfigData('instructions'));
	}
	
	public function assignData($data) {
		$details = array();
		if ($this->getPayableTo()) {
			$details['payable_to'] = $this->getPayableTo();
		}
		if ($this->getMailingAddress()) {
			$details['mailing_address'] = $this->getMailingAddress();
		}
		if (!empty($details)) {
			$this->getInfoInstance()->setAdditionalData(serialize($details));
		}
		return $this;
	}

	public function getPayableTo() {
		return $this->getConfigData('payable_to');
	}
	
	public function getMailingAddress() {
		return $this->getConfigData('mailing_address');
	}

}
