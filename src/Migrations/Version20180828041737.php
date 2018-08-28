<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180828041737 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE part.parts_carcases');
        $this->addSql('ALTER TABLE part.part ADD carcase_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE part.part ADD CONSTRAINT FK_F715C7342E4BDF84 FOREIGN KEY (carcase_id) REFERENCES part.carcase (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F715C7342E4BDF84 ON part.part (carcase_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE part.parts_carcases (part_id INT NOT NULL, carcase_id INT NOT NULL, PRIMARY KEY(part_id, carcase_id))');
        $this->addSql('CREATE INDEX idx_945517c42e4bdf84 ON part.parts_carcases (carcase_id)');
        $this->addSql('CREATE INDEX idx_945517c44ce34bec ON part.parts_carcases (part_id)');
        $this->addSql('ALTER TABLE part.parts_carcases ADD CONSTRAINT fk_d4026b4b2e4bdf84 FOREIGN KEY (carcase_id) REFERENCES part.carcase (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.parts_carcases ADD CONSTRAINT fk_d4026b4b4ce34bec FOREIGN KEY (part_id) REFERENCES part.part (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.part DROP CONSTRAINT FK_F715C7342E4BDF84');
        $this->addSql('DROP INDEX IDX_F715C7342E4BDF84');
        $this->addSql('ALTER TABLE part.part DROP carcase_id');
    }
}
