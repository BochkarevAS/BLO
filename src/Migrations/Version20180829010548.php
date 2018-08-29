<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180829010548 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, user_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, integer VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyre.tyre ALTER width DROP NOT NULL');
        $this->addSql('ALTER TABLE tyre.tyre ALTER height DROP NOT NULL');
        $this->addSql('ALTER TABLE tyre.tyre ALTER diameter DROP NOT NULL');
        $this->addSql('ALTER TABLE tyre.tyre ALTER quantity DROP NOT NULL');
        $this->addSql('ALTER TABLE tyre.tyre ALTER price DROP NOT NULL');
        $this->addSql('ALTER TABLE tyre.tyre ALTER image DROP NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('DROP TABLE comment');
        $this->addSql('ALTER TABLE tyre.tyre ALTER width SET NOT NULL');
        $this->addSql('ALTER TABLE tyre.tyre ALTER height SET NOT NULL');
        $this->addSql('ALTER TABLE tyre.tyre ALTER diameter SET NOT NULL');
        $this->addSql('ALTER TABLE tyre.tyre ALTER quantity SET NOT NULL');
        $this->addSql('ALTER TABLE tyre.tyre ALTER price SET NOT NULL');
        $this->addSql('ALTER TABLE tyre.tyre ALTER image SET NOT NULL');
    }
}
