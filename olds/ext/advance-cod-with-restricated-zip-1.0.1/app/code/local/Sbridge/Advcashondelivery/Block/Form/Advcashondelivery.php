<?php
class Sbridge_Advcashondelivery_Block_Form_advcashondelivery extends Sbridge_Advcashondelivery_Block_Form
{

    /**
    * Instructions text
    *
    * @var string
    */
    protected $_instructions;

    /**
    * Block construction. Set block template.
    */
    protected function _construct()
    {

        parent::_construct();
        $this->setTemplate('advcashondelivery/form/advcashondelivery.phtml');

    }

    /**
    * Get instructions text from config
    *
    * @return string
    */
    public function getInstructions()
    {
        if (is_null($this->_instructions)) {
            $this->_instructions = $this->getMethod()->getInstructions();
        }
        return $this->_instructions;
    }

}
