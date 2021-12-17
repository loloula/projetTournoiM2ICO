<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211209174931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE poulee (id INT AUTO_INCREMENT NOT NULL, tour_id INT DEFAULT NULL, nompoule VARCHAR(30) NOT NULL, INDEX IDX_99FC242115ED8D43 (tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE poulee ADD CONSTRAINT FK_99FC242115ED8D43 FOREIGN KEY (tour_id) REFERENCES tour (id)');
        $this->addSql('ALTER TABLE equipe ADD poule_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA1526596FD8 FOREIGN KEY (poule_id) REFERENCES poulee (id)');
        $this->addSql('CREATE INDEX IDX_2449BA1526596FD8 ON equipe (poule_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA1526596FD8');
        $this->addSql('DROP TABLE poulee');
        $this->addSql('DROP INDEX IDX_2449BA1526596FD8 ON equipe');
        $this->addSql('ALTER TABLE equipe DROP poule_id');
    }
}
