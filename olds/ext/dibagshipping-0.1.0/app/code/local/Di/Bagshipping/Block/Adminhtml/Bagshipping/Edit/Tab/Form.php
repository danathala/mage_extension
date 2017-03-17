<?php

/**
 * Baggage Freight Module 
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */

class Di_Bagshipping_Block_Adminhtml_Bagshipping_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('bagshipping_form', array('legend' => Mage::helper('bagshipping')->__('Product Information')));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('bagshipping')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));

        $fieldset->addField('filename', 'file', array(
            'label' => Mage::helper('bagshipping')->__('File'),
            'required' => false,
            'name' => 'filename',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('bagshipping')->__('Status'),
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('bagshipping')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('bagshipping')->__('Disabled'),
                ),
            ),
        ));


        if (Mage::getSingleton('adminhtml/session')->getBagshippingData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBagshippingData());
            Mage::getSingleton('adminhtml/session')->setBagshippingData(null);
        } elseif (Mage::registry('bagshipping_data')) {
            $form->setValues(Mage::registry('bagshipping_data')->getData());
        }
        return parent::_prepareForm();
    }

}