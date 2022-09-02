<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220821050520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_reward');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_reward (user_id INT NOT NULL, reward_id INT NOT NULL, INDEX IDX_2B83696EA76ED395 (user_id), INDEX IDX_2B83696EE466ACA1 (reward_id), PRIMARY KEY(user_id, reward_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_reward ADD CONSTRAINT FK_2B83696EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_reward ADD CONSTRAINT FK_2B83696EE466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id) ON DELETE CASCADE');
    }
}
