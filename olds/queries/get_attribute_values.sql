SELECT EAOV.value
FROM eav_attribute EA
LEFT JOIN eav_attribute_option EAO ON EAO.attribute_id = EA.attribute_id
LEFT JOIN eav_attribute_option_value EAOV ON EAOV.option_id = EAO.option_id
WHERE EA.attribute_code = 'color' AND EAOV.store_id =0