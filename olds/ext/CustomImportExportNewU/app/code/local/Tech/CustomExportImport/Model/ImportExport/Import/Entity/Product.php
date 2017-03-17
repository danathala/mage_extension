<?php

class Tech_CustomExportImport_Model_ImportExport_Import_Entity_Product extends Mage_ImportExport_Model_Import_Entity_Product {
	
	/**
     * Links attribute name-to-link type ID.
     *
     * @var array
     */
    protected $_linkNameToId = array(
        '_links_related_'  			=> Mage_Catalog_Model_Product_Link::LINK_TYPE_RELATED,
        '_links_crosssell_' 			=> Mage_Catalog_Model_Product_Link::LINK_TYPE_CROSSSELL,
        '_links_upsell_'    			=> Mage_Catalog_Model_Product_Link::LINK_TYPE_UPSELL,
        '_my_custom_associated_'    => Anais_Accessories_Model_Product_Link::LINK_TYPE_ACCESSORIES
    );
	 
	 /**
     * Column names that holds values with particular meaning.
     *
     * @var array
     */
    protected $_particularAttributes = array(
        '_store', '_attribute_set', '_type', self::COL_CATEGORY, self::COL_ROOT_CATEGORY, '_product_websites',
        '_tier_price_website', '_tier_price_customer_group', '_tier_price_qty', '_tier_price_price',
        '_links_related_sku', '_group_price_website', '_group_price_customer_group', '_group_price_price',
        '_links_related_position', '_links_crosssell_sku', '_links_crosssell_position', '_links_upsell_sku',
        '_links_upsell_position', '_my_custom_associated_sku', '_my_custom_associated_default_qty', '_my_custom_associated_position',  '_custom_option_store', '_custom_option_type', '_custom_option_title',
        '_custom_option_is_required', '_custom_option_price', '_custom_option_sku', '_custom_option_max_characters',
        '_custom_option_sort_order', '_custom_option_file_extension', '_custom_option_image_size_x',
        '_custom_option_image_size_y', '_custom_option_row_title', '_custom_option_row_price',
        '_custom_option_row_sku', '_custom_option_row_sort', '_media_attribute_id', '_media_image', '_media_lable',
        '_media_position', '_media_is_disabled'
    );
	 
}
