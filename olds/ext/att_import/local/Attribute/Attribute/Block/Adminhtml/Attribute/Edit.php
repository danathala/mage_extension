<?php
	
class Attribute_Attribute_Block_Adminhtml_Attribute_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "attribute_id";
				$this->_blockGroup = "attribute";
				$this->_controller = "adminhtml_attribute";
				$this->_updateButton("save", "label", Mage::helper("attribute")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("attribute")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("attribute")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("attribute_data") && Mage::registry("attribute_data")->getId() ){

				    return Mage::helper("attribute")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("attribute_data")->getId()));

				} 
				else{

				     return Mage::helper("attribute")->__("Add Item");

				}
		}
}