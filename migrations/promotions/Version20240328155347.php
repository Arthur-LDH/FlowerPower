<?php

declare(strict_types=1);

namespace DoctrineMigrationsPromotions;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328155347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_promotions');
        $this->addSql('CREATE TABLE PromotionCategory (promotion_id UUID NOT NULL, categoryErp UUID NOT NULL, PRIMARY KEY(promotion_id, categoryErp))');
        $this->addSql('CREATE INDEX IDX_FDAC5E2A139DF194 ON PromotionCategory (promotion_id)');
        $this->addSql('COMMENT ON COLUMN PromotionCategory.promotion_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN PromotionCategory.categoryErp IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE PromotionProductSellerOrErp (product UUID NOT NULL, promotion_id UUID NOT NULL, PRIMARY KEY(promotion_id, product))');
        $this->addSql('CREATE INDEX IDX_5FDE3384139DF194 ON PromotionProductSellerOrErp (promotion_id)');
        $this->addSql('COMMENT ON COLUMN PromotionProductSellerOrErp.product IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN PromotionProductSellerOrErp.promotion_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_promotions.promotion (id UUID NOT NULL, name VARCHAR(100) NOT NULL, percentage BOOLEAN NOT NULL, discount DOUBLE PRECISION NOT NULL, start_from TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, promo_code VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_promotions.promotion.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE PromotionCategory ADD CONSTRAINT FK_FDAC5E2A139DF194 FOREIGN KEY (promotion_id) REFERENCES db_promotions.promotion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE PromotionProductSellerOrErp ADD CONSTRAINT FK_5FDE3384139DF194 FOREIGN KEY (promotion_id) REFERENCES db_promotions.promotion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE PromotionCategory DROP CONSTRAINT FK_FDAC5E2A139DF194');
        $this->addSql('ALTER TABLE PromotionProductSellerOrErp DROP CONSTRAINT FK_5FDE3384139DF194');
        $this->addSql('DROP TABLE PromotionCategory');
        $this->addSql('DROP TABLE PromotionProductSellerOrErp');
        $this->addSql('DROP TABLE db_promotions.promotion');
        $this->addSql('DROP SCHEMA db_promotions');

    }
}
