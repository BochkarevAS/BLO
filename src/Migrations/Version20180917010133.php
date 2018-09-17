<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180917010133 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE client.favorite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE drive.comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE drive.comment (id INT NOT NULL, user_id INT DEFAULT NULL, drive_id INT DEFAULT NULL, comment TEXT NOT NULL, approved BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2A918DDEA76ED395 ON drive.comment (user_id)');
        $this->addSql('CREATE INDEX IDX_2A918DDE86E5E0C4 ON drive.comment (drive_id)');
        $this->addSql('ALTER TABLE drive.comment ADD CONSTRAINT FK_2A918DDEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drive.comment ADD CONSTRAINT FK_2A918DDE86E5E0C4 FOREIGN KEY (drive_id) REFERENCES drive.drive (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drive.drive ADD hash VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE drive.drive ADD price NUMERIC(10, 0) NOT NULL');
        $this->addSql('ALTER TABLE drive.drive ADD image JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD github_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ALTER first_name DROP NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE client.favorite_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE drive.comment_id_seq CASCADE');
        $this->addSql('DROP TABLE drive.comment');
        $this->addSql('ALTER TABLE drive.drive DROP hash');
        $this->addSql('ALTER TABLE drive.drive DROP price');
        $this->addSql('ALTER TABLE drive.drive DROP image');
        $this->addSql('ALTER TABLE users DROP github_id');
        $this->addSql('ALTER TABLE users ALTER first_name SET NOT NULL');
    }
}
