<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180827234809 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE part.carcases_engines (carcase_id INT NOT NULL, engine_id INT NOT NULL, PRIMARY KEY(carcase_id, engine_id))');
        $this->addSql('CREATE INDEX IDX_62B1BEDF2E4BDF84 ON part.carcases_engines (carcase_id)');
        $this->addSql('CREATE INDEX IDX_62B1BEDFE78C9C0A ON part.carcases_engines (engine_id)');
        $this->addSql('ALTER TABLE part.carcases_engines ADD CONSTRAINT FK_62B1BEDF2E4BDF84 FOREIGN KEY (carcase_id) REFERENCES part.carcase (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.carcases_engines ADD CONSTRAINT FK_62B1BEDFE78C9C0A FOREIGN KEY (engine_id) REFERENCES part.engine (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE part.carcases_engines');
    }
}
