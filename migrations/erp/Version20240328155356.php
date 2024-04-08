<?php

declare(strict_types=1);

namespace DoctrineMigrationsErp;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328155356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_erp');
        $this->addSql('CREATE TABLE db_erp.categoryErp (id UUID NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_erp.categoryErp.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_erp.invoiceErp (id UUID NOT NULL, orders UUID NOT NULL, seller UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_erp.invoiceErp.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_erp.invoiceErp.orders IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_erp.invoiceErp.seller IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_erp.pricingErp (id UUID NOT NULL, name VARCHAR(100) NOT NULL, price DOUBLE PRECISION NOT NULL, tax DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, stock_left INT NOT NULL, stock_min INT NOT NULL, productErp_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4637FDDDB41EA2AD ON db_erp.pricingErp (productErp_id)');
        $this->addSql('COMMENT ON COLUMN db_erp.pricingErp.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_erp.pricingErp.productErp_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_erp.productErp (id UUID NOT NULL, name VARCHAR(100) NOT NULL, description TEXT NOT NULL, seasonality_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, seasonality_end TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_erp.productErp.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE producterp_categoryerp (producterp_id UUID NOT NULL, categoryerp_id UUID NOT NULL, PRIMARY KEY(producterp_id, categoryerp_id))');
        $this->addSql('CREATE INDEX IDX_35B14692B3B2A79B ON producterp_categoryerp (producterp_id)');
        $this->addSql('CREATE INDEX IDX_35B14692FADD938E ON producterp_categoryerp (categoryerp_id)');
        $this->addSql('COMMENT ON COLUMN producterp_categoryerp.producterp_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN producterp_categoryerp.categoryerp_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE db_erp.pricingErp ADD CONSTRAINT FK_4637FDDDB41EA2AD FOREIGN KEY (productErp_id) REFERENCES db_erp.productErp (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE producterp_categoryerp ADD CONSTRAINT FK_35B14692B3B2A79B FOREIGN KEY (producterp_id) REFERENCES db_erp.productErp (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE producterp_categoryerp ADD CONSTRAINT FK_35B14692FADD938E FOREIGN KEY (categoryerp_id) REFERENCES db_erp.categoryErp (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE db_erp.pricingErp DROP CONSTRAINT FK_4637FDDDB41EA2AD');
        $this->addSql('ALTER TABLE producterp_categoryerp DROP CONSTRAINT FK_35B14692B3B2A79B');
        $this->addSql('ALTER TABLE producterp_categoryerp DROP CONSTRAINT FK_35B14692FADD938E');
        $this->addSql('DROP TABLE db_erp.categoryErp');
        $this->addSql('DROP TABLE db_erp.invoiceErp');
        $this->addSql('DROP TABLE db_erp.pricingErp');
        $this->addSql('DROP TABLE db_erp.productErp');
        $this->addSql('DROP TABLE producterp_categoryerp');
        $this->addSql('DROP SCHEMA db_erp');
    }
}
