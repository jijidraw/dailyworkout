<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221004183826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_preference (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, is_alcool TINYINT(1) NOT NULL, is_meditation TINYINT(1) NOT NULL, is_tabac TINYINT(1) NOT NULL, is_healthy TINYINT(1) NOT NULL, is_training TINYINT(1) NOT NULL, is_weight TINYINT(1) NOT NULL, is_water TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_FA0E76BFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE diary_note ADD tabac INT DEFAULT NULL, ADD is_meditation TINYINT(1) DEFAULT NULL, ADD is_water TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_preference');
        $this->addSql('ALTER TABLE diary_note DROP tabac, DROP is_meditation, DROP is_water');
    }
}
