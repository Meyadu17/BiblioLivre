<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230925183704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livre_user (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, bibliotheque_id INT DEFAULT NULL, livre_id INT DEFAULT NULL, INDEX IDX_87F42DC4A76ED395 (user_id), INDEX IDX_87F42DC44419DE7D (bibliotheque_id), INDEX IDX_87F42DC437D925CB (livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livre_user ADD CONSTRAINT FK_87F42DC4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE livre_user ADD CONSTRAINT FK_87F42DC44419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id)');
        $this->addSql('ALTER TABLE livre_user ADD CONSTRAINT FK_87F42DC437D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE livre_bibliotheque DROP FOREIGN KEY FK_B7960A2637D925CB');
        $this->addSql('ALTER TABLE livre_bibliotheque DROP FOREIGN KEY FK_B7960A264419DE7D');
        $this->addSql('DROP TABLE livre_bibliotheque');
        $this->addSql('ALTER TABLE livre DROP isbn');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livre_bibliotheque (id INT AUTO_INCREMENT NOT NULL, livre_id INT DEFAULT NULL, bibliotheque_id INT DEFAULT NULL, INDEX IDX_B7960A2637D925CB (livre_id), INDEX IDX_B7960A264419DE7D (bibliotheque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE livre_bibliotheque ADD CONSTRAINT FK_B7960A2637D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE livre_bibliotheque ADD CONSTRAINT FK_B7960A264419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE livre_user DROP FOREIGN KEY FK_87F42DC4A76ED395');
        $this->addSql('ALTER TABLE livre_user DROP FOREIGN KEY FK_87F42DC44419DE7D');
        $this->addSql('ALTER TABLE livre_user DROP FOREIGN KEY FK_87F42DC437D925CB');
        $this->addSql('DROP TABLE livre_user');
        $this->addSql('ALTER TABLE livre ADD isbn INT DEFAULT NULL');
    }
}
