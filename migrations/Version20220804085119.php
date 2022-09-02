<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804085119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495FE98FC0');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FFB707AD');
        $this->addSql('DROP INDEX IDX_8D93D649FFB707AD ON user');
        $this->addSql('DROP INDEX IDX_8D93D6495FE98FC0 ON user');
        $this->addSql('ALTER TABLE user DROP program_duplicate_id, DROP participate_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD program_duplicate_id INT DEFAULT NULL, ADD participate_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495FE98FC0 FOREIGN KEY (participate_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FFB707AD FOREIGN KEY (program_duplicate_id) REFERENCES program (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649FFB707AD ON user (program_duplicate_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495FE98FC0 ON user (participate_id)');
    }
}
