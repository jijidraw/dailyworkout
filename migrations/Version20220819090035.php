<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220819090035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reporting (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, private_message_id INT DEFAULT NULL, post_id INT DEFAULT NULL, challenge_id INT DEFAULT NULL, challenge_comment_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, team_id INT DEFAULT NULL, user_reported_id INT DEFAULT NULL, reported_at DATETIME NOT NULL, INDEX IDX_BD7CFA9FA76ED395 (user_id), INDEX IDX_BD7CFA9F5EBFB95E (private_message_id), INDEX IDX_BD7CFA9F4B89032C (post_id), INDEX IDX_BD7CFA9F98A21AC6 (challenge_id), INDEX IDX_BD7CFA9F9879641A (challenge_comment_id), INDEX IDX_BD7CFA9FF8697D13 (comment_id), INDEX IDX_BD7CFA9F296CD8AE (team_id), INDEX IDX_BD7CFA9F3DA62723 (user_reported_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9F5EBFB95E FOREIGN KEY (private_message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9F4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9F98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9F9879641A FOREIGN KEY (challenge_comment_id) REFERENCES challenge_comment (id)');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9FF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9F296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9F3DA62723 FOREIGN KEY (user_reported_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reporting');
    }
}
