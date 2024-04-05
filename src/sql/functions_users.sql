
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
    BEFORE UPDATE OF password ON "db_users".users
    FOR EACH ROW
    EXECUTE FUNCTION save_old_password();


--test
UPDATE "db_users".users SET password = 'initialPassword' WHERE id = '1eef3252-de25-61fe-93c7-ab4a9849f075';

-- Mettre à jour le mot de passe pour déclencher le trigger
UPDATE "db_users".users SET password = 'newPassword' WHERE id = '1eef3252-de25-61fe-93c7-ab4a9849f075';

-- Vérifier que l'ancien mot de passe est maintenant dans old_password
SELECT password, old_password FROM "db_users".users WHERE id = '1eef3252-de25-61fe-93c7-ab4a9849f075';

