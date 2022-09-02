<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220814052240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_notice (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, equipment_id INT DEFAULT NULL, content LONGTEXT NOT NULL, note INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_2D5F5EFFA76ED395 (user_id), INDEX IDX_2D5F5EFF517FE9FE (equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_notice ADD CONSTRAINT FK_2D5F5EFFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_notice ADD CONSTRAINT FK_2D5F5EFF517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id)');
        $this->addSql('ALTER TABLE equipment ADD equipment_category_id INT DEFAULT NULL, ADD price VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D583730469C5 FOREIGN KEY (equipment_category_id) REFERENCES equipment_category (id)');
        $this->addSql('CREATE INDEX IDX_D338D583730469C5 ON equipment (equipment_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D583730469C5');
        $this->addSql('DROP TABLE equipment_category');
        $this->addSql('DROP TABLE user_notice');
        $this->addSql('DROP INDEX IDX_D338D583730469C5 ON equipment');
        $this->addSql('ALTER TABLE equipment DROP equipment_category_id, DROP price');
    }
}
