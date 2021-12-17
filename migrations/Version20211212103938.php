<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211212103938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe CHANGE tournoi_id tournoi_id INT NOT NULL');
        $this->addSql('ALTER TABLE matchjouer ADD vainqueur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matchjouer ADD CONSTRAINT FK_BE149B84773C35EE FOREIGN KEY (vainqueur_id) REFERENCES equipe (id)');
        $this->addSql('CREATE INDEX IDX_BE149B84773C35EE ON matchjouer (vainqueur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe CHANGE tournoi_id tournoi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matchjouer DROP FOREIGN KEY FK_BE149B84773C35EE');
        $this->addSql('DROP INDEX IDX_BE149B84773C35EE ON matchjouer');
        $this->addSql('ALTER TABLE matchjouer DROP vainqueur_id');
    }
}
