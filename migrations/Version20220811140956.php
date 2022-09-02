<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220811140956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_post ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team_post ADD CONSTRAINT FK_8B6B98F63DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8B6B98F63DA5256D ON team_post (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_post DROP FOREIGN KEY FK_8B6B98F63DA5256D');
        $this->addSql('DROP INDEX UNIQ_8B6B98F63DA5256D ON team_post');
        $this->addSql('ALTER TABLE team_post DROP image_id');
    }
}
