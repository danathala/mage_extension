<?php

class MD_SEO_Model_System_Config_Backend_Seo_Catalog extends Mage_Core_Model_Config_Data
{

    /**
     * After enabling layered navigation seo cache refresh is required
     *
     * @return MD_SEO_Model_System_Config_Backend_Seo_Catalog
     */
    protected function _afterSave()
    {
        if ($this->isValueChanged()) {
            $instance = Mage::app()->getCacheInstance();
            $instance->invalidateType('block_html');
        }

        return $this;
    }

}
