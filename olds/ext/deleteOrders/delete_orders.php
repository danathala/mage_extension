<?php
error_reporting(0); 
require_once('app/Mage.php'); //Path to Magento
umask(0);
Mage::setIsDeveloperMode(true);
Mage::app('admin');

$orderCollection = Mage::getResourceModel('sales/order_collection');

$orderCollection
->addFieldToFilter('status', 'pending')
->addFieldToFilter('created_at', array(
	'lt' =>  new Zend_Db_Expr("DATE_ADD('".now()."', INTERVAL -'10:00' HOUR_MINUTE)")))
->getSelect()
->order('main_table.entity_id')
->limit(10)                   
;

//echo $orderCollection->printLogQuery(true); die();
foreach($orderCollection->getItems() as $order)
{
	$order_id = $order->getId();
	Mage::getModel('sales/order')->load($order_id)->delete()->unsetAll();
	_remove($order_id);
}

function _remove($order_id){
	$resource = Mage::getSingleton('core/resource');
	$delete = $resource->getConnection('core_read');
	$order_table = $resource->getTableName('sales_flat_order_grid');
	$invoice_table = $resource->getTableName('sales_flat_invoice_grid');
	$shipment_table = $resource->getTableName('sales_flat_shipment_grid');
	$creditmemo_table = $resource->getTableName('sales_flat_creditmemo_grid');
	$sql = "DELETE FROM  " . $order_table . " WHERE entity_id = " . $order_id . ";";
	$delete->query($sql);
	$sql = "DELETE FROM  " . $invoice_table . " WHERE order_id = " . $order_id . ";";
	$delete->query($sql);
	$sql = "DELETE FROM  " . $shipment_table . " WHERE order_id = " . $order_id . ";";
	$delete->query($sql);
	$sql = "DELETE FROM  " . $creditmemo_table . " WHERE order_id = " . $order_id . ";";
	$delete->query($sql);
	
	return true;
}