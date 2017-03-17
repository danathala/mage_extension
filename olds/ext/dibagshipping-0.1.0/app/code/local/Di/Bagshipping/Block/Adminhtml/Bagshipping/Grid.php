<?php
/**
 * Baggage Freight Module 
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */

class Di_Bagshipping_Block_Adminhtml_Bagshipping_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('bagshippingGrid');
        $this->setDefaultSort('bagshipping_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('bagshipping/bagshipping')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('bagshipping_id', array(
            'header' => Mage::helper('bagshipping')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'bagshipping_id',
        ));

        $this->addColumn('pid', array(
            'header' => Mage::helper('bagshipping')->__('Product Id'),
            'align' => 'left',
            'index' => 'pid',
        ));

        $this->addColumn('sku', array(
            'header' => Mage::helper('bagshipping')->__('SKU'),
            'align' => 'left',
            'index' => 'sku',
        ));

        $this->addColumn('weight', array(
            'header' => Mage::helper('bagshipping')->__('Weight'),
            'align' => 'left',
            'index' => 'weight',
        ));
        $this->addColumn('height', array(
            'header' => Mage::helper('bagshipping')->__('Height'),
            'align' => 'left',
            'index' => 'height',
        ));
        $this->addColumn('width', array(
            'header' => Mage::helper('bagshipping')->__('Width'),
            'align' => 'left',
            'index' => 'width',
        ));


        $this->addColumn('length', array(
            'header' => Mage::helper('bagshipping')->__('Length'),
            'align' => 'left',
            'index' => 'length',
        ));


        $this->addColumn('action', array(
            'header' => Mage::helper('bagshipping')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('bagshipping')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('bagshipping')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('bagshipping')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('bagshipping_id');
        $this->getMassactionBlock()->setFormFieldName('bagshipping');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('bagshipping')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('bagshipping')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}