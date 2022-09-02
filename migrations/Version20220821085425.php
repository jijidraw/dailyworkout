<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220821085425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D583730469C5');
        $this->addSql('DROP INDEX IDX_D338D583730469C5 ON equipment');
        $this->addSql('ALTER TABLE equipment DROP equipment_category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment ADD equipment_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D583730469C5 FOREIGN KEY (equipment_category_id) REFERENCES equipment_category (id)');
        $this->addSql('CREATE INDEX IDX_D338D583730469C5 ON equipment (equipment_category_id)');
    }
}
