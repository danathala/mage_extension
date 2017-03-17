<?php

/**
* Baggage Freight Module - Installation script
*
* @category   DI
* @package    Di_Bagshipping
* @author     DI Dev Team
* @website    http://www.di.net.au/
*/

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('baggage_excel')};
CREATE TABLE {$this->getTable('baggage_excel')} (
  `bagshipping_id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `sku` varchar(200) NOT NULL,
  `weight` varchar(200) NOT NULL,
  `height` varchar(200) NOT NULL,
  `width` varchar(200) NOT NULL,
  `length` varchar(200) NOT NULL,
  PRIMARY KEY  (`bagshipping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$this->getTable('baggage_order')};
CREATE TABLE {$this->getTable('baggage_order')} (
  `order_id` int(11) NOT NULL,
  `carrier` varchar(200) NOT NULL,
  `service` varchar(200) NOT NULL,
  `booking_price` varchar(200) NOT NULL,
  `shipping_price` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `border_id` varchar(200) NOT NULL,
  PRIMARY KEY  (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS {$this->getTable('baggage_storeowner')};
CREATE TABLE {$this->getTable('baggage_storeowner')} (
  `owner_id` int(11) NOT NULL auto_increment,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `company` varchar(200) NOT NULL,
  `contact_name` varchar(200) NOT NULL,
  `address` varchar(500) NOT NULL,
  `address1` varchar(500) NOT NULL,
  `collect_country` varchar(200) NOT NULL,
  `collect_city` varchar(200) NOT NULL,
  `collect_state` varchar(200) NOT NULL,
  `collect_zip` varchar(200) NOT NULL,
  `collect_email` varchar(200) NOT NULL,
  `collect_phno` varchar(200) NOT NULL,
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY  (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();
