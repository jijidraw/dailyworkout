<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220812151529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, created_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, updated_at DATETIME NOT NULL, link VARCHAR(255) DEFAULT NULL, youtube_link VARCHAR(255) DEFAULT NULL, INDEX IDX_23A0E66F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_category (id INT AUTO_INCREMENT NOT NULL, articles_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_53A4EDAA1EBAF6CC (articles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge (id INT AUTO_INCREMENT NOT NULL, workout_id INT DEFAULT NULL, creator_challenge_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, link VARCHAR(255) DEFAULT NULL, youtube_link VARCHAR(255) DEFAULT NULL, INDEX IDX_D7098951A6CCCFC9 (workout_id), INDEX IDX_D7098951AF1D8482 (creator_challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_player (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, is_invite TINYINT(1) NOT NULL, is_challenged TINYINT(1) NOT NULL, is_accomplish TINYINT(1) NOT NULL, INDEX IDX_6BA4D9A4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_player_challenge (challenge_player_id INT NOT NULL, challenge_id INT NOT NULL, INDEX IDX_253484EC39712940 (challenge_player_id), INDEX IDX_253484EC98A21AC6 (challenge_id), PRIMARY KEY(challenge_player_id, challenge_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article_category ADD CONSTRAINT FK_53A4EDAA1EBAF6CC FOREIGN KEY (articles_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D7098951A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id)');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D7098951AF1D8482 FOREIGN KEY (creator_challenge_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE challenge_player ADD CONSTRAINT FK_6BA4D9A4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE challenge_player_challenge ADD CONSTRAINT FK_253484EC39712940 FOREIGN KEY (challenge_player_id) REFERENCES challenge_player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_player_challenge ADD CONSTRAINT FK_253484EC98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A7294869C ON images (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_category DROP FOREIGN KEY FK_53A4EDAA1EBAF6CC');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A7294869C');
        $this->addSql('ALTER TABLE challenge_player_challenge DROP FOREIGN KEY FK_253484EC98A21AC6');
        $this->addSql('ALTER TABLE challenge_player_challenge DROP FOREIGN KEY FK_253484EC39712940');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_category');
        $this->addSql('DROP TABLE challenge');
        $this->addSql('DROP TABLE challenge_player');
        $this->addSql('DROP TABLE challenge_player_challenge');
        $this->addSql('DROP INDEX IDX_E01FBE6A7294869C ON images');
        $this->addSql('ALTER TABLE images DROP article_id');
    }
}
