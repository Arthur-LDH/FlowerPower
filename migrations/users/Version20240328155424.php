<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328155424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_users');
        $this->addSql('CREATE TABLE db_users.address (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_users.address.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_users.seller (id UUID NOT NULL, users_id UUID NOT NULL, address_id UUID NOT NULL, national_code VARCHAR(50) NOT NULL, company_name VARCHAR(100) NOT NULL, seller_name VARCHAR(100) NOT NULL, phone VARCHAR(15) NOT NULL, email VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_99EFCA3B67B3B43D ON db_users.seller (users_id)');
        $this->addSql('CREATE INDEX IDX_99EFCA3BF5B7AF75 ON db_users.seller (address_id)');
        $this->addSql('COMMENT ON COLUMN db_users.seller.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_users.seller.users_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_users.seller.address_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE db_users.users (id UUID NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, email_verified_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, password VARCHAR(255) NOT NULL, old_password VARCHAR(255) NOT NULL, remember_token VARCHAR(100) NOT NULL, birthdate TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, phone VARCHAR(15) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, role TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_users.users.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_users.users.role IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE db_users.usersAddress (users_id UUID NOT NULL, address_id UUID NOT NULL, label VARCHAR(100) NOT NULL, facturation BOOLEAN NOT NULL, PRIMARY KEY(users_id, address_id))');
        $this->addSql('CREATE INDEX IDX_AFD11D2A67B3B43D ON db_users.usersAddress (users_id)');
        $this->addSql('CREATE INDEX IDX_AFD11D2AF5B7AF75 ON db_users.usersAddress (address_id)');
        $this->addSql('COMMENT ON COLUMN db_users.usersAddress.users_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_users.usersAddress.address_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE db_users.seller ADD CONSTRAINT FK_99EFCA3B67B3B43D FOREIGN KEY (users_id) REFERENCES db_users.users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE db_users.seller ADD CONSTRAINT FK_99EFCA3BF5B7AF75 FOREIGN KEY (address_id) REFERENCES db_users.address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE db_users.usersAddress ADD CONSTRAINT FK_AFD11D2A67B3B43D FOREIGN KEY (users_id) REFERENCES db_users.users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE db_users.usersAddress ADD CONSTRAINT FK_AFD11D2AF5B7AF75 FOREIGN KEY (address_id) REFERENCES db_users.address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE db_users.seller DROP CONSTRAINT FK_99EFCA3B67B3B43D');
        $this->addSql('ALTER TABLE db_users.seller DROP CONSTRAINT FK_99EFCA3BF5B7AF75');
        $this->addSql('ALTER TABLE db_users.usersAddress DROP CONSTRAINT FK_AFD11D2A67B3B43D');
        $this->addSql('ALTER TABLE db_users.usersAddress DROP CONSTRAINT FK_AFD11D2AF5B7AF75');
        $this->addSql('DROP TABLE db_users.address');
        $this->addSql('DROP TABLE db_users.seller');
        $this->addSql('DROP TABLE db_users.users');
        $this->addSql('DROP TABLE db_users.usersAddress');
    }
}
