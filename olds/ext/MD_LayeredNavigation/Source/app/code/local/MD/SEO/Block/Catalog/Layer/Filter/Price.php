<?php

class MD_SEO_Block_Catalog_Layer_Filter_Price extends Mage_Catalog_Block_Layer_Filter_Price
{
    /**
     * Class constructor
     * 
     * Set correct template depending on module state
     */
    public function __construct()
    {
        parent::__construct();
        if ($this->helper('md_seo')->isEnabled()
            && $this->helper('md_seo')->isPriceSliderEnabled()) {
            // Modify template to render price filter as slider
            $this->setTemplate('md_seo/catalog/layer/price.phtml');
        }
    }

    /**
     * Get maximum price from layer products set
     *
     * @return float
     */
    public function getMaxPriceFloat()
    {
        return $this->_filter->getMaxPriceFloat();
    }

    /**
     * Get minimum price from layer products set
     *
     * @return float
     */
    public function getMinPriceFloat()
    {
        return $this->_filter->getMinPriceFloat();
    }

    /**
     * Get current minimum price filter
     * 
     * @return float
     */
    public function getCurrentMinPriceFilter()
    {
        list($from, $to) = $this->_filter->getInterval();
        $from = floor((float) $from);

        if ($from < $this->getMinPriceFloat()) {
            return $this->getMinPriceFloat();
        }

        return $from;
    }

    /**
     * Get current maximum price filter
     * 
     * @return float
     */
    public function getCurrentMaxPriceFilter()
    {
        list($from, $to) = $this->_filter->getInterval();
        $to = floor((float) $to);

        if ($to == 0 || $to > $this->getMaxPriceFloat()) {
            return $this->getMaxPriceFloat();
        }

        return $to;
    }

    /**
     * URL Pattern used in javascript for price filtering
     * 
     * @return string
     */
    public function getUrlPattern()
    {
        $item = Mage::getModel('catalog/layer_filter_item')
            ->setFilter($this->_filter)
            ->setValue('__PRICE_VALUE__')
            ->setCount(0);

        return $item->getUrl();
    }

    /**
     * Retrieve filter items count
     *
     * @return int
     */
    public function getItemsCount()
    {
        if ($this->helper('md_seo')->isEnabled()
            && $this->helper('md_seo')->isPriceSliderEnabled()) {
            return 1; // Keep price filter ON
        }

        return parent::getItemsCount();
    }

}
