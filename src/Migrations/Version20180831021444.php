<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180831021444 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

//        $this->addSql('ALTER TABLE part.part DROP CONSTRAINT fk_f715c7344290f12b');
//        $this->addSql('DROP INDEX IDX_F715C7344290F12B');
        $this->addSql('ALTER TABLE part.part RENAME COLUMN mark_id TO marking_id');
        $this->addSql('ALTER TABLE part.part ADD CONSTRAINT FK_F715C734DD47B885 FOREIGN KEY (marking_id) REFERENCES part.mark (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F715C734DD47B885 ON part.part (marking_id)');
        $this->addSql('ALTER TABLE drive.drive ADD availability_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE drive.drive ADD condition_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE drive.drive ADD CONSTRAINT FK_A9DEAB8D61778466 FOREIGN KEY (availability_id) REFERENCES client.availability (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drive.drive ADD CONSTRAINT FK_A9DEAB8D887793B6 FOREIGN KEY (condition_id) REFERENCES client.condition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A9DEAB8D61778466 ON drive.drive (availability_id)');
        $this->addSql('CREATE INDEX IDX_A9DEAB8D887793B6 ON drive.drive (condition_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA drives');
        $this->addSql('ALTER TABLE drive.drive DROP CONSTRAINT FK_A9DEAB8D61778466');
        $this->addSql('ALTER TABLE drive.drive DROP CONSTRAINT FK_A9DEAB8D887793B6');
        $this->addSql('DROP INDEX IDX_A9DEAB8D61778466');
        $this->addSql('DROP INDEX IDX_A9DEAB8D887793B6');
        $this->addSql('ALTER TABLE drive.drive DROP availability_id');
        $this->addSql('ALTER TABLE drive.drive DROP condition_id');
        $this->addSql('ALTER TABLE part.part DROP CONSTRAINT FK_F715C734DD47B885');
        $this->addSql('DROP INDEX IDX_F715C734DD47B885');
        $this->addSql('ALTER TABLE part.part RENAME COLUMN marking_id TO mark_id');
        $this->addSql('ALTER TABLE part.part ADD CONSTRAINT fk_f715c7344290f12b FOREIGN KEY (mark_id) REFERENCES part.mark (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F715C7344290F12B ON part.part (mark_id)');
    }
}
