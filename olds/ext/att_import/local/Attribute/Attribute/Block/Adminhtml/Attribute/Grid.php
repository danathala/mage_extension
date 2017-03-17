<?php

class Attribute_Attribute_Block_Adminhtml_Attribute_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("attributeGrid");
				$this->setDefaultSort("attribute_id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("attribute/attribute")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("attribute_id", array(
				"header" => Mage::helper("attribute")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "attribute_id",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("attribute")->__("Name"),
				"index" => "name",
				));
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('attribute_id');
			$this->getMassactionBlock()->setFormFieldName('attribute_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_attribute', array(
					 'label'=> Mage::helper('attribute')->__('Remove Attribute'),
					 'url'  => $this->getUrl('*/adminhtml_attribute/massRemove'),
					 'confirm' => Mage::helper('attribute')->__('Are you sure?')
				));
			return $this;
		}
			

}