<?php

declare(strict_types=1);

namespace DoctrineMigrationsOrders;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328155304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_orders');
        $this->addSql('CREATE TABLE db_orders."order" (id UUID NOT NULL, status INT NOT NULL, payed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, total DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, address UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_orders."order".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_orders."order".address IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_orders.orderPricingSellerOrErp (pricing UUID NOT NULL, orders_id UUID NOT NULL, quantity INT NOT NULL, PRIMARY KEY(orders_id, pricing))');
        $this->addSql('CREATE INDEX IDX_87FBC62FCFFE9AD6 ON db_orders.orderPricingSellerOrErp (orders_id)');
        $this->addSql('COMMENT ON COLUMN db_orders.orderPricingSellerOrErp.pricing IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_orders.orderPricingSellerOrErp.orders_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_orders.usersOrders ("users" UUID NOT NULL, orders_id UUID NOT NULL, payment_intent VARCHAR(50) NOT NULL, amount DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(orders_id, "users"))');
        $this->addSql('CREATE INDEX IDX_EC4A0825CFFE9AD6 ON db_orders.usersOrders (orders_id)');
        $this->addSql('COMMENT ON COLUMN db_orders.usersOrders."users" IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_orders.usersOrders.orders_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE db_orders.orderPricingSellerOrErp ADD CONSTRAINT FK_87FBC62FCFFE9AD6 FOREIGN KEY (orders_id) REFERENCES db_orders."order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE db_orders.usersOrders ADD CONSTRAINT FK_EC4A0825CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES db_orders."order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE db_orders.orderPricingSellerOrErp DROP CONSTRAINT FK_87FBC62FCFFE9AD6');
        $this->addSql('ALTER TABLE db_orders.usersOrders DROP CONSTRAINT FK_EC4A0825CFFE9AD6');
        $this->addSql('DROP TABLE db_orders."order"');
        $this->addSql('DROP TABLE db_orders.orderPricingSellerOrErp');
        $this->addSql('DROP TABLE db_orders.usersOrders');
    }
}
