<?php
$installer = $this;
$installer->startSetup();


$installer->addAttribute("catalog_category", "amazon_nodid",  array(
    "type"     => "varchar",
    "backend"  => "",
    "frontend" => "",
    "label"    => "Node Id",
    "input"    => "text",
    "class"    => "",
    "source"   => "",
    "global"   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE,
    "visible"  => true,
    "required" => false,
    "user_defined"  => false,
    "default" => "",
    "searchable" => false,
    "filterable" => false,
    "comparable" => false,
	
    "visible_on_front"  => false,
    "unique"     => false,
    "note"       => ""

	));
$installer->endSetup();
	 