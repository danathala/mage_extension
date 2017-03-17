<?php
class Hans2103_Sitemap_IndexController extends Mage_Core_Controller_Front_Action {
	
	public function indexAction () {
		
		$storeId = Mage::app()->getStore()->getStoreId();
		$collection = Mage::getResourceModel('sitemap/catalog_product')->getCollection($storeId);
		//$collection = Mage::getModel('catalog/product')->getCollection();
		
		//$collection->addAttributeToSelect('*');
		// $collection->addAttributeToSelect(array('name','url_path','small_image'));
		
        foreach ($collection as $item) {
			  print_r($item->debug()); die();
           /*  $xml = sprintf('<url>
										<loc>%s</loc>
										<image:image>
											<image:loc>%s</image:loc>
											<image:title>%s</image:title>
										</image:image>
										<lastmod>%s</lastmod>
										<changefreq>%s</changefreq>
										<priority>%.1f</priority></url>' . "\n",
                htmlspecialchars($baseUrl . $item->getUrl()), //ok
                $mediaUrl .'catalog/product'. $item->getMediaUrl(),
                htmlspecialchars($item->getName()),
                $date,
                $changefreq,
                $priority,
                htmlspecialchars($item->getName()),
                htmlspecialchars($mediaUrl .'catalog/product'. $item->getMediaUrl())
            );
            $io->streamWrite($xml); */
        }
	}
	
}