<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250729221807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Make slugs and timestamps not nullable';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('UPDATE starship SET slug = id, updated_at = arrived_at, created_at = arrived_at');
        $this->addSql('ALTER TABLE starship CHANGE slug slug VARCHAR(255) NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C414E64A989D9B62 ON starship (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_C414E64A989D9B62 ON starship');
        $this->addSql('ALTER TABLE starship CHANGE slug slug VARCHAR(255) DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
