<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425114943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__composition_equipe AS SELECT id, equipe_id, hote FROM composition_equipe');
        $this->addSql('DROP TABLE composition_equipe');
        $this->addSql('CREATE TABLE composition_equipe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipe_id INTEGER NOT NULL, joueur_id INTEGER NOT NULL, hote BOOLEAN NOT NULL, CONSTRAINT FK_E44EA6056D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E44EA605A9E2D76C FOREIGN KEY (joueur_id) REFERENCES joueur (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO composition_equipe (id, equipe_id, hote) SELECT id, equipe_id, hote FROM __temp__composition_equipe');
        $this->addSql('DROP TABLE __temp__composition_equipe');
        $this->addSql('CREATE INDEX IDX_E44EA6056D861B89 ON composition_equipe (equipe_id)');
        $this->addSql('CREATE INDEX IDX_E44EA605A9E2D76C ON composition_equipe (joueur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__composition_equipe AS SELECT id, equipe_id, hote FROM composition_equipe');
        $this->addSql('DROP TABLE composition_equipe');
        $this->addSql('CREATE TABLE composition_equipe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipe_id INTEGER NOT NULL, hote BOOLEAN NOT NULL, CONSTRAINT FK_E44EA6056D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO composition_equipe (id, equipe_id, hote) SELECT id, equipe_id, hote FROM __temp__composition_equipe');
        $this->addSql('DROP TABLE __temp__composition_equipe');
        $this->addSql('CREATE INDEX IDX_E44EA6056D861B89 ON composition_equipe (equipe_id)');
    }
}
