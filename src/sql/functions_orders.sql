CREATE OR REPLACE FUNCTION calculate_average_basket()
    RETURNS NUMERIC AS $$
DECLARE
    average_basket NUMERIC;
BEGIN
    SELECT AVG(total) INTO average_basket FROM "db_orders"."order";
    RETURN average_basket;
END;
$$ LANGUAGE plpgsql;


--SELECT calculate_average_basket();
