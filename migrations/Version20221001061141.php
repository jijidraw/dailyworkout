<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221001061141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diary DROP INDEX UNIQ_917BEDE2A76ED395, ADD INDEX IDX_917BEDE2A76ED395 (user_id)');
        $this->addSql('ALTER TABLE diary ADD name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diary DROP INDEX IDX_917BEDE2A76ED395, ADD UNIQUE INDEX UNIQ_917BEDE2A76ED395 (user_id)');
        $this->addSql('ALTER TABLE diary DROP name');
    }
}
