<?php


class Attribute_Attribute_Block_Adminhtml_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_attribute";
	$this->_blockGroup = "attribute";
	$this->_headerText = Mage::helper("attribute")->__("Attribute Manager");
	$this->_addButtonLabel = Mage::helper("attribute")->__("Add New Item");
	parent::__construct();
	
	}

}