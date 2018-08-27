<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180827052110 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE mark_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mark (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE part.part ADD mark_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE part.part DROP mark');
        $this->addSql('ALTER TABLE part.part ADD CONSTRAINT FK_F715C7344290F12B FOREIGN KEY (mark_id) REFERENCES mark (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F715C7344290F12B ON part.part (mark_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE part.part DROP CONSTRAINT FK_F715C7344290F12B');
        $this->addSql('DROP SEQUENCE mark_id_seq CASCADE');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP INDEX IDX_F715C7344290F12B');
        $this->addSql('ALTER TABLE part.part ADD mark VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE part.part DROP mark_id');
    }
}
