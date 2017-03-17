<?php

require 'app/Mage.php';


$app	=	Mage::app();


//$collection	=	$app->getModel('');


$categoryid = 535;

//$category = new Mage_Catalog_Model_Category();
// $category->load($categoryid);
//$collection = $category->getProductCollection();
$collection = Mage::getModel('catalog/product')->getCollection();
$collection->addAttributeToSelect('*'); 

$rows		=	array();
// $rows[]	=	array('SKU','ProductName','DESCRIPTION','PRODUCT URL','URL PATH','IMAGE URL','PRICE','QTY','Stock Availability','Brand');
$rows[]	=	array('SKU','ProductName','PRICE');

foreach ($collection as $_product) :

	$product		=	Mage::getModel('catalog/product')->load($_product->getId());
	$qty			=	number_format($product->getStockItem()->getQty(),0);
	
	$stock		=	($qty > 0) ? 'In Stock' : 'Out of Stock';
	
	// $rows[]		=	array($_product->getSku(),$_product->getName(),$_product->getDescription(),$_product->getProductUrl(),Mage::getUrl() . $_product->getUrlPath(),(string)Mage::helper('catalog/image')->init($product, 'image'),$_product->getFinalPrice(),$qty, $stock,$_product->getAttributeText('manufacturer'));
	$rows[]		=	array($_product->getSku(),$_product->getName(),$_product->getFinalPrice());
	//break;

endforeach;

echo count($rows) . '<br />';

echo '<pre>' . print_r($rows, true) . '</pre>';

$file_name	=	'custom_export/file_' . date('d_m_y_h_i_s',time()) . '.csv';
$fp = fopen($file_name, 'w');

foreach ($rows as $fields) {
   fputcsv($fp, $fields);
}

fclose($fp);


sleep(2);

/* header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename=' . Mage::getUrl() . $file_name);
header('Pragma: no-cache');
readfile($file_name); */

echo $file_name . '<br />';
?>


<a href="<?php echo Mage::getUrl() . $file_name; ?>" download>Click to Download</a>
