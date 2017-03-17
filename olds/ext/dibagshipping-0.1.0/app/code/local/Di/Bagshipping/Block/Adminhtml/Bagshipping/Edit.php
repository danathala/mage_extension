<?php

/**
 * Baggage Freight Module 
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */

class Di_Bagshipping_Block_Adminhtml_Bagshipping_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'bagshipping';
        $this->_controller = 'adminhtml_bagshipping';
        
        $this->_updateButton('save', 'label', Mage::helper('bagshipping')->__('Save File'));
        $this->_updateButton('delete', 'label', Mage::helper('bagshipping')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('bagshipping_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'bagshipping_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'bagshipping_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('bagshipping_data') && Mage::registry('bagshipping_data')->getId() ) {
            return Mage::helper('bagshipping')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('bagshipping_data')->getTitle()));
        } else {
            return Mage::helper('bagshipping')->__('Upload CSV file for package description	');
        }
    }
}