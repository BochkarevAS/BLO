<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180830235646 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA drive');
        $this->addSql('ALTER TABLE drives.model DROP CONSTRAINT fk_311e6a24e9eec0c7');
        $this->addSql('ALTER TABLE drives.drive DROP CONSTRAINT fk_8e96ed72d966bf49');
        $this->addSql('ALTER TABLE drives.drive DROP CONSTRAINT fk_8e96ed72e9eec0c7');
        $this->addSql('DROP SEQUENCE drives.brand_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE drives.drive_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE drives.model_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE drive.brand_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE drive.drive_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE drive.model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE drive.brand (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE drive.drive (id INT NOT NULL, brand_id INT DEFAULT NULL, model_id INT DEFAULT NULL, diameter DOUBLE PRECISION NOT NULL, departure DOUBLE PRECISION NOT NULL, drilling VARCHAR(255) NOT NULL, width DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A9DEAB8D44F5D008 ON drive.drive (brand_id)');
        $this->addSql('CREATE INDEX IDX_A9DEAB8D7975B7E7 ON drive.drive (model_id)');
        $this->addSql('CREATE TABLE drive.model (id INT NOT NULL, brand_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_16562CDB44F5D008 ON drive.model (brand_id)');
        $this->addSql('ALTER TABLE drive.drive ADD CONSTRAINT FK_A9DEAB8D44F5D008 FOREIGN KEY (brand_id) REFERENCES drive.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drive.drive ADD CONSTRAINT FK_A9DEAB8D7975B7E7 FOREIGN KEY (model_id) REFERENCES drive.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drive.model ADD CONSTRAINT FK_16562CDB44F5D008 FOREIGN KEY (brand_id) REFERENCES drive.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE drives.model');
        $this->addSql('DROP TABLE drives.brand');
        $this->addSql('DROP TABLE drives.drive');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA drives');
        $this->addSql('ALTER TABLE drive.drive DROP CONSTRAINT FK_A9DEAB8D44F5D008');
        $this->addSql('ALTER TABLE drive.drive DROP CONSTRAINT FK_A9DEAB8D7975B7E7');
        $this->addSql('ALTER TABLE drive.model DROP CONSTRAINT FK_16562CDB44F5D008');
        $this->addSql('DROP SEQUENCE drive.brand_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE drive.drive_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE drive.model_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE drives.brand_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE drives.drive_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE drives.model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE drives.model (id INT NOT NULL, brands_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_311e6a24e9eec0c7 ON drives.model (brands_id)');
        $this->addSql('CREATE TABLE drives.brand (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE drives.drive (id INT NOT NULL, brands_id INT DEFAULT NULL, models_id INT DEFAULT NULL, diameter DOUBLE PRECISION NOT NULL, departure DOUBLE PRECISION NOT NULL, drilling VARCHAR(255) NOT NULL, width DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_8e96ed72d966bf49 ON drives.drive (models_id)');
        $this->addSql('CREATE INDEX idx_8e96ed72e9eec0c7 ON drives.drive (brands_id)');
        $this->addSql('ALTER TABLE drives.model ADD CONSTRAINT fk_311e6a24e9eec0c7 FOREIGN KEY (brands_id) REFERENCES drives.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drives.drive ADD CONSTRAINT fk_8e96ed72d966bf49 FOREIGN KEY (models_id) REFERENCES drives.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE drives.drive ADD CONSTRAINT fk_8e96ed72e9eec0c7 FOREIGN KEY (brands_id) REFERENCES drives.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE drive.brand');
        $this->addSql('DROP TABLE drive.drive');
        $this->addSql('DROP TABLE drive.model');
    }
}
