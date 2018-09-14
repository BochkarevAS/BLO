<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180914023105 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE client.statistic_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE notification__message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE client.statistic (id INT NOT NULL, user_id INT DEFAULT NULL, hosts INT NOT NULL, views INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_96307835A76ED395 ON client.statistic (user_id)');
        $this->addSql('CREATE TABLE notification__message (id INT NOT NULL, type VARCHAR(255) NOT NULL, body JSON NOT NULL, state INT NOT NULL, restart_count INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, completed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX notification_message_state_idx ON notification__message (state)');
        $this->addSql('CREATE INDEX notification_message_created_at_idx ON notification__message (created_at)');
        $this->addSql('CREATE INDEX idx_state ON notification__message (state)');
        $this->addSql('CREATE INDEX idx_created_at ON notification__message (created_at)');
        $this->addSql('ALTER TABLE client.statistic ADD CONSTRAINT FK_96307835A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE client.statistic_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE notification__message_id_seq CASCADE');
        $this->addSql('DROP TABLE client.statistic');
        $this->addSql('DROP TABLE notification__message');
    }
}
