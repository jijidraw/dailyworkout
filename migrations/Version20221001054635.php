<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221001054635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diary_note ADD diary_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE diary_note ADD CONSTRAINT FK_D467BBBFE020E47A FOREIGN KEY (diary_id) REFERENCES diary (id)');
        $this->addSql('CREATE INDEX IDX_D467BBBFE020E47A ON diary_note (diary_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diary_note DROP FOREIGN KEY FK_D467BBBFE020E47A');
        $this->addSql('DROP INDEX IDX_D467BBBFE020E47A ON diary_note');
        $this->addSql('ALTER TABLE diary_note DROP diary_id');
    }
}
