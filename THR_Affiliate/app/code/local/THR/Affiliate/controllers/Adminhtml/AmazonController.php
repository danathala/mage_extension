<?php
   echo $path =  Mage::getBaseDir('lib'). DS . 'affiliate' . DS . 'easyODS.php';
   // require_once($path);
class THR_Affiliate_Adminhtml_AmazonController extends Mage_Adminhtml_Controller_Action {
   
   protected function _isAllowed() {
      //return Mage::getSingleton('admin/session')->isAllowed('affiliate/affiliatebackend');
      return true;
   }
   
   public function indexAction() {
      $this->loadLayout();
      $this->_title($this->__("Backend Page Title"));
      $this->renderLayout();
   }
   
   public function saveAction() {
      if ($data = $this->getRequest()->getPost()) {
         print_r($data);
         EXIT;
      }
       
       
     /*  print_r($_POST);
      EXIT; */
   }
   
   
   public function newAction(){
      $this->_title($this->__("EnquiryNow"));
		$this->_title($this->__("Enquiry"));
		$this->_title($this->__("New Item"));
      
      $this->loadLayout();
      $this->_addContent($this->getLayout()->createBlock('affiliate/adminhtml_amazon_form_edit'))
             ->_addLeft($this->getLayout()->createBlock('affiliate/adminhtml_amazon_form_edit_tabs'));
      $this->renderLayout();
   }
   
     
}