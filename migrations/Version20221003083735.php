<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221003083735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diary_note DROP FOREIGN KEY FK_D467BBBFE020E47A');
        $this->addSql('DROP TABLE diary');
        $this->addSql('DROP INDEX IDX_D467BBBFE020E47A ON diary_note');
        $this->addSql('ALTER TABLE diary_note DROP diary_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE diary (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_917BEDE2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE diary ADD CONSTRAINT FK_917BEDE2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE diary_note ADD diary_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE diary_note ADD CONSTRAINT FK_D467BBBFE020E47A FOREIGN KEY (diary_id) REFERENCES diary (id)');
        $this->addSql('CREATE INDEX IDX_D467BBBFE020E47A ON diary_note (diary_id)');
    }
}
