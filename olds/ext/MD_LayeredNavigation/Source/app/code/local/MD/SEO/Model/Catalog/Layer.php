<?php

class MD_SEO_Model_Catalog_Layer extends Mage_Catalog_Model_Layer
{

    /**
     * Get collection of all filterable attributes for layer products set
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Attribute_Collection
     */
    public function getFilterableAttributes()
    {
        $collection = parent::getFilterableAttributes();

        if ($collection instanceof Mage_Catalog_Model_Resource_Product_Attribute_Collection) {
            // Prealoads all needed attributes at once
            $attrUrlKeyModel = Mage::getResourceModel('md_seo/attribute_urlkey');
            $attrUrlKeyModel->preloadAttributesOptions($collection);
        }

        return $collection;
    }

}