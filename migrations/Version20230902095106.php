<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230902095106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE edition (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livre ADD livre_id INT DEFAULT NULL, DROP editeur');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F9937D925CB FOREIGN KEY (livre_id) REFERENCES edition (id)');
        $this->addSql('CREATE INDEX IDX_AC634F9937D925CB ON livre (livre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F9937D925CB');
        $this->addSql('DROP TABLE edition');
        $this->addSql('DROP INDEX IDX_AC634F9937D925CB ON livre');
        $this->addSql('ALTER TABLE livre ADD editeur VARCHAR(255) NOT NULL, DROP livre_id');
    }
}
