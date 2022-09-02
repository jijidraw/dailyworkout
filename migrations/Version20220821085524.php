<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220821085524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment_equipment_category (equipment_id INT NOT NULL, equipment_category_id INT NOT NULL, INDEX IDX_133F5AB5517FE9FE (equipment_id), INDEX IDX_133F5AB5730469C5 (equipment_category_id), PRIMARY KEY(equipment_id, equipment_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipment_equipment_category ADD CONSTRAINT FK_133F5AB5517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_equipment_category ADD CONSTRAINT FK_133F5AB5730469C5 FOREIGN KEY (equipment_category_id) REFERENCES equipment_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE equipment_equipment_category');
    }
}
