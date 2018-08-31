<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180830050208 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE part.part DROP CONSTRAINT fk_f715c7344290f12b');
        $this->addSql('DROP SEQUENCE mark_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE client.comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE part.mark_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE client.comment (id INT NOT NULL, user_id INT DEFAULT NULL, message TEXT NOT NULL, product INT NOT NULL, type INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A6B3871FA76ED395 ON client.comment (user_id)');
        $this->addSql('CREATE TABLE part.mark (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE client.comment ADD CONSTRAINT FK_A6B3871FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP TABLE comment');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE part.part DROP CONSTRAINT FK_F715C7344290F12B');
        $this->addSql('DROP SEQUENCE client.comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE part.mark_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE mark_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mark (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, user_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, "integer" VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_9474526ca76ed395 ON comment (user_id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526ca76ed395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE client.comment');
        $this->addSql('DROP TABLE part.mark');
    }
}
