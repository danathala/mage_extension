<?php
 
class Tech_CustomExportImport_Model_Observer {

	public function importFinishBefore($observer) {
		
		$adapter		=	$observer->getEvent()->getAdapter();
		$bounch		=	$adapter->getNextBunch();		
		$respond		=	array();
		$parentSku	=	array();
		$childSku	=	array();
		//print_R($bounch); die();
		
		foreach($bounch as $key => $value) {
			if($value['sku'] != '') {
				$parent_sku = $value['sku'];
				$parentSku[$key]	=	$parent_sku;
			}

			if($value['_my_custom_associated_sku'] != '') {
				$childSku[$parent_sku][$value['_my_custom_associated_sku']] = $value['_my_custom_associated_sku'];
				$childSku[$value['_my_custom_associated_sku']][$parent_sku] = $parent_sku;
			}
		}

		if(!empty($childSku)) {

			$linkRows	=	array();
			
			$resource			=	Mage::getResourceModel('catalog/product_link');
			$mainTable			=	$resource->getMainTable();
			$nextLinkId			=	Mage::getResourceHelper('importexport')->getNextAutoincrement($mainTable);
			
			$_newSku = $adapter->getNewSku();
			$_oldSku = $adapter->getOldSku();
			//print_r($_newSku);
			//print_r($_oldSku); die();
			foreach($childSku as $childKey => $childValue) {
				
				if(!in_array($childKey, $parentSku)) {
					//print_r($childValue);
					foreach($childValue as $lastKey => $lastValue) {
						
						$finalArray	=	array();
						
						$finalArray = $childSku[$lastKey];
						
						unset($finalArray[$childKey]); //unsetting the old child
						
						if(isset($_oldSku[$childKey])) {
							$productId	=	$_oldSku[$childKey]['entity_id'];
						} else {
							$productId	=	$_newSku[$childKey]['entity_id'];
						}

						$finalArray[$lastKey] = $lastKey;
						
						foreach($finalArray as $linkedSku => $fvalue) {

							if (isset($adapter->_newSku[$linkedSku])) {
								  $linkedId = $_newSku[$linkedSku]['entity_id'];
							 } else {
								  $linkedId = $_oldSku[$linkedSku]['entity_id'];
							 }

							$linkId	=	Anais_Accessories_Model_Product_Link::LINK_TYPE_ACCESSORIES;
							$linkKey = "{$productId}-{$linkedId}-{$linkId}";
							
							$linkRows[$linkKey] = array(
								'link_id'           => $nextLinkId,
								'product_id'        => $productId,
								'linked_product_id' => $linkedId,
								'link_type_id'      => $linkId
							);
							
							$nextLinkId++;
							
						} //endforeach;
					} //endforeach;
				} //endif
			} //endforeach;
			
			//print_r($finalArray); die();
			//print_r($linkRows);
			if(count($linkRows) > 0) {
				$adapter->getConnection()->insertOnDuplicate(
					$mainTable,
					$linkRows,
					array('link_id')
				);
			}
		}
		
		
		// print_r($childSku);die();
		//print_r($parentSku);
		
		//die();
		
		
	}
	
	
}