<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180831071542 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE client.price ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client.price RENAME COLUMN path TO file');
        $this->addSql('ALTER TABLE client.price ADD CONSTRAINT FK_A9DB600AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A9DB600AA76ED395 ON client.price (user_id)');
        $this->addSql('ALTER TABLE part.part DROP CONSTRAINT fk_f715c7344290f12b');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA drives');
        $this->addSql('ALTER TABLE client.price DROP CONSTRAINT FK_A9DB600AA76ED395');
        $this->addSql('DROP INDEX IDX_A9DB600AA76ED395');
        $this->addSql('ALTER TABLE client.price DROP user_id');
        $this->addSql('ALTER TABLE client.price RENAME COLUMN file TO path');
    }
}
