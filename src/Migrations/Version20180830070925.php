<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180830070925 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE client.comment_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE part.comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE part.comment (id INT NOT NULL, user_id INT DEFAULT NULL, part_id INT DEFAULT NULL, comment TEXT NOT NULL, approved BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_74D23469A76ED395 ON part.comment (user_id)');
        $this->addSql('CREATE INDEX IDX_74D234694CE34BEC ON part.comment (part_id)');
        $this->addSql('ALTER TABLE part.comment ADD CONSTRAINT FK_74D23469A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.comment ADD CONSTRAINT FK_74D234694CE34BEC FOREIGN KEY (part_id) REFERENCES part.part (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE client.comment');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE part.comment_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE client.comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE client.comment (id INT NOT NULL, user_id INT DEFAULT NULL, message TEXT NOT NULL, product INT NOT NULL, type INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_a6b3871fa76ed395 ON client.comment (user_id)');
        $this->addSql('ALTER TABLE client.comment ADD CONSTRAINT fk_a6b3871fa76ed395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE part.comment');
    }
}
