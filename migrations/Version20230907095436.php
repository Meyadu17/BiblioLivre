<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230907095436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bibliotheque ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bibliotheque ADD CONSTRAINT FK_4690D34DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4690D34DA76ED395 ON bibliotheque (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bibliotheque DROP FOREIGN KEY FK_4690D34DA76ED395');
        $this->addSql('DROP INDEX IDX_4690D34DA76ED395 ON bibliotheque');
        $this->addSql('ALTER TABLE bibliotheque DROP user_id');
    }
}
