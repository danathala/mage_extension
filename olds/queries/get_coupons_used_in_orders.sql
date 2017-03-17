SELECT UCASE( coupon_code ) AS `Coupon Code` ,
STATUS AS `Order Status` , COUNT( * ) AS `Times Used`
FROM sales_flat_order
GROUP BY coupon_code,
STATUS;