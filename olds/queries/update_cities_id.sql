update new_city city set country_id = 
 (SELECT c.country_id FROM country c where city.country_code = c.Code)