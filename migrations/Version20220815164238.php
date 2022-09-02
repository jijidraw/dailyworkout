<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220815164238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE challenge_comment (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at DATETIME NOT NULL, content LONGTEXT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, youtube_link VARCHAR(255) DEFAULT NULL, is_reporting TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_78E41DE93DA5256D (image_id), INDEX IDX_78E41DE9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenge_comment ADD CONSTRAINT FK_78E41DE93DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE challenge_comment ADD CONSTRAINT FK_78E41DE9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE contact_list');
        $this->addSql('DROP TABLE reporting');
        $this->addSql('ALTER TABLE article ADD is_prime TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE comment ADD is_reporting TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE conversation ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD is_reporting TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE muscle_group ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE muscle_group ADD CONSTRAINT FK_323D098E3DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_323D098E3DA5256D ON muscle_group (image_id)');
        $this->addSql('ALTER TABLE notification ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD is_reporting TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact_list (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, contact_id INT DEFAULT NULL, INDEX IDX_6C377AE7E7A1254A (contact_id), INDEX IDX_6C377AE7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reporting (id INT AUTO_INCREMENT NOT NULL, challenge_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, post_id INT DEFAULT NULL, INDEX IDX_BD7CFA9FF8697D13 (comment_id), INDEX IDX_BD7CFA9F4B89032C (post_id), INDEX IDX_BD7CFA9F98A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE contact_list ADD CONSTRAINT FK_6C377AE7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contact_list ADD CONSTRAINT FK_6C377AE7E7A1254A FOREIGN KEY (contact_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9F4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9FF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9F98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('DROP TABLE challenge_comment');
        $this->addSql('ALTER TABLE article DROP is_prime');
        $this->addSql('ALTER TABLE comment DROP is_reporting');
        $this->addSql('ALTER TABLE conversation DROP updated_at');
        $this->addSql('ALTER TABLE message DROP is_reporting');
        $this->addSql('ALTER TABLE muscle_group DROP FOREIGN KEY FK_323D098E3DA5256D');
        $this->addSql('DROP INDEX UNIQ_323D098E3DA5256D ON muscle_group');
        $this->addSql('ALTER TABLE muscle_group DROP image_id');
        $this->addSql('ALTER TABLE notification DROP image');
        $this->addSql('ALTER TABLE post DROP is_reporting');
    }
}
