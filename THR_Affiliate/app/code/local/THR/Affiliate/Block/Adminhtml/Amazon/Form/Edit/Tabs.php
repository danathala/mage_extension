<?php
class THR_Affiliate_Block_Adminhtml_Amazon_Form_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
   public function __construct() {
      parent::__construct();
      $this->setId('form_tabs');
      $this->setDestElementId('edit_form'); // this should be same as the form id define above
      $this->setTitle(Mage::helper('affiliate')->__('Product Information'));
   }
   
   protected function _beforeToHtml() {
      $this->addTab('form_section', array(
         'label'     => Mage::helper('affiliate')->__('Item Information'),
         'title'     => Mage::helper('affiliate')->__('Item Information'),
         'content'   => $this->getLayout()->createBlock('form/adminhtml_amazon_form_edit_tab_form')->toHtml(),
      ));
      
      return parent::_beforeToHtml();
   }
}   