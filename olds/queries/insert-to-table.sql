INSERT INTO new_city (country_code,city_name,district,population)
SELECT CountryCode AS country_code, Name AS name, District AS district, Population AS population
FROM city;