<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180826233017 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE part.part ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE part.part ADD availability_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE part.part ADD condition_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE part.part ADD CONSTRAINT FK_F715C734A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.part ADD CONSTRAINT FK_F715C73461778466 FOREIGN KEY (availability_id) REFERENCES client.availability (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.part ADD CONSTRAINT FK_F715C734887793B6 FOREIGN KEY (condition_id) REFERENCES client.condition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F715C734A76ED395 ON part.part (user_id)');
        $this->addSql('CREATE INDEX IDX_F715C73461778466 ON part.part (availability_id)');
        $this->addSql('CREATE INDEX IDX_F715C734887793B6 ON part.part (condition_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE part.part DROP CONSTRAINT FK_F715C734A76ED395');
        $this->addSql('ALTER TABLE part.part DROP CONSTRAINT FK_F715C73461778466');
        $this->addSql('ALTER TABLE part.part DROP CONSTRAINT FK_F715C734887793B6');
        $this->addSql('DROP INDEX IDX_F715C734A76ED395');
        $this->addSql('DROP INDEX IDX_F715C73461778466');
        $this->addSql('DROP INDEX IDX_F715C734887793B6');
        $this->addSql('ALTER TABLE part.part DROP user_id');
        $this->addSql('ALTER TABLE part.part DROP availability_id');
        $this->addSql('ALTER TABLE part.part DROP condition_id');
    }
}
