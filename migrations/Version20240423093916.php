<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423093916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joueur ADD COLUMN mdp VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE joueur ADD COLUMN email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__joueur AS SELECT id, composition_equipe_id, nom, prenom, pseudo, date_creation, date_maj FROM joueur');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('CREATE TABLE joueur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, composition_equipe_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(50) NOT NULL, pseudo VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , date_maj DATETIME DEFAULT NULL, CONSTRAINT FK_FD71A9C59B370C7 FOREIGN KEY (composition_equipe_id) REFERENCES composition_equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO joueur (id, composition_equipe_id, nom, prenom, pseudo, date_creation, date_maj) SELECT id, composition_equipe_id, nom, prenom, pseudo, date_creation, date_maj FROM __temp__joueur');
        $this->addSql('DROP TABLE __temp__joueur');
        $this->addSql('CREATE INDEX IDX_FD71A9C59B370C7 ON joueur (composition_equipe_id)');
    }
}
