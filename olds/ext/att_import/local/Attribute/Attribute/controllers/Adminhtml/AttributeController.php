<?php

class Attribute_Attribute_Adminhtml_AttributeController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("attribute/attribute")->_addBreadcrumb(Mage::helper("adminhtml")->__("Attribute  Manager"),Mage::helper("adminhtml")->__("Attribute Manager"));
				return $this;
		}
		public function indexAction() 
		{
			
			
				
				
			    $this->_title($this->__("Attribute"));
			    $this->_title($this->__("Manager Attribute"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Attribute"));
				$this->_title($this->__("Attribute"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("attribute/attribute")->load($id);
				if ($model->getId()) {
					Mage::register("attribute_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("attribute/attribute");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Attribute Manager"), Mage::helper("adminhtml")->__("Attribute Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Attribute Description"), Mage::helper("adminhtml")->__("Attribute Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("attribute/adminhtml_attribute_edit"))->_addLeft($this->getLayout()->createBlock("attribute/adminhtml_attribute_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("attribute")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Attribute"));
		$this->_title($this->__("Attribute"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("attribute/attribute")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("attribute_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("attribute/attribute");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Attribute Manager"), Mage::helper("adminhtml")->__("Attribute Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Attribute Description"), Mage::helper("adminhtml")->__("Attribute Description"));


		$this->_addContent($this->getLayout()->createBlock("attribute/adminhtml_attribute_edit"))->_addLeft($this->getLayout()->createBlock("attribute/adminhtml_attribute_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();

				
				if ($post_data) {

					try {
						
						if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
							try {
								$fileName       = $_FILES['file']['name'];
								$fileExt        = strtolower(substr(strrchr($fileName, "."), 1));
								$fileNamewoe    = rtrim($fileName, $fileExt);
								$fileName       = str_replace(' ', '', $fileNamewoe) . '.' . $fileExt;

								$uploader       = new Varien_File_Uploader('file');
								$uploader->setAllowedExtensions(array('png', 'jpg', 'csv')); //allowed extensions
								$uploader->setAllowRenameFiles(false);
								$uploader->setFilesDispersion(false);
								$path = Mage::getBaseDir('media') . DS . 'attribute';
								if(!is_dir($path)){
									mkdir($path, 0777, true);
								}
								$uploader->save($path . DS, $fileName );
							} catch (Exception $e) {
								echo $e->getMessage();
							}
							echo "<pre>"; print_r($_FILES); echo "</pre>";
							$file = fopen($path . DS. $fileName,"r");
							$k=0;
							$filearray =array();
							while(! feof($file))
								{
								if($k>0){		
								$filearray [] = fgetcsv($file);
								
								}
								 $k++;
								}
								
								$color1 = array();
								$color2 = array();
								foreach($filearray as $key=>$attrarray){
									if($key>0){
										$color1[] = $attrarray[0];
										$color2[] = $attrarray[1];
									}
								}
								echo "<pre>"; print_r($color1); echo "</pre>";
								echo "<pre>"; print_r($color2); echo "</pre>";
						
						}
						$attribute_code = 'size';
						$allStores = Mage::app()->getStores();
						$attr_model = Mage::getModel('catalog/resource_eav_attribute');
						$attribute_details = Mage::getSingleton("eav/config")->getAttribute('catalog_product', $attribute_code);
						$attrdata = $attribute_details->getData();
						$storeId = 1;
						$aattribute = $attr_model->load($attribute_details->getAttributeId());
						$options = $attribute_details->setStoreId($storeId)->getSource()->getAllOptions(true);
						$option['attribute_id'] = $attribute_details->getAttributeId();
						//$option['value'][4][1] = "Medium";
						
						
						$color = array('Red','Green','Blue','Pink','Yellow','orange');	
						
						for($iCount=0;$iCount<sizeof($color1);$iCount++){
						   $option['value']['option'.$iCount][0] = $color1[$iCount];
						   $option['value']['option'.$iCount][1] = $color1[$iCount];
						   //$option['value']['option'.$iCount][1] = $color[$iCount];
						}
						$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
						$setup->addAttributeOption($option);
						//$setup->addAttributeOption($option);
						
						
						//echo "<pre>"; print_r($aattribute); echo "</pre>";
				

						$model = Mage::getModel("attribute/attribute")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Attribute was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setAttributeData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setAttributeData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}

		
		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("attribute/attribute");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('attribute_ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("attribute/attribute");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'attribute.csv';
			$grid       = $this->getLayout()->createBlock('attribute/adminhtml_attribute_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'attribute.xml';
			$grid       = $this->getLayout()->createBlock('attribute/adminhtml_attribute_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
