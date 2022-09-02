<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220822113918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE difficulty (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenge ADD level_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D70989515FB14BA7 FOREIGN KEY (level_id) REFERENCES difficulty (id)');
        $this->addSql('CREATE INDEX IDX_D70989515FB14BA7 ON challenge (level_id)');
        $this->addSql('ALTER TABLE workout ADD level_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB725FB14BA7 FOREIGN KEY (level_id) REFERENCES difficulty (id)');
        $this->addSql('CREATE INDEX IDX_649FFB725FB14BA7 ON workout (level_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge DROP FOREIGN KEY FK_D70989515FB14BA7');
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB725FB14BA7');
        $this->addSql('DROP TABLE difficulty');
        $this->addSql('DROP INDEX IDX_D70989515FB14BA7 ON challenge');
        $this->addSql('ALTER TABLE challenge DROP level_id');
        $this->addSql('DROP INDEX IDX_649FFB725FB14BA7 ON workout');
        $this->addSql('ALTER TABLE workout DROP level_id');
    }
}
