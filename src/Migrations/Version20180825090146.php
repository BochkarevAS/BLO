<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180825090146 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE part.models_carcases (model_id INT NOT NULL, carcase_id INT NOT NULL, PRIMARY KEY(model_id, carcase_id))');
        $this->addSql('CREATE INDEX IDX_8F2BEA067975B7E7 ON part.models_carcases (model_id)');
        $this->addSql('CREATE INDEX IDX_8F2BEA062E4BDF84 ON part.models_carcases (carcase_id)');
        $this->addSql('ALTER TABLE part.models_carcases ADD CONSTRAINT FK_8F2BEA067975B7E7 FOREIGN KEY (model_id) REFERENCES part.model (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.models_carcases ADD CONSTRAINT FK_8F2BEA062E4BDF84 FOREIGN KEY (carcase_id) REFERENCES part.carcase (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE part.models_carcases');
    }
}
