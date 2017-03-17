SELECT `value` AS product_name, `value` as description FROM catalog_product_entity_varchar 
WHERE entity_type_id = (SELECT entity_type_id FROM eav_entity_type WHERE entity_type_code = 'catalog_product') AND attribute_id = (SELECT attribute_id FROM eav_attribute
WHERE attribute_code = 'name' AND entity_type_id = (SELECT entity_type_id FROM eav_entity_type
WHERE entity_type_code = 'catalog_product'))