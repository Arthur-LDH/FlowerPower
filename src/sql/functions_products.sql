--Trigger pour la gestion du stock
CREATE OR REPLACE FUNCTION check_stock_level()
    RETURNS TRIGGER AS $$
BEGIN
    IF NEW.stock_left < NEW.stock_min THEN
        -- Envoyer une notification au vendeur
        RAISE NOTICE 'Stock pour le produit % est en dessous du seuil minimum. Veuillez penser au réapprovisionnement.', NEW.productseller_id;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER stock_management
    AFTER UPDATE OF stock_left ON "db_products".pricingseller
    FOR EACH ROW
    WHEN (OLD.stock_left >= OLD.stock_min AND NEW.stock_left < NEW.stock_min)
EXECUTE FUNCTION check_stock_level();

--DROP TRIGGER IF EXISTS stock_management ON "db_products".pricingseller;

-- Test permettant de mettre à jour le stock_left d'une ligne pour qu'il devienne inférieur au stock_min
--UPDATE "db_products".pricingseller
--SET stock_left = 5
--WHERE productseller_id = '1eef25cd-9905-6fa6-96fb-bb4dafbaff7e';


-- Fonction pour vérifier si un produit est inclu ou non dans la saisonnalité
CREATE OR REPLACE FUNCTION is_product_in_season(product_id UUID)
RETURNS BOOLEAN AS $$
DECLARE
is_in_season BOOLEAN;
BEGIN
    -- Vérifie si la date actuelle se trouve dans l'intervalle de saisonnalité du produit
SELECT CURRENT_DATE BETWEEN seasonality_start AND seasonality_end INTO is_in_season
FROM "db_products".productseller
WHERE id = product_id;

IF is_in_season IS NULL THEN
        -- Si le produit n'a pas de saisonnalité définie, considérer comme en saison
        RETURN TRUE;
ELSE
        RETURN is_in_season;
END IF;
END;
$$ LANGUAGE plpgsql;

--test
--SELECT is_product_in_season('1eef25cd-9905-6fa6-96fb-bb4dafbaff7e');--Return true
--SELECT is_product_in_season('1eef25f1-8476-62ba-b29e-b99d667cdbb6');--Return false


