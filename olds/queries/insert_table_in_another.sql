INSERT IGNORE INTO new_city (city_name,country_code,district,population)
SELECT Name AS city_name, CountryCode AS country_code, District AS district, Population AS population
FROM city; 
