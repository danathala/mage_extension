<?php

/**
 * Baggage Freight Module - Controller
 *
 * @category   DI
 * @package    Di_Bagshipping
 * @author     DI Dev Team
 * @website    http://www.di.net.au/
 */

class Di_Bagshipping_Adminhtml_BagshippingController extends Mage_Adminhtml_Controller_action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('bagshipping/items')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

        return $this;
    }

    public function indexAction() {
        $this->_initAction()
                ->renderLayout();
    }

    public function ordergridAction() {

        $this->_initAction()
                ->renderLayout();
    }

    public function viewordersAction() {
        $owner = Mage::getModel('bagshipping/owner')->getCollection();
        $own = $owner->getFirstItem();
        if ($own):
            $email = $own->getEmail();
            $password = $own->getPassword();
            $url = "http://www.baggagefreight.com.au/api/authloginstore.aspx?username=" . $email . "&password=" . $password;
            $this->_redirectUrl($url);
        else:
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bagshipping')->__('Error! You have not configured Baggage Freight account.'));
            $this->_redirect('*/*/');
        endif;
    }

    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('bagshipping/bagshipping')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            Mage::register('bagshipping_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('bagshipping/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Product Manager'), Mage::helper('adminhtml')->__('Item Manager'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('bagshipping/adminhtml_bagshipping_edit'))
                    ->_addLeft($this->getLayout()->createBlock('bagshipping/adminhtml_bagshipping_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bagshipping')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {

            if (isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
                try {
                    /* Starting upload */
                    $uploader = new Varien_File_Uploader('filename');

                    // Any extention would work
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png', 'csv'));
                    $uploader->setAllowRenameFiles(false);

                    // Set the file upload mode 
                    // false -> get the file directly in the specified folder
                    // true -> get the file in the product like folders 
                    //	(file.jpg will go in something like /media/f/i/file.jpg)
                    $uploader->setFilesDispersion(false);

                    // We set media as the upload dir
                    $path = Mage::getBaseDir('media') . DS;
                    $uploader->save($path, $_FILES['filename']['name']);
                } catch (Exception $e) {
                    
                }

                //this way the name is saved in DB
                $data['filename'] = $_FILES['filename']['name'];
            }

            $csvFile = $path . $data['filename'];

            $row = 1;
            $product = Mage::getModel('catalog/product');
            if (($handle = fopen("$csvFile", "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($row != 1) {
                        $num = count($data);
                        $header = array('SKU', 'Length', 'Width', 'Height', 'Weight');
                        $productId = $product->getIdBySku($data[0]);
                        if ($productId) {
                            // check if product id exist in excel table.
                            $excel = Mage::getModel('bagshipping/bagshipping')->getCollection();
                            $excel->addFieldToFilter('sku', $data['0']);
                            if ($excel->getSize() > 0):
                                Mage::log('Product already exist in the excel table', null, 'bagshipping.log');
                            else:
                                // as per csv format - field Mapping
                                $excelModel = Mage::getModel('bagshipping/bagshipping');
                                $excelModel->setData('pid', $productId);
                                $excelModel->setData('sku', $data['0']);
                                $excelModel->setData('length', $data['1']);
                                $excelModel->setData('width', $data['2']);
                                $excelModel->setData('height', $data['3']);
                                $excelModel->setData('weight', $data['4']);
                                $excelModel->save();
                            // as per csv format - field Mapping                        
                            endif;
                        }
                        $row++;
                    } else {
                        $row++;
                    }
                }
                fclose($handle);
            }


            try {
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bagshipping')->__('File was uploaded successfully & Product information is imported'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);


                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit');
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bagshipping')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('bagshipping/bagshipping');

                $model->setId($this->getRequest()->getParam('id'))
                        ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction() {
        $testmoduleIds = $this->getRequest()->getParam('bagshipping');
        if (!is_array($testmoduleIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($testmoduleIds as $testmoduleId) {
                    $testmodule = Mage::getModel('bagshipping/bagshipping')->load($testmoduleId);
                    $testmodule->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($testmoduleIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction() {
        $testmoduleIds = $this->getRequest()->getParam('bagshipping');
        if (!is_array($testmoduleIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($testmoduleIds as $testmoduleId) {
                    $testmodule = Mage::getSingleton('bagshipping/bagshipping')
                            ->load($testmoduleId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) were successfully updated', count($testmoduleIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction() {
        $fileName = 'bagshipping.csv';
        $content = $this->getLayout()->createBlock('bagshipping/adminhtml_bagshipping_grid')
                ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction() {
        $fileName = 'bagshipping.xml';
        $content = $this->getLayout()->createBlock('bagshipping/adminhtml_bagshipping_grid')
                ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream') {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }

}