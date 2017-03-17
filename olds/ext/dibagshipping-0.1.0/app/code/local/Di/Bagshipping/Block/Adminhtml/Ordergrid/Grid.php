<?php

/**
 * Baggage Freight Module 
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */

class Di_Bagshipping_Block_Adminhtml_Ordergrid_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('orderGrid');
        $this->setDefaultSort('order_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('bagshipping/order')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('order_id', array(
            'header' => Mage::helper('bagshipping')->__('Id'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'order_id',
        ));

		 $this->addColumn('increment_id', array(
            'header' => Mage::helper('bagshipping')->__('Order Id'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'increment_id',
        ));

        $this->addColumn('carrier', array(
            'header' => Mage::helper('bagshipping')->__('Carrier'),
            'align' => 'left',
            'index' => 'carrier',
        ));

        $this->addColumn('service', array(
            'header' => Mage::helper('bagshipping')->__('Service'),
            'align' => 'left',
            'index' => 'service',
        ));

        $this->addColumn('booking_price', array(
            'header' => Mage::helper('bagshipping')->__('Booking Price'),
            'align' => 'left',
            'index' => 'booking_price',
        ));
        $this->addColumn('shipping_price', array(
            'header' => Mage::helper('bagshipping')->__('Shipping Price'),
            'align' => 'left',
            'index' => 'shipping_price',
        ));
        $this->addColumn('user_id', array(
            'header' => Mage::helper('bagshipping')->__('User Id'),
            'align' => 'left',
            'index' => 'user_id',
        ));


        $this->addColumn('border_id', array(
            'header' => Mage::helper('bagshipping')->__('Baggage Freight Id'),
            'align' => 'left',
            'index' => 'border_id',
        ));

        $this->addColumn('label', array(
            'header' => 'Label',
            'index' => 'order_id',
            'renderer' => 'Di_Bagshipping_Block_Adminhtml_Renderer_Label'
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