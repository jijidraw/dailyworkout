<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220818051348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workout_notation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, workout_id INT DEFAULT NULL, note INT NOT NULL, INDEX IDX_DA195123A76ED395 (user_id), INDEX IDX_DA195123A6CCCFC9 (workout_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workout_notation ADD CONSTRAINT FK_DA195123A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE workout_notation ADD CONSTRAINT FK_DA195123A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE workout_notation');
    }
}
