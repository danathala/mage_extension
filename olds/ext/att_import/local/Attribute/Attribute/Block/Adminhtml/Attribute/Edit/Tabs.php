<?php
class Attribute_Attribute_Block_Adminhtml_Attribute_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("attribute_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("attribute")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("attribute")->__("Item Information"),
				"title" => Mage::helper("attribute")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("attribute/adminhtml_attribute_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
