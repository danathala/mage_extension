<?php
class THR_Affiliate_Block_Adminhtml_Amazon_Form_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {
   protected function _prepareForm() {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('form_form', array('legend'=>Mage::helper('form')->__('Item information')));
      
      $fieldset->addField('title', 'text', array(
         'label'     => Mage::helper('affiliate')->__('Title'),
         'class'     => 'required-entry',
         'required'  => true,
         'name'      => 'title',
      ));
      
      return parent::_prepareForm();
   }
}   