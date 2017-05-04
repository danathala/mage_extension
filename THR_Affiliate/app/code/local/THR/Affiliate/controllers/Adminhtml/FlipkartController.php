<?php
class THR_Affiliate_Adminhtml_FlipkartController extends Mage_Adminhtml_Controller_Action {
   
   protected function _isAllowed() {
      //return Mage::getSingleton('admin/session')->isAllowed('affiliate/affiliatebackend');
      return true;
   }

   public function indexAction() {
      $this->loadLayout();
      $this->_title($this->__("Backend Page Title"));
      $this->renderLayout();
   }
}