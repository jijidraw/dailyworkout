<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220723115450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images_profiles ADD team_id INT DEFAULT NULL, ADD event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images_profiles ADD CONSTRAINT FK_2813F85A296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE images_profiles ADD CONSTRAINT FK_2813F85A71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2813F85A296CD8AE ON images_profiles (team_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2813F85A71F7E88B ON images_profiles (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images_profiles DROP FOREIGN KEY FK_2813F85A296CD8AE');
        $this->addSql('ALTER TABLE images_profiles DROP FOREIGN KEY FK_2813F85A71F7E88B');
        $this->addSql('DROP INDEX UNIQ_2813F85A296CD8AE ON images_profiles');
        $this->addSql('DROP INDEX UNIQ_2813F85A71F7E88B ON images_profiles');
        $this->addSql('ALTER TABLE images_profiles DROP team_id, DROP event_id');
    }
}
