<?php

/**
 * Baggage Freight Module 
 *
 * @category   DI
 * @package    DI_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */

class Di_Bagshipping_Block_Adminhtml_Bagshipping_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('bagshipping_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('bagshipping')->__('Upload CSV file.'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('bagshipping')->__('Upload CSV Information'),
          'title'     => Mage::helper('bagshipping')->__('Upload CSV Information'),
          'content'   => $this->getLayout()->createBlock('bagshipping/adminhtml_bagshipping_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}