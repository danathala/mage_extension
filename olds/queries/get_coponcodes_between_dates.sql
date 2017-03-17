SELECT main_table.*, rule_coupons.code,rule_coupons.created_at
FROM `salesrule` AS main_table
INNER JOIN salesrule_coupon AS rule_coupons ON main_table.rule_id = rule_coupons.rule_id
WHERE rule_coupons.created_at BETWEEN '2015-09-07' AND '2015-09-08';
SELECT main_table.*, rule_coupons.code,rule_coupons.created_at
FROM `salesrule` AS main_table
INNER JOIN salesrule_coupon AS rule_coupons ON main_table.rule_id = rule_coupons.rule_id
WHERE rule_coupons.created_at BETWEEN '2015-09-07' AND '2015-09-08';