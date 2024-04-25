<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425144459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__notification AS SELECT id, expediteur_id, data, type FROM notification');
        $this->addSql('DROP TABLE notification');
        $this->addSql('CREATE TABLE notification (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, expediteur_id INTEGER NOT NULL, destinataire_id INTEGER NOT NULL, data CLOB DEFAULT NULL --(DC2Type:json)
        , type VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_BF5476CA10335F61 FOREIGN KEY (expediteur_id) REFERENCES joueur (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BF5476CAA4F84F6E FOREIGN KEY (destinataire_id) REFERENCES joueur (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO notification (id, expediteur_id, data, type) SELECT id, expediteur_id, data, type FROM __temp__notification');
        $this->addSql('DROP TABLE __temp__notification');
        $this->addSql('CREATE INDEX IDX_BF5476CA10335F61 ON notification (expediteur_id)');
        $this->addSql('CREATE INDEX IDX_BF5476CAA4F84F6E ON notification (destinataire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__notification AS SELECT id, expediteur_id, data, type FROM notification');
        $this->addSql('DROP TABLE notification');
        $this->addSql('CREATE TABLE notification (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, expediteur_id INTEGER NOT NULL, data CLOB DEFAULT NULL --(DC2Type:json)
        , type VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_BF5476CA10335F61 FOREIGN KEY (expediteur_id) REFERENCES joueur (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO notification (id, expediteur_id, data, type) SELECT id, expediteur_id, data, type FROM __temp__notification');
        $this->addSql('DROP TABLE __temp__notification');
        $this->addSql('CREATE INDEX IDX_BF5476CA10335F61 ON notification (expediteur_id)');
    }
}
