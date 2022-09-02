<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220807103011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workout_sports_list (workout_id INT NOT NULL, sports_list_id INT NOT NULL, INDEX IDX_D0FE6226A6CCCFC9 (workout_id), INDEX IDX_D0FE62261B8179FB (sports_list_id), PRIMARY KEY(workout_id, sports_list_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workout_sports_list ADD CONSTRAINT FK_D0FE6226A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workout_sports_list ADD CONSTRAINT FK_D0FE62261B8179FB FOREIGN KEY (sports_list_id) REFERENCES sports_list (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE workout_sports_list');
    }
}
