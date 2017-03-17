SELECT attribute_id
FROM eav_attribute
WHERE attribute_code = 'price' AND entity_type_id = (
SELECT entity_type_id
FROM eav_entity_type
WHERE entity_type_code = 'catalog_product')