<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220723145049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_member DROP FOREIGN KEY FK_6FFBDA1D60322AC');
        $this->addSql('DROP INDEX IDX_6FFBDA1D60322AC ON team_member');
        $this->addSql('ALTER TABLE team_member DROP role_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_member ADD role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team_member ADD CONSTRAINT FK_6FFBDA1D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_6FFBDA1D60322AC ON team_member (role_id)');
    }
}
