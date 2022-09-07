<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906141123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercice_sports_list (exercice_id INT NOT NULL, sports_list_id INT NOT NULL, INDEX IDX_F6BF00BF89D40298 (exercice_id), INDEX IDX_F6BF00BF1B8179FB (sports_list_id), PRIMARY KEY(exercice_id, sports_list_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercice_sports_list ADD CONSTRAINT FK_F6BF00BF89D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercice_sports_list ADD CONSTRAINT FK_F6BF00BF1B8179FB FOREIGN KEY (sports_list_id) REFERENCES sports_list (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE exercice_sports_list');
    }
}
