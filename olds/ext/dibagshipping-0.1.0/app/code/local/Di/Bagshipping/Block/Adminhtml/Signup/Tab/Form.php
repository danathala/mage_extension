<?php

/**
 * Baggage Freight Module 
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */

class Di_Bagshipping_Block_Adminhtml_Signup_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('owner_form', array('legend' => Mage::helper('bagshipping')->__('Store Owner Setup')));

        $fieldset->addField('owner_id', 'hidden', array(
            'name' => 'owner_id',
        ));

        $fieldset->addField('contact_name', 'text', array(
            'label' => Mage::helper('bagshipping')->__('Contact Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'contact_name',
        ));

        $fieldset->addField('email', 'text', array(
            'label' => Mage::helper('bagshipping')->__('Storeowner Email'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'email',
        ));

        $fieldset->addField('password', 'password', array(
            'label' => Mage::helper('bagshipping')->__('Storeowner Password'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'password',
        ));

        $fieldset->addField('company', 'text', array(
            'label' => Mage::helper('bagshipping')->__('Collection Company'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'company',
        ));

        $fieldset->addField('collect_email', 'text', array(
            'label' => Mage::helper('bagshipping')->__('Collection Email Address'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'collect_email',
        ));


        $fieldset->addField('address', 'text', array(
            'label' => Mage::helper('bagshipping')->__('Collection Address'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'address',
        ));


        $fieldset->addField('address1', 'text', array(
            'label' => Mage::helper('bagshipping')->__('Collection Address'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'address1',
        ));


        $fieldset->addField('collect_country', 'text', array(
            'label' => Mage::helper('bagshipping')->__('Collection Country'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'collect_country',
        ));


        $fieldset->addField('collect_city', 'text', array(
            'label' => Mage::helper('bagshipping')->__('Collection City'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'collect_city',
        ));


        $fieldset->addField('collect_state', 'text', array(
            'label' => Mage::helper('bagshipping')->__('Collection State'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'collect_state',
        ));


        $fieldset->addField('collect_zip', 'text', array(
            'label' => Mage::helper('bagshipping')->__('Collection Zip'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'collect_zip',
        ));


        $fieldset->addField('collect_phno', 'text', array(
            'label' => Mage::helper('bagshipping')->__('Collection Phone'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'collect_phno',
        ));


        if (Mage::getSingleton('adminhtml/session')->getOwnerData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getOwnerData());
            Mage::getSingleton('adminhtml/session')->setOwnerData(null);
        } elseif (Mage::registry('owner_data')) {
            $form->setValues(Mage::registry('owner_data')->getData());
        }
        return parent::_prepareForm();
    }

}