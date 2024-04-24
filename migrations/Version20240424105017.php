<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424105017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE composition_equipe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipe_id INTEGER NOT NULL, hote BOOLEAN NOT NULL, CONSTRAINT FK_E44EA6056D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E44EA6056D861B89 ON composition_equipe (equipe_id)');
        $this->addSql('CREATE TABLE equipe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL)');
        $this->addSql('CREATE TABLE jeu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_equipe_un_id INTEGER NOT NULL, id_eqipe_deux_id INTEGER NOT NULL, vainqueur_id INTEGER DEFAULT NULL, score_equipe_un INTEGER NOT NULL, score_equipe_deux INTEGER NOT NULL, date DATETIME NOT NULL, CONSTRAINT FK_82E48DB5CC24E748 FOREIGN KEY (id_equipe_un_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_82E48DB57B343664 FOREIGN KEY (id_eqipe_deux_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_82E48DB5773C35EE FOREIGN KEY (vainqueur_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_82E48DB5CC24E748 ON jeu (id_equipe_un_id)');
        $this->addSql('CREATE INDEX IDX_82E48DB57B343664 ON jeu (id_eqipe_deux_id)');
        $this->addSql('CREATE INDEX IDX_82E48DB5773C35EE ON jeu (vainqueur_id)');
        $this->addSql('CREATE TABLE joueur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, composition_equipe_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(50) NOT NULL, pseudo VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , date_maj DATETIME DEFAULT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , email VARCHAR(255) NOT NULL, CONSTRAINT FK_FD71A9C59B370C7 FOREIGN KEY (composition_equipe_id) REFERENCES composition_equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_FD71A9C59B370C7 ON joueur (composition_equipe_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON joueur (email)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE composition_equipe');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE jeu');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
