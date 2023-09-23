<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230923130045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bibliotheque ADD modifiable TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE livre_bibliotheque DROP modifiable');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre_bibliotheque ADD modifiable TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE bibliotheque DROP modifiable');
    }
}
