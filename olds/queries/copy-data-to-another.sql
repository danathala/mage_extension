INSERT INTO new_city (country_code,city_name,district,population)
SELECT Name AS name, CountryCode AS country_code,District AS district, Population AS population
FROM city;