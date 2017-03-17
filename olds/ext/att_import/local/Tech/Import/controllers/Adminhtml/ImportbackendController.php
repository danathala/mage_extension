<?php
class Tech_Import_Adminhtml_ImportbackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Backend Page Title"));
	   $this->renderLayout();
    }
	
	
	public function importAttrAction () {
		
		// print_r($_POST);
		//$data	=	$this->getRequest()->getPost()
		
		if(isset($_FILES['m_csv']['name']) and (file_exists($_FILES['m_csv']['tmp_name']))) {
			
			try{
			$filename	=	$_FILES['m_csv']['name'];
			
			$path = Mage::getBaseDir('media') . DS . 'csv_attribute' . DS;
			
			$uploader = new Varien_File_Uploader('m_csv');
			$uploader->setAllowedExtensions(array('csv'));
			$uploader->setAllowRenameFiles(false);
			$uploader->setFilesDispersion(false);
			
			$new_file_name	=	'import_' . time() . '.' . pathinfo($filename, PATHINFO_EXTENSION);;
			
			if($uploader->save($path, $new_file_name)) {
				
				$path . $new_file_name; 
				$this->_getValues($path . $new_file_name);
				
			} else {
				echo 'error found';
			}
				
			} catch(Exception $e) {
				
				echo 'Error found . ' . $e->getMessage();
			}

		
		} else {
			
			echo 'Please upload a csv file to import manufacturers';
			
		}
		//$this->_getValues(NULL); //testing;
	}
	
	
	public function _getValues($file) {
		
		$file_read = fopen($file,"r");
		$manufacturers = array();
		$x = 1;
		while(!feof($file_read)) {
			$data = fgetcsv($file_read);
			if($data[0] != '') {
				$manufacturers['option_' . $x] = array($data[0],$data[0]);
			}
			$x++;
		}
		
		Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
		
		$_attribute =  Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', 'manufacturer');
		$_attribute->setOption(array(
			//'value' => array('option_1' => array('DEll', 'DEll2')),
			'value' => $manufacturers,
			'order'	=> array(1),
			'delete'	=> array()
		));
		
		
		try {
		 $_attribute->save();
		 //echo 'Manufacturer successfully imported';
		 Mage::getSingleton('adminhtml/session')->addSuccess('Manufacturer successfully imported'); 
		 $this->_redirect('*/*/index');
		 
		} catch(Exception $e){
		 echo 'Import Error::'.$e->getMessage();   
		}
		
		fclose($file_read);
		
	}
	
	
	
	
}