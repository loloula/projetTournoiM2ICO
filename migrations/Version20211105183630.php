<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211105183630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement ADD datedebut VARCHAR(15) DEFAULT NULL, ADD datefin VARCHAR(15) DEFAULT NULL, DROP date_debut, DROP date_fin');
        $this->addSql('ALTER TABLE tournoi CHANGE nom nomt VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement ADD date_debut DATETIME NOT NULL, ADD date_fin DATETIME NOT NULL, DROP datedebut, DROP datefin');
        $this->addSql('ALTER TABLE tournoi CHANGE nomt nom VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
