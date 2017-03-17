UPDATE catalog_product_entity_decimal SET value = value + value *50 /100
WHERE attribute_id =64 AND value < 300;