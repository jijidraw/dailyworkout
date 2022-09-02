<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220820144839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED172533DA5256D');
        $this->addSql('DROP INDEX UNIQ_4ED172533DA5256D ON reward');
        $this->addSql('ALTER TABLE reward DROP image_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED172533DA5256D FOREIGN KEY (image_id) REFERENCES image_system (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4ED172533DA5256D ON reward (image_id)');
    }
}
