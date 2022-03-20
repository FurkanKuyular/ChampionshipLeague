<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220319002044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE football_teams (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, won INT NOT NULL, drawn INT NOT NULL, lost INT NOT NULL, goal_difference INT NOT NULL, point INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matches (id INT AUTO_INCREMENT NOT NULL, home_football_team_id INT DEFAULT NULL, away_football_team_id INT DEFAULT NULL, home_football_team_score INT NOT NULL, away_football_team_score INT NOT NULL, week INT NOT NULL, start_date DATETIME DEFAULT NULL, ended_date DATETIME DEFAULT NULL, INDEX IDX_62615BA479CCC4B (home_football_team_id), INDEX IDX_62615BA523A0E41 (away_football_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA479CCC4B FOREIGN KEY (home_football_team_id) REFERENCES football_teams (id)');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA523A0E41 FOREIGN KEY (away_football_team_id) REFERENCES football_teams (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matches DROP FOREIGN KEY FK_62615BA479CCC4B');
        $this->addSql('ALTER TABLE matches DROP FOREIGN KEY FK_62615BA523A0E41');
        $this->addSql('DROP TABLE football_teams');
        $this->addSql('DROP TABLE matches');
    }
}
