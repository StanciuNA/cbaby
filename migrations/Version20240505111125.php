<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505111125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__composition_equipe AS SELECT id, equipe_id, joueur_id, hote FROM composition_equipe');
        $this->addSql('DROP TABLE composition_equipe');
        $this->addSql('CREATE TABLE composition_equipe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipe_id INTEGER NOT NULL, joueur_id INTEGER DEFAULT NULL, hote BOOLEAN NOT NULL, CONSTRAINT FK_E44EA6056D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E44EA605A9E2D76C FOREIGN KEY (joueur_id) REFERENCES joueur (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO composition_equipe (id, equipe_id, joueur_id, hote) SELECT id, equipe_id, joueur_id, hote FROM __temp__composition_equipe');
        $this->addSql('DROP TABLE __temp__composition_equipe');
        $this->addSql('CREATE INDEX IDX_E44EA605A9E2D76C ON composition_equipe (joueur_id)');
        $this->addSql('CREATE INDEX IDX_E44EA6056D861B89 ON composition_equipe (equipe_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__jeu AS SELECT id, id_equipe_un_id, id_eqipe_deux_id, vainqueur_id, score_equipe_un, score_equipe_deux, date FROM jeu');
        $this->addSql('DROP TABLE jeu');
        $this->addSql('CREATE TABLE jeu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_equipe_un_id INTEGER DEFAULT NULL, id_eqipe_deux_id INTEGER DEFAULT NULL, vainqueur_id INTEGER DEFAULT NULL, score_equipe_un INTEGER DEFAULT NULL, score_equipe_deux INTEGER DEFAULT NULL, date DATETIME NOT NULL, CONSTRAINT FK_82E48DB5CC24E748 FOREIGN KEY (id_equipe_un_id) REFERENCES equipe (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_82E48DB57B343664 FOREIGN KEY (id_eqipe_deux_id) REFERENCES equipe (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_82E48DB5773C35EE FOREIGN KEY (vainqueur_id) REFERENCES equipe (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO jeu (id, id_equipe_un_id, id_eqipe_deux_id, vainqueur_id, score_equipe_un, score_equipe_deux, date) SELECT id, id_equipe_un_id, id_eqipe_deux_id, vainqueur_id, score_equipe_un, score_equipe_deux, date FROM __temp__jeu');
        $this->addSql('DROP TABLE __temp__jeu');
        $this->addSql('CREATE INDEX IDX_82E48DB5773C35EE ON jeu (vainqueur_id)');
        $this->addSql('CREATE INDEX IDX_82E48DB57B343664 ON jeu (id_eqipe_deux_id)');
        $this->addSql('CREATE INDEX IDX_82E48DB5CC24E748 ON jeu (id_equipe_un_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__joueur AS SELECT id, nom, prenom, pseudo, date_creation, date_maj, password, roles, email FROM joueur');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('CREATE TABLE joueur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(50) NOT NULL, pseudo VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , date_maj DATETIME DEFAULT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , email VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO joueur (id, nom, prenom, pseudo, date_creation, date_maj, password, roles, email) SELECT id, nom, prenom, pseudo, date_creation, date_maj, password, roles, email FROM __temp__joueur');
        $this->addSql('DROP TABLE __temp__joueur');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON joueur (email)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__notification AS SELECT id, expediteur_id, destinataire_id, type FROM notification');
        $this->addSql('DROP TABLE notification');
        $this->addSql('CREATE TABLE notification (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, expediteur_id INTEGER NOT NULL, destinataire_id INTEGER NOT NULL, type VARCHAR(255) NOT NULL, entite INTEGER NOT NULL, CONSTRAINT FK_BF5476CA10335F61 FOREIGN KEY (expediteur_id) REFERENCES joueur (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BF5476CAA4F84F6E FOREIGN KEY (destinataire_id) REFERENCES joueur (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO notification (id, expediteur_id, destinataire_id, type) SELECT id, expediteur_id, destinataire_id, type FROM __temp__notification');
        $this->addSql('DROP TABLE __temp__notification');
        $this->addSql('CREATE INDEX IDX_BF5476CAA4F84F6E ON notification (destinataire_id)');
        $this->addSql('CREATE INDEX IDX_BF5476CA10335F61 ON notification (expediteur_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__messenger_messages AS SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM messenger_messages');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM __temp__messenger_messages');
        $this->addSql('DROP TABLE __temp__messenger_messages');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__composition_equipe AS SELECT id, equipe_id, joueur_id, hote FROM composition_equipe');
        $this->addSql('DROP TABLE composition_equipe');
        $this->addSql('CREATE TABLE composition_equipe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipe_id INTEGER NOT NULL, joueur_id INTEGER NOT NULL, hote BOOLEAN NOT NULL, CONSTRAINT FK_E44EA6056D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E44EA605A9E2D76C FOREIGN KEY (joueur_id) REFERENCES joueur (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO composition_equipe (id, equipe_id, joueur_id, hote) SELECT id, equipe_id, joueur_id, hote FROM __temp__composition_equipe');
        $this->addSql('DROP TABLE __temp__composition_equipe');
        $this->addSql('CREATE INDEX IDX_E44EA6056D861B89 ON composition_equipe (equipe_id)');
        $this->addSql('CREATE INDEX IDX_E44EA605A9E2D76C ON composition_equipe (joueur_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__jeu AS SELECT id, id_equipe_un_id, id_eqipe_deux_id, vainqueur_id, score_equipe_un, score_equipe_deux, date FROM jeu');
        $this->addSql('DROP TABLE jeu');
        $this->addSql('CREATE TABLE jeu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_equipe_un_id INTEGER NOT NULL, id_eqipe_deux_id INTEGER NOT NULL, vainqueur_id INTEGER DEFAULT NULL, score_equipe_un INTEGER NOT NULL, score_equipe_deux INTEGER NOT NULL, date DATETIME NOT NULL, CONSTRAINT FK_82E48DB5CC24E748 FOREIGN KEY (id_equipe_un_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_82E48DB57B343664 FOREIGN KEY (id_eqipe_deux_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_82E48DB5773C35EE FOREIGN KEY (vainqueur_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO jeu (id, id_equipe_un_id, id_eqipe_deux_id, vainqueur_id, score_equipe_un, score_equipe_deux, date) SELECT id, id_equipe_un_id, id_eqipe_deux_id, vainqueur_id, score_equipe_un, score_equipe_deux, date FROM __temp__jeu');
        $this->addSql('DROP TABLE __temp__jeu');
        $this->addSql('CREATE INDEX IDX_82E48DB5CC24E748 ON jeu (id_equipe_un_id)');
        $this->addSql('CREATE INDEX IDX_82E48DB57B343664 ON jeu (id_eqipe_deux_id)');
        $this->addSql('CREATE INDEX IDX_82E48DB5773C35EE ON jeu (vainqueur_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__joueur AS SELECT id, nom, prenom, pseudo, date_creation, date_maj, password, roles, email FROM joueur');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('CREATE TABLE joueur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(50) NOT NULL, pseudo VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL --
(DC2Type:datetime_immutable)
        , date_maj DATETIME DEFAULT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --
(DC2Type:json)
        , email VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO joueur (id, nom, prenom, pseudo, date_creation, date_maj, password, roles, email) SELECT id, nom, prenom, pseudo, date_creation, date_maj, password, roles, email FROM __temp__joueur');
        $this->addSql('DROP TABLE __temp__joueur');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON joueur (email)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__messenger_messages AS SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM messenger_messages');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --
(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --
(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --
(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM __temp__messenger_messages');
        $this->addSql('DROP TABLE __temp__messenger_messages');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__notification AS SELECT id, expediteur_id, destinataire_id, type FROM notification');
        $this->addSql('DROP TABLE notification');
        $this->addSql('CREATE TABLE notification (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, expediteur_id INTEGER NOT NULL, destinataire_id INTEGER NOT NULL, type VARCHAR(255) DEFAULT NULL, data CLOB DEFAULT NULL --
(DC2Type:json)
        , CONSTRAINT FK_BF5476CA10335F61 FOREIGN KEY (expediteur_id) REFERENCES joueur (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BF5476CAA4F84F6E FOREIGN KEY (destinataire_id) REFERENCES joueur (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO notification (id, expediteur_id, destinataire_id, type) SELECT id, expediteur_id, destinataire_id, type FROM __temp__notification');
        $this->addSql('DROP TABLE __temp__notification');
        $this->addSql('CREATE INDEX IDX_BF5476CA10335F61 ON notification (expediteur_id)');
        $this->addSql('CREATE INDEX IDX_BF5476CAA4F84F6E ON notification (destinataire_id)');
    }
}
