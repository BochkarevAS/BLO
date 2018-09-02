<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180902033537 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE drive.drive DROP CONSTRAINT FK_A9DEAB8D7975B7E7');
        $this->addSql('ALTER TABLE drive.drive ALTER diameter DROP NOT NULL');
        $this->addSql('ALTER TABLE drive.drive ALTER departure DROP NOT NULL');
        $this->addSql('ALTER TABLE drive.drive ALTER drilling DROP NOT NULL');
        $this->addSql('ALTER TABLE drive.drive ALTER width DROP NOT NULL');
        $this->addSql('ALTER TABLE drive.drive ADD CONSTRAINT FK_A9DEAB8D7975B7E7 FOREIGN KEY (model_id) REFERENCES tyre.model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE drive.drive DROP CONSTRAINT fk_a9deab8d7975b7e7');
        $this->addSql('ALTER TABLE drive.drive ALTER diameter SET NOT NULL');
        $this->addSql('ALTER TABLE drive.drive ALTER departure SET NOT NULL');
        $this->addSql('ALTER TABLE drive.drive ALTER drilling SET NOT NULL');
        $this->addSql('ALTER TABLE drive.drive ALTER width SET NOT NULL');
        $this->addSql('ALTER TABLE drive.drive ADD CONSTRAINT fk_a9deab8d7975b7e7 FOREIGN KEY (model_id) REFERENCES drive.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
