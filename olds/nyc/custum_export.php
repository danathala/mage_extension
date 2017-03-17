<?php

require 'app/Mage.php';


$app	=	Mage::app();


//$collection	=	$app->getModel('');


$categoryid = 535;

// $category = new Mage_Catalog_Model_Category();
// $category->load($categoryid);
// $collection = $category->getProductCollection();
$collection = Mage::getModel('catalog/product')->getCollection();
$collection->addAttributeToSelect('*');

$rows		=	array();
$rows[]	=	array('CategoryName','ProductName','URL PATH','IMAGE URL','SKU','QTY','Stock Availability');

foreach ($collection as $_product) :

	$product		=	Mage::getModel('catalog/product')->load($_product->getId());
	$qty			=	number_format($product->getStockItem()->getQty(),0);
	
	$stock		=	($qty > 0) ? 'In Stock' : 'Out of Stock';
	
	$rows[]		=	array($category->getName(),$_product->getName(),$_product->getUrlPath(),(string)Mage::helper('catalog/image')->init($product, 'image'),$_product->getSku(),$qty, $stock);

endforeach;

echo count($rows) . '<br />';

echo '<pre>' . print_r($rows, true) . '</pre>';



function convert_to_csv($input_array, $output_file_name, $delimiter) {
	echo $output_file_name;
    /** open raw memory as file, no need for temp files */
    $temp_memory = fopen('php://memory', 'w');
    /** loop through array  */
    foreach ($input_array as $line) {
        /** default php csv handler **/
        fputcsv($temp_memory, $line, $delimiter);
    }
    /** rewrind the "file" with the csv lines **/
    fseek($temp_memory, 0);
    /** modify header to be downloadable csv file **/
    header('Content-Type: application/csv');
    header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
    /** Send file to browser for download */
    fpassthru($temp_memory);
}

convert_to_csv($rows, 'file_' . time() . '.csv', $delimiter)


/* $fp = fopen('custom_export/file______' . time() . '.csv', 'w');

foreach ($rows as $fields) {
   fputcsv($fp, $fields);
}

fclose($fp); */


/* 

$query	=	"
		SELECT p.entity_id AS prod,
		prod_varchar.value,
		p.sku AS sku,
		cp.category_id AS cp_category_id,
		cp.`position` AS cp_position,
		c.`entity_id` AS c_category_id,
		cat_varchar.value AS CatName,
		c.`entity_type_id` AS c_entity_type_id,
		c.`attribute_set_id` AS c_attribute_set_id,
		c.`parent_id` AS c_parent_id,
		c.`path` AS c_path,
		c.`position` AS c_position,
		c.`level` AS c_level,
		c.`children_count` AS c_children_count
		FROM catalog_product_entity AS p
		LEFT JOIN catalog_category_product AS cp
		ON p.entity_id = cp.product_id
		LEFT JOIN catalog_category_entity AS c
		ON cp.category_id = c.entity_id
		LEFT JOIN catalog_category_entity_varchar AS cat_varchar
		ON     c.entity_id = cat_varchar.entity_id
		AND cat_varchar.attribute_id = 111
		LEFT JOIN catalog_product_entity_varchar AS prod_varchar
		ON     p.entity_id = prod_varchar.entity_id
		AND prod_varchar.attribute_id = 96
		WHERE 1
		AND c.entity_id = category_id_here
;

";
 */



?>