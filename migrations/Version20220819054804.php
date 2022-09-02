<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220819054804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge DROP is_reporting');
        $this->addSql('ALTER TABLE challenge_comment DROP is_reporting');
        $this->addSql('ALTER TABLE comment DROP is_reporting');
        $this->addSql('ALTER TABLE message DROP is_reporting');
        $this->addSql('ALTER TABLE post DROP is_reporting');
        $this->addSql('ALTER TABLE team DROP is_reporting');
        $this->addSql('ALTER TABLE team_post DROP is_reporting');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge ADD is_reporting TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE challenge_comment ADD is_reporting TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE comment ADD is_reporting TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE message ADD is_reporting TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE post ADD is_reporting TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE team ADD is_reporting TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE team_post ADD is_reporting TINYINT(1) NOT NULL');
    }
}
