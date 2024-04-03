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

--Trigger permettant de supprimer les adresses associées à l'utilisateur si le compte est supprimé
CREATE OR REPLACE FUNCTION delete_user_addresses()
RETURNS TRIGGER AS $$
BEGIN
  -- Supprime toutes les entrées de user_address associées à l'utilisateur supprimé
DELETE FROM user_address WHERE user_uid = OLD.uid;
RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER cascade_delete_user_addresses
    AFTER DELETE ON "user"
    FOR EACH ROW
    EXECUTE FUNCTION delete_user_addresses();

--fonction permettant de rechercher un vendeur
CREATE OR REPLACE FUNCTION search_seller_by_national_code(n_code VARCHAR)
RETURNS TABLE (
    uid UUID,
    national_code VARCHAR,
    company_name VARCHAR,
    seller_name VARCHAR,
    phone VARCHAR,
    email VARCHAR,
    user_uid UUID,
    address_uid UUID,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
) AS $$
BEGIN
RETURN QUERY
SELECT
    s.uid,
    s.national_code,
    s.company_name,
    s.seller_name,
    s.phone,
    s.email,
    s.address_uid,
FROM
    seller s
WHERE
    s.national_code = n_code;
END;
$$ LANGUAGE plpgsql;

------------
--PRODUCTS--
------------
--Trigger qui quand un produit est supprimé, supprime les relations associées.
CREATE OR REPLACE FUNCTION delete_product_cascade()
RETURNS TRIGGER AS $$
BEGIN
  -- Supprimer les images associées au produit
DELETE FROM productSeller_image WHERE product_uid = OLD.uid;

-- Supprimer les informations de prix associées au produit
DELETE FROM pricingSeller WHERE productSeller_uid = OLD.uid;

RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER cascade_delete_product
    AFTER DELETE ON productSeller
    FOR EACH ROW
    EXECUTE FUNCTION delete_product_cascade();

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
--Trigger permettant de valider le paiement (UTILE???)
CREATE OR REPLACE FUNCTION update_payment_datetime()
RETURNS TRIGGER AS $$
BEGIN
  -- Vérifier si le statut de la commande indique qu'elle a été payée
  -- statut '1' signifie 'payé'
  IF NEW.status = 1 AND OLD.status <> 1 THEN
    NEW.payed_at := NOW(); -- Mettre à jour 'payed_at' avec la date et heure actuelle
END IF;
RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_update_payment_datetime
    BEFORE UPDATE OF status ON "order"
    FOR EACH ROW
    EXECUTE FUNCTION update_payment_datetime();
