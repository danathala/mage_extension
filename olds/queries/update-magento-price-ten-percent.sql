UPDATE catalog_product_entity_decimal SET value = value + value*20/100
WHERE attribute_id = 99 AND value > 600;