<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220813160935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge_player DROP FOREIGN KEY FK_6BA4D9A498A21AC6');
        $this->addSql('DROP INDEX IDX_6BA4D9A498A21AC6 ON challenge_player');
        $this->addSql('ALTER TABLE challenge_player DROP challenge_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge_player ADD challenge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE challenge_player ADD CONSTRAINT FK_6BA4D9A498A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('CREATE INDEX IDX_6BA4D9A498A21AC6 ON challenge_player (challenge_id)');
    }
}
