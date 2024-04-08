<?php

declare(strict_types=1);

namespace DoctrineMigrationsReviews;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328155336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_reviews');
        $this->addSql('CREATE TABLE db_reviews.review (id UUID NOT NULL, comment TEXT DEFAULT NULL, note DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, product UUID NOT NULL, "users" UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN db_reviews.review.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_reviews.review.product IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN db_reviews.review."users" IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE db_reviews.review');
        $this->addSql('DROP SCHEMA db_reviews');
    }
}
