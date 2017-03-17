<?php
class Attribute_Attribute_Block_Adminhtml_Attribute_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("attribute_form", array("legend"=>Mage::helper("attribute")->__("Item information")));

				
						$fieldset->addField("file", "text", array(
						"label" => Mage::helper("attribute")->__("Name"),
						"name" => "name",
						));
						$fieldset->addField("name", "file", array(
						"label" => Mage::helper("attribute")->__("File"),
						"name" => "file",
						));

				if (Mage::getSingleton("adminhtml/session")->getAttributeData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getAttributeData());
					Mage::getSingleton("adminhtml/session")->setAttributeData(null);
				} 
				elseif(Mage::registry("attribute_data")) {
				    $form->setValues(Mage::registry("attribute_data")->getData());
				}
				return parent::_prepareForm();
		}
}
