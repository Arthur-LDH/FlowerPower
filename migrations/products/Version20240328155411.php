<?php

declare(strict_types=1);

namespace DoctrineMigrationsProducts;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328155411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_products');
        $this->addSql('CREATE TABLE CategoryErpProductSeller (categoryErp UUID NOT NULL, productSeller_id UUID NOT NULL, PRIMARY KEY(productSeller_id, categoryErp))');
        $this->addSql('CREATE INDEX IDX_4C75B178EA698D8D ON CategoryErpProductSeller (productSeller_id)');
        $this->addSql('COMMENT ON COLUMN CategoryErpProductSeller.categoryErp IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN CategoryErpProductSeller.productSeller_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_products.image (id UUID NOT NULL, path TEXT NOT NULL, name VARCHAR(100) NOT NULL, alternativ_text TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_products.image.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_products.pricingSeller (id UUID NOT NULL, name VARCHAR(100) NOT NULL, price DOUBLE PRECISION NOT NULL, tax DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, stock_left INT NOT NULL, stock_min INT NOT NULL, productSeller_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DEC4E519EA698D8D ON db_products.pricingSeller (productSeller_id)');
        $this->addSql('COMMENT ON COLUMN db_products.pricingSeller.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_products.pricingSeller.productSeller_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_products.productSeller (id UUID NOT NULL, name VARCHAR(100) NOT NULL, description TEXT NOT NULL, seasonality_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, seasonality_end TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, seller UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_products.productSeller.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_products.productSeller.seller IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_products.productSellerImage (products_id UUID NOT NULL, images_id UUID NOT NULL, front BOOLEAN NOT NULL, PRIMARY KEY(products_id, images_id))');
        $this->addSql('CREATE INDEX IDX_B9CD2D626C8A81A9 ON db_products.productSellerImage (products_id)');
        $this->addSql('CREATE INDEX IDX_B9CD2D62D44F05E5 ON db_products.productSellerImage (images_id)');
        $this->addSql('COMMENT ON COLUMN db_products.productSellerImage.products_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_products.productSellerImage.images_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE CategoryErpProductSeller ADD CONSTRAINT FK_4C75B178EA698D8D FOREIGN KEY (productSeller_id) REFERENCES db_products.productSeller (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE db_products.pricingSeller ADD CONSTRAINT FK_DEC4E519EA698D8D FOREIGN KEY (productSeller_id) REFERENCES db_products.productSeller (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE db_products.productSellerImage ADD CONSTRAINT FK_B9CD2D626C8A81A9 FOREIGN KEY (products_id) REFERENCES db_products.productSeller (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE db_products.productSellerImage ADD CONSTRAINT FK_B9CD2D62D44F05E5 FOREIGN KEY (images_id) REFERENCES db_products.image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql($this->checkStockLevel());
        $this->addSql($this->stockManagement());
        $this->addSql($this->isProductInSeason());
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE CategoryErpProductSeller DROP CONSTRAINT FK_4C75B178EA698D8D');
        $this->addSql('ALTER TABLE db_products.pricingSeller DROP CONSTRAINT FK_DEC4E519EA698D8D');
        $this->addSql('ALTER TABLE db_products.productSellerImage DROP CONSTRAINT FK_B9CD2D626C8A81A9');
        $this->addSql('ALTER TABLE db_products.productSellerImage DROP CONSTRAINT FK_B9CD2D62D44F05E5');
        $this->addSql('DROP TABLE CategoryErpProductSeller');
        $this->addSql('DROP TABLE db_products.image');
        $this->addSql('DROP TABLE db_products.pricingSeller');
        $this->addSql('DROP TABLE db_products.productSeller');
        $this->addSql('DROP TABLE db_products.productSellerImage');
        $this->addSql('DROP SCHEMA db_products');
    }


    private function checkStockLevel()
    {
        Return 'CREATE OR REPLACE FUNCTION check_stock_level()
                RETURNS TRIGGER AS $$
                BEGIN
                    IF NEW.stock_left < NEW.stock_min THEN
                        -- Envoyer une notification au vendeur
                        RAISE NOTICE \'Stock pour le produit % est en dessous du seuil minimum. Veuillez penser au réapprovisionnement.\', NEW.productseller_id;
                    END IF;
                    RETURN NEW;
                END;
                $$ LANGUAGE plpgsql;';
    }

    private function stockManagement()
    {
        Return 'CREATE TRIGGER stock_management
                AFTER UPDATE OF stock_left ON "db_products".pricingseller
                FOR EACH ROW
                WHEN (OLD.stock_left >= OLD.stock_min AND NEW.stock_left < NEW.stock_min)
                EXECUTE FUNCTION check_stock_level();';
    }

    private function isProductInSeason()
    {
        Return 'CREATE OR REPLACE FUNCTION is_product_in_season(product_id UUID)
                RETURNS BOOLEAN AS $$
                DECLARE
                is_in_season BOOLEAN;
                BEGIN

                SELECT CURRENT_DATE BETWEEN seasonality_start AND seasonality_end INTO is_in_season
                FROM "db_products".productseller
                WHERE id = product_id;

                IF is_in_season IS NULL THEN
                        RETURN TRUE;
                ELSE
                        RETURN is_in_season;
                END IF;
                END;
                $$ LANGUAGE plpgsql;';
    }
}
