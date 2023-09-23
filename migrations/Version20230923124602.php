<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230923124602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre_bibliotheque DROP FOREIGN KEY FK_B7960A2637D925CB');
        $this->addSql('ALTER TABLE livre_bibliotheque DROP FOREIGN KEY FK_B7960A264419DE7D');
        $this->addSql('ALTER TABLE livre_bibliotheque ADD id INT AUTO_INCREMENT NOT NULL, ADD modifiable TINYINT(1) NOT NULL, CHANGE livre_id livre_id INT DEFAULT NULL, CHANGE bibliotheque_id bibliotheque_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE livre_bibliotheque ADD CONSTRAINT FK_B7960A2637D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE livre_bibliotheque ADD CONSTRAINT FK_B7960A264419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre_bibliotheque MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE livre_bibliotheque DROP FOREIGN KEY FK_B7960A2637D925CB');
        $this->addSql('ALTER TABLE livre_bibliotheque DROP FOREIGN KEY FK_B7960A264419DE7D');
        $this->addSql('DROP INDEX `PRIMARY` ON livre_bibliotheque');
        $this->addSql('ALTER TABLE livre_bibliotheque DROP id, DROP modifiable, CHANGE livre_id livre_id INT NOT NULL, CHANGE bibliotheque_id bibliotheque_id INT NOT NULL');
        $this->addSql('ALTER TABLE livre_bibliotheque ADD CONSTRAINT FK_B7960A2637D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_bibliotheque ADD CONSTRAINT FK_B7960A264419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_bibliotheque ADD PRIMARY KEY (livre_id, bibliotheque_id)');
    }
}
