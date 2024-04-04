---------
--USERS--
---------
--Trigger pour mettre à jour les mdp en enregistrant l'ancien mdp dans old_password
CREATE OR REPLACE FUNCTION save_old_password()
RETURNS TRIGGER AS $$
BEGIN
  IF OLD.password <> NEW.password THEN
    NEW.old_password := OLD.password;
END IF;
RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER before_password_update
    BEFORE UPDATE OF password ON "user"
    FOR EACH ROW
    EXECUTE FUNCTION save_old_password();


------------
--PRODUCTS--
------------

--Trigger pour la gestion du stock
CREATE OR REPLACE FUNCTION check_stock_level()
RETURNS TRIGGER AS $$
BEGIN
  IF NEW.stock_left < NEW.stock_min THEN
    --Envoyer une notification au vendeur
    RAISE NOTICE 'Stock pour le produit % est en dessous du seuil minimum.' ||
     'Veuillez penser au réapprovisionnement.', NEW.productSeller_uid;
END IF;
RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER stock_management
    AFTER UPDATE OF stock_left ON pricingSeller
    FOR EACH ROW
    WHEN (OLD.stock_left >= OLD.stock_min AND NEW.stock_left < NEW.stock_min)
    EXECUTE FUNCTION check_stock_level();


-- fonction de vérification de la saisonnalité
CREATE OR REPLACE FUNCTION is_product_in_season(product_uid UUID)
RETURNS BOOLEAN AS $$
DECLARE
is_in_season BOOLEAN;
BEGIN
    -- Vérifie si la date actuelle se trouve dans l'intervalle de saisonnalité du produit
SELECT CURRENT_DATE BETWEEN seasonality_start AND seasonality_end INTO is_in_season
FROM productSeller
WHERE uid = product_uid;

IF is_in_season IS NULL THEN
        -- Si le produit n'a pas de saisonnalité définie, considérer comme en saison
        RETURN TRUE;
ELSE
        RETURN is_in_season;
END IF;
END;
$$ LANGUAGE plpgsql;

----------
--ORDERS--
----------
