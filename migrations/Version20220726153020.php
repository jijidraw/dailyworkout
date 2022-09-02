<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220726153020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6AC292CD19');
        $this->addSql('DROP INDEX IDX_57698A6AC292CD19 ON role');
        $this->addSql('ALTER TABLE role DROP team_member_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE role ADD team_member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6AC292CD19 FOREIGN KEY (team_member_id) REFERENCES team_member (id)');
        $this->addSql('CREATE INDEX IDX_57698A6AC292CD19 ON role (team_member_id)');
    }
}
