BEGIN
SELECT u.user_login,u.user_email,um.meta_value AS fname,um2.meta_value AS lname,um3.meta_value AS nickname,um4.meta_value AS description,um5.meta_value AS admin_color, um6.meta_value AS user_level
FROM wp_users u

LEFT JOIN wp_usermeta AS um  ON u.ID = um.user_id  AND  um.meta_key = 'first_name'
LEFT JOIN wp_usermeta AS um2 ON u.ID = um2.user_id AND um2.meta_key = 'last_name'
LEFT JOIN wp_usermeta AS um3 ON u.ID = um3.user_id AND um3.meta_key = 'nickname'
LEFT JOIN wp_usermeta AS um4 ON u.ID = um4.user_id AND um4.meta_key = 'description'
LEFT JOIN wp_usermeta AS um5 ON u.ID = um5.user_id AND um5.meta_key = 'admin_color'
LEFT JOIN wp_usermeta AS um6 ON u.ID = um6.user_id AND um6.meta_key = 'wp_user_level'
;
END