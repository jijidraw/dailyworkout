<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220814132212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation ADD user_a_id INT DEFAULT NULL, ADD user_b_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9415F1F91 FOREIGN KEY (user_a_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E953EAB07F FOREIGN KEY (user_b_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E9415F1F91 ON conversation (user_a_id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E953EAB07F ON conversation (user_b_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9415F1F91');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E953EAB07F');
        $this->addSql('DROP INDEX IDX_8A8E26E9415F1F91 ON conversation');
        $this->addSql('DROP INDEX IDX_8A8E26E953EAB07F ON conversation');
        $this->addSql('ALTER TABLE conversation DROP user_a_id, DROP user_b_id');
    }
}
