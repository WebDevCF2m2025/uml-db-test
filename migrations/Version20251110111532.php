<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs! 😎
 */
final class Version20251110111532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }
    // YEEEAHHH 😍
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE date_created date_created DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA88B137989D9B62 ON recipe (slug)');
    }
    // NOOOO 😭
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_DA88B137989D9B62 ON recipe');
        $this->addSql('ALTER TABLE recipe CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE date_created date_created DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
