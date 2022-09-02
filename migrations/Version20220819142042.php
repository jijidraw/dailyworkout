<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220819142042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge_comment ADD challenge_id INT NOT NULL');
        $this->addSql('ALTER TABLE challenge_comment ADD CONSTRAINT FK_78E41DE998A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('CREATE INDEX IDX_78E41DE998A21AC6 ON challenge_comment (challenge_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge_comment DROP FOREIGN KEY FK_78E41DE998A21AC6');
        $this->addSql('DROP INDEX IDX_78E41DE998A21AC6 ON challenge_comment');
        $this->addSql('ALTER TABLE challenge_comment DROP challenge_id');
    }
}
