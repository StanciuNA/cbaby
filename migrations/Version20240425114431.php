<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425114431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__joueur AS SELECT id, nom, prenom, pseudo, date_creation, date_maj, password, roles, email FROM joueur');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('CREATE TABLE joueur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(50) NOT NULL, pseudo VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , date_maj DATETIME DEFAULT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , email VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO joueur (id, nom, prenom, pseudo, date_creation, date_maj, password, roles, email) SELECT id, nom, prenom, pseudo, date_creation, date_maj, password, roles, email FROM __temp__joueur');
        $this->addSql('DROP TABLE __temp__joueur');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON joueur (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__joueur AS SELECT id, nom, prenom, pseudo, date_creation, date_maj, password, roles, email FROM joueur');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('CREATE TABLE joueur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, composition_equipe_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(50) NOT NULL, pseudo VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , date_maj DATETIME DEFAULT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , email VARCHAR(255) NOT NULL, CONSTRAINT FK_FD71A9C59B370C7 FOREIGN KEY (composition_equipe_id) REFERENCES composition_equipe (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO joueur (id, nom, prenom, pseudo, date_creation, date_maj, password, roles, email) SELECT id, nom, prenom, pseudo, date_creation, date_maj, password, roles, email FROM __temp__joueur');
        $this->addSql('DROP TABLE __temp__joueur');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON joueur (email)');
        $this->addSql('CREATE INDEX IDX_FD71A9C59B370C7 ON joueur (composition_equipe_id)');
    }
}
