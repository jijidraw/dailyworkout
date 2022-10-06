<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221003090619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diary_note ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE diary_note ADD CONSTRAINT FK_D467BBBF3DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D467BBBF3DA5256D ON diary_note (image_id)');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A7CA4FF41');
        $this->addSql('DROP INDEX IDX_E01FBE6A7CA4FF41 ON images');
        $this->addSql('ALTER TABLE images DROP diary_note_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diary_note DROP FOREIGN KEY FK_D467BBBF3DA5256D');
        $this->addSql('DROP INDEX UNIQ_D467BBBF3DA5256D ON diary_note');
        $this->addSql('ALTER TABLE diary_note DROP image_id');
        $this->addSql('ALTER TABLE images ADD diary_note_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A7CA4FF41 FOREIGN KEY (diary_note_id) REFERENCES diary_note (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A7CA4FF41 ON images (diary_note_id)');
    }
}
