<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230906173609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bibliotheque (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bibliotheque_livre (bibliotheque_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_929FAFE84419DE7D (bibliotheque_id), INDEX IDX_929FAFE837D925CB (livre_id), PRIMARY KEY(bibliotheque_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bibliotheque_livre ADD CONSTRAINT FK_929FAFE84419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bibliotheque_livre ADD CONSTRAINT FK_929FAFE837D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bibliotheque_livre DROP FOREIGN KEY FK_929FAFE84419DE7D');
        $this->addSql('ALTER TABLE bibliotheque_livre DROP FOREIGN KEY FK_929FAFE837D925CB');
        $this->addSql('DROP TABLE bibliotheque');
        $this->addSql('DROP TABLE bibliotheque_livre');
    }
}
