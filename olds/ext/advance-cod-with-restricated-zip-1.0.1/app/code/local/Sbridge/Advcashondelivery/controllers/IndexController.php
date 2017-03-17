<?php
class Sbridge_Advcashondelivery_IndexController extends Mage_Core_Controller_Front_Action {

	public function indexAction() {

		$zip 					=	$this->getRequest()->getParam('zipcode');
		$pinCodes 			=	array();
		$allowedZip			=	Mage::getStoreConfig('payment/advcashondelivery/zip');
		$pinCodes 			=	explode(",", $allowedZip);
		$success 			=	Mage::getStoreConfig('payment/advcashondelivery/sucess_message');
		$failure 			=	Mage::getStoreConfig('payment/advcashondelivery/error_message');
		$delivery_message	=	Mage::getStoreConfig('payment/advcashondelivery/delivery_message');
		$trimedZip = trim($zip);
		$response = array();
		
		if(!empty($trimedZip)) {
			//checking if COD available
			if (in_array($trimedZip, $pinCodes)) {
				$response['result'] = true;
				$response['message'] .= '<li>' . $success . '</li>';
				//$response['message'] .= '<li>' . $delivery_message . '</li>';
			} else {
				$response['result'] = false;
				$response['error'] .= '<li>' . $failure . '</li>';
			}
		} else {
			$response['result'] = false;
			$response['message'] = 'zip field empty';
		}
		echo json_encode($response);exit;
   }
 
}