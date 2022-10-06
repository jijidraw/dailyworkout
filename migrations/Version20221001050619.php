<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221001050619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE diary (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_917BEDE2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diary_note (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, weight INT DEFAULT NULL, content LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_medals (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, gold TINYINT(1) NOT NULL, silver TINYINT(1) NOT NULL, bronze TINYINT(1) NOT NULL, INDEX IDX_CC3D9B49A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diary ADD CONSTRAINT FK_917BEDE2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_medals ADD CONSTRAINT FK_CC3D9B49A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE images ADD diary_note_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A7CA4FF41 FOREIGN KEY (diary_note_id) REFERENCES diary_note (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A7CA4FF41 ON images (diary_note_id)');
        $this->addSql('ALTER TABLE user_stat ADD points INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A7CA4FF41');
        $this->addSql('DROP TABLE diary');
        $this->addSql('DROP TABLE diary_note');
        $this->addSql('DROP TABLE user_medals');
        $this->addSql('DROP INDEX IDX_E01FBE6A7CA4FF41 ON images');
        $this->addSql('ALTER TABLE images DROP diary_note_id');
        $this->addSql('ALTER TABLE user_stat DROP points');
    }
}
