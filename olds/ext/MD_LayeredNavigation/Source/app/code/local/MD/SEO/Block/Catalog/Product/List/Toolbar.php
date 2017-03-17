<?php

class MD_SEO_Block_Catalog_Product_List_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar
{

    /**
     * Return current URL with rewrites and additional parameters
     *
     * @param array $params Query parameters
     * @return string
     */
    public function getPagerUrl($params = array())
    {
        if (!$this->helper('md_seo')->isEnabled()) {
            return parent::getPagerUrl($params);
        }

        if ($this->helper('md_seo')->isCatalogSearch()) {
            $params['isLayerAjax'] = null;
            return parent::getPagerUrl($params);
        }

        return $this->helper('md_seo')->getPagerUrl($params);
    }

}