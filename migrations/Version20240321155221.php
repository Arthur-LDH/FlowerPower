<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240321155221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_users');
        $this->addSql('CREATE SCHEMA db_products');
        $this->addSql('CREATE SCHEMA db_orders');
        $this->addSql('CREATE SCHEMA db_reviews');
        $this->addSql('CREATE TABLE db_users.address (id UUID NOT NULL, coordinates Geometry(Point) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_users.address.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_users.address.coordinates IS \'(DC2Type:point)\'');
        $this->addSql('CREATE TABLE db_products.image (id UUID NOT NULL, path TEXT NOT NULL, name VARCHAR(100) NOT NULL, alternativ_text TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_products.image.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_orders."order" (id UUID NOT NULL, status INT NOT NULL, payed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, total DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_orders."order".id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_orders.orderPricingSellerOrErp (id UUID NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_orders.orderPricingSellerOrErp.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_products.pricingSeller (id UUID NOT NULL, name VARCHAR(100) NOT NULL, price DOUBLE PRECISION NOT NULL, tax DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, stock_left INT NOT NULL, stock_min INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_products.pricingSeller.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_products.productBaseImage (id UUID NOT NULL, front BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_products.productBaseImage.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_products.productSeller (id UUID NOT NULL, name VARCHAR(100) NOT NULL, description TEXT NOT NULL, seasonality_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, seasonality_end TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_products.productSeller.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_reviews.review (id UUID NOT NULL, comment TEXT DEFAULT NULL, note DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_reviews.review.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_users.seller (id UUID NOT NULL, national_code VARCHAR(50) NOT NULL, company_name VARCHAR(100) NOT NULL, seller_name VARCHAR(100) NOT NULL, phone VARCHAR(15) NOT NULL, email VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_users.seller.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_users.users (id UUID NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, email_verified_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, password VARCHAR(255) NOT NULL, old_password VARCHAR(255) NOT NULL, remember_token VARCHAR(100) NOT NULL, birthdate TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, phone VARCHAR(15) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, role TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_users.users.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_users.users.role IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE db_users.usersAddress (id UUID NOT NULL, label VARCHAR(100) NOT NULL, facturation BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_users.usersAddress.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_orders.usersOrders (id UUID NOT NULL, payment_intent VARCHAR(50) NOT NULL, amount DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_orders.usersOrders.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE db_users.address');
        $this->addSql('DROP TABLE db_products.image');
        $this->addSql('DROP TABLE db_orders."order"');
        $this->addSql('DROP TABLE db_orders.orderPricingSellerOrErp');
        $this->addSql('DROP TABLE db_products.pricingSeller');
        $this->addSql('DROP TABLE db_products.productBaseImage');
        $this->addSql('DROP TABLE db_products.productSeller');
        $this->addSql('DROP TABLE db_reviews.review');
        $this->addSql('DROP TABLE db_users.seller');
        $this->addSql('DROP TABLE db_users.users');
        $this->addSql('DROP TABLE db_users.usersAddress');
        $this->addSql('DROP TABLE db_orders.usersOrders');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
