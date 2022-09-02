<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220812160518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification ADD user_id INT DEFAULT NULL, ADD post_id INT DEFAULT NULL, ADD message_id INT DEFAULT NULL, ADD team_id INT DEFAULT NULL, ADD challenge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA537A1329 FOREIGN KEY (message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CAA76ED395 ON notification (user_id)');
        $this->addSql('CREATE INDEX IDX_BF5476CA4B89032C ON notification (post_id)');
        $this->addSql('CREATE INDEX IDX_BF5476CA537A1329 ON notification (message_id)');
        $this->addSql('CREATE INDEX IDX_BF5476CA296CD8AE ON notification (team_id)');
        $this->addSql('CREATE INDEX IDX_BF5476CA98A21AC6 ON notification (challenge_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA4B89032C');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA537A1329');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA296CD8AE');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA98A21AC6');
        $this->addSql('DROP INDEX IDX_BF5476CAA76ED395 ON notification');
        $this->addSql('DROP INDEX IDX_BF5476CA4B89032C ON notification');
        $this->addSql('DROP INDEX IDX_BF5476CA537A1329 ON notification');
        $this->addSql('DROP INDEX IDX_BF5476CA296CD8AE ON notification');
        $this->addSql('DROP INDEX IDX_BF5476CA98A21AC6 ON notification');
        $this->addSql('ALTER TABLE notification DROP user_id, DROP post_id, DROP message_id, DROP team_id, DROP challenge_id');
    }
}
