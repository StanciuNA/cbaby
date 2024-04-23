<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423092916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE composition_equipe ADD COLUMN hote BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE jeu ADD COLUMN date DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__composition_equipe AS SELECT id, equipe_id FROM composition_equipe');
        $this->addSql('DROP TABLE composition_equipe');
        $this->addSql('CREATE TABLE composition_equipe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipe_id INTEGER NOT NULL, CONSTRAINT FK_E44EA6056D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO composition_equipe (id, equipe_id) SELECT id, equipe_id FROM __temp__composition_equipe');
        $this->addSql('DROP TABLE __temp__composition_equipe');
        $this->addSql('CREATE INDEX IDX_E44EA6056D861B89 ON composition_equipe (equipe_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__jeu AS SELECT id, id_equipe_un_id, id_eqipe_deux_id, vainqueur_id, score_equipe_un, score_equipe_deux FROM jeu');
        $this->addSql('DROP TABLE jeu');
        $this->addSql('CREATE TABLE jeu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_equipe_un_id INTEGER NOT NULL, id_eqipe_deux_id INTEGER NOT NULL, vainqueur_id INTEGER DEFAULT NULL, score_equipe_un INTEGER NOT NULL, score_equipe_deux INTEGER NOT NULL, CONSTRAINT FK_82E48DB5CC24E748 FOREIGN KEY (id_equipe_un_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_82E48DB57B343664 FOREIGN KEY (id_eqipe_deux_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_82E48DB5773C35EE FOREIGN KEY (vainqueur_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO jeu (id, id_equipe_un_id, id_eqipe_deux_id, vainqueur_id, score_equipe_un, score_equipe_deux) SELECT id, id_equipe_un_id, id_eqipe_deux_id, vainqueur_id, score_equipe_un, score_equipe_deux FROM __temp__jeu');
        $this->addSql('DROP TABLE __temp__jeu');
        $this->addSql('CREATE INDEX IDX_82E48DB5CC24E748 ON jeu (id_equipe_un_id)');
        $this->addSql('CREATE INDEX IDX_82E48DB57B343664 ON jeu (id_eqipe_deux_id)');
        $this->addSql('CREATE INDEX IDX_82E48DB5773C35EE ON jeu (vainqueur_id)');
    }
}
