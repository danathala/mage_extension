UPDATE new_city SET new_city.country_id = (
SELECT country.country_id FROM country WHERE country.Code = new_city.country_code)