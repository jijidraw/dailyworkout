<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220726172839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images ADD team_post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AB4F0721B FOREIGN KEY (team_post_id) REFERENCES team_post (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AB4F0721B ON images (team_post_id)');
        $this->addSql('ALTER TABLE team_post ADD content LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AB4F0721B');
        $this->addSql('DROP INDEX IDX_E01FBE6AB4F0721B ON images');
        $this->addSql('ALTER TABLE images DROP team_post_id');
        $this->addSql('ALTER TABLE team_post DROP content');
    }
}
