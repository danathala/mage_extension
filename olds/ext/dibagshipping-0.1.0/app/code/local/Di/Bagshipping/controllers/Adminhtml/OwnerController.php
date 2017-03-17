<?php

/**
 * Baggage Freight Module - OwnerController
 *
 * @category   DI
 * @package    Di_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */

class Di_Bagshipping_Adminhtml_OwnerController extends Mage_Adminhtml_Controller_action {

    protected function _initAction() {
        $this->loadLayout();
        return $this;
    }

    public function indexAction() {
        $this->_initAction()
                ->renderLayout();
    }

    public function signupAction() {
        $id = $this->getRequest()->getParam('id');
        if ($id == '') {
            $collection = Mage::getModel('bagshipping/owner')->getCollection();
            if ($collection->getSize() == 0) {
                $model = Mage::getModel('bagshipping/owner');
            } else {
                $id = $collection->getFirstItem()->getOwnerId();
                $model = Mage::getModel('bagshipping/owner')->load($id);
            }
        } else {
            $model = Mage::getModel('bagshipping/owner')->load($id);
        }

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
     
            Mage::register('owner_data', $model);
            $this->loadLayout();
            $this->_setActiveMenu('bagshipping/owner');


            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('bagshipping/adminhtml_signup'))
                    ->_addLeft($this->getLayout()->createBlock('bagshipping/adminhtml_signup_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bagshipping')->__('Error! Please try again.'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction() {
        $this->_forward('signup');
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {



            $model = Mage::getModel('bagshipping/owner');
            $model->setData($data)
                    ->setId($this->getRequest()->getParam('owner_id'));

            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                            ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }

                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bagshipping')->__('Your form has been submitted successfully.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/signup', array('id' => $model->getOwnerId()));
                    return;
                }
                $this->_redirect('*/*/signup');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/signup', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bagshipping')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

}