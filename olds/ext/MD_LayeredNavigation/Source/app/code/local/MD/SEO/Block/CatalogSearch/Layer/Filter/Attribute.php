<?php

class MD_SEO_Block_CatalogSearch_Layer_Filter_Attribute extends MD_SEO_Block_Catalog_Layer_Filter_Attribute
{

    /**
     * Set filter model name
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->_filterModelName = 'catalogsearch/layer_filter_attribute';
    }

}
