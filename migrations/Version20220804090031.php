<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804090031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A1B8179FB');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A517FE9FE');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A89D40298');
        $this->addSql('DROP INDEX IDX_E01FBE6A517FE9FE ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6A89D40298 ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6A1B8179FB ON images');
        $this->addSql('ALTER TABLE images DROP exercice_id, DROP sports_list_id, DROP equipment_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images ADD exercice_id INT DEFAULT NULL, ADD sports_list_id INT DEFAULT NULL, ADD equipment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A1B8179FB FOREIGN KEY (sports_list_id) REFERENCES sports_list (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A89D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A517FE9FE ON images (equipment_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A89D40298 ON images (exercice_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A1B8179FB ON images (sports_list_id)');
    }
}
