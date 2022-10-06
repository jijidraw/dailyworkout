<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221003084306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diary_note ADD user_id INT NOT NULL, ADD cheatmeal TINYINT(1) NOT NULL, ADD alcool TINYINT(1) NOT NULL, ADD training TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE diary_note ADD CONSTRAINT FK_D467BBBFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D467BBBFA76ED395 ON diary_note (user_id)');
        $this->addSql('ALTER TABLE user ADD is_diary TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diary_note DROP FOREIGN KEY FK_D467BBBFA76ED395');
        $this->addSql('DROP INDEX IDX_D467BBBFA76ED395 ON diary_note');
        $this->addSql('ALTER TABLE diary_note DROP user_id, DROP cheatmeal, DROP alcool, DROP training');
        $this->addSql('ALTER TABLE user DROP is_diary');
    }
}
