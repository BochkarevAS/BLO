<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180808225823 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE parts.parts_models');
        $this->addSql('ALTER TABLE parts.part ADD model_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parts.part ADD CONSTRAINT FK_33855B0C7975B7E7 FOREIGN KEY (model_id) REFERENCES parts.model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_33855B0C7975B7E7 ON parts.part (model_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE parts.parts_models (part_id INT NOT NULL, model_id INT NOT NULL, PRIMARY KEY(part_id, model_id))');
        $this->addSql('CREATE INDEX idx_19f5aed17975b7e7 ON parts.parts_models (model_id)');
        $this->addSql('CREATE INDEX idx_19f5aed14ce34bec ON parts.parts_models (part_id)');
        $this->addSql('ALTER TABLE parts.parts_models ADD CONSTRAINT fk_19f5aed17975b7e7 FOREIGN KEY (model_id) REFERENCES parts.model (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.parts_models ADD CONSTRAINT fk_19f5aed14ce34bec FOREIGN KEY (part_id) REFERENCES parts.part (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.part DROP CONSTRAINT FK_33855B0C7975B7E7');
        $this->addSql('DROP INDEX IDX_33855B0C7975B7E7');
        $this->addSql('ALTER TABLE parts.part DROP model_id');
    }
}
