<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220820135712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reward (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_4ED172533DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reward_user (reward_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8C8246D2E466ACA1 (reward_id), INDEX IDX_8C8246D2A76ED395 (user_id), PRIMARY KEY(reward_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_stat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, post INT DEFAULT NULL, comment INT DEFAULT NULL, workout INT DEFAULT NULL, challenge INT DEFAULT NULL, trophy INT DEFAULT NULL, follower INT DEFAULT NULL, following INT DEFAULT NULL, sport INT DEFAULT NULL, UNIQUE INDEX UNIQ_5A39B3E8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED172533DA5256D FOREIGN KEY (image_id) REFERENCES image_system (id)');
        $this->addSql('ALTER TABLE reward_user ADD CONSTRAINT FK_8C8246D2E466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reward_user ADD CONSTRAINT FK_8C8246D2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_stat ADD CONSTRAINT FK_5A39B3E8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward_user DROP FOREIGN KEY FK_8C8246D2E466ACA1');
        $this->addSql('DROP TABLE reward');
        $this->addSql('DROP TABLE reward_user');
        $this->addSql('DROP TABLE user_stat');
    }
}
