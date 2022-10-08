<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007171313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workout ADD sport_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB72AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sports_list (id)');
        $this->addSql('CREATE INDEX IDX_649FFB72AC78BCF8 ON workout (sport_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB72AC78BCF8');
        $this->addSql('DROP INDEX IDX_649FFB72AC78BCF8 ON workout');
        $this->addSql('ALTER TABLE workout DROP sport_id');
    }
}
