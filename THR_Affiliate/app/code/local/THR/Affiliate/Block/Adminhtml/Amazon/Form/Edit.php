<?php
class THR_Affiliate_Block_Adminhtml_Amazon_Form_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

   public function __construct() {
      parent::__construct();
      
      $this->_objectId = 'id';
      $this->_blockGroup = 'affiliate';
      $this->_controller = 'adminhtml_amazon';
      
      $this->_updateButton('save', 'label', Mage::helper('affiliate')->__('Save'));
      $this->_updateButton('delete', 'label', Mage::helper('affiliate')->__('Delete'));
      
      $this->_addButton('saveandcontinue', array(
         'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
         'onclick'   => 'saveAndContinueEdit()',
         'class'     => 'save',
      ), -100);
   }

   public function getHeaderText() {
      return Mage::helper('affiliate')->__('My Form Container');
   }
}   