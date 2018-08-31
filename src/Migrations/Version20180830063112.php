<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180830063112 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE tyre.comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tyre.comment (id INT NOT NULL, user_id INT DEFAULT NULL, tyre_id INT DEFAULT NULL, comment TEXT NOT NULL, approved BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D85A7CAAA76ED395 ON tyre.comment (user_id)');
        $this->addSql('CREATE INDEX IDX_D85A7CAABF8CDFF3 ON tyre.comment (tyre_id)');
        $this->addSql('ALTER TABLE tyre.comment ADD CONSTRAINT FK_D85A7CAAA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyre.comment ADD CONSTRAINT FK_D85A7CAABF8CDFF3 FOREIGN KEY (tyre_id) REFERENCES tyre.tyre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.part ADD CONSTRAINT FK_F715C7344290F12B FOREIGN KEY (mark_id) REFERENCES part.mark (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE tyre.comment_id_seq CASCADE');
        $this->addSql('DROP TABLE tyre.comment');
        $this->addSql('ALTER TABLE part.part DROP CONSTRAINT FK_F715C7344290F12B');
    }
}
