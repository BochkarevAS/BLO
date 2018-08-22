<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180822013100 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA tyre');
        $this->addSql('ALTER TABLE tyres.tyre DROP CONSTRAINT fk_1b38c908c8dafa57');
        $this->addSql('ALTER TABLE tyres.tyre DROP CONSTRAINT fk_1b38c908cd28d0b3');
        $this->addSql('ALTER TABLE tyres.tyre DROP CONSTRAINT fk_1b38c90844f5d008');
        $this->addSql('ALTER TABLE tyres.model DROP CONSTRAINT fk_98ef507744f5d008');
        $this->addSql('ALTER TABLE tyres.tyre DROP CONSTRAINT fk_1b38c9087975b7e7');
        $this->addSql('DROP SEQUENCE tyres.brand_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tyres.model_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tyres.seasonality_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tyres.thorn_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tyres.tyre_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE tyre.tyre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tyre.brand_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tyre.model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tyre.seasonality_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tyre.thorn_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tyre.tyre (id INT NOT NULL, thorn_id INT DEFAULT NULL, seasonality_id INT DEFAULT NULL, brand_id INT DEFAULT NULL, model_id INT DEFAULT NULL, city_id INT DEFAULT NULL, company_id INT DEFAULT NULL, availability_id INT DEFAULT NULL, condition_id INT DEFAULT NULL, width INT NOT NULL, height INT NOT NULL, diameter DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, hash VARCHAR(255) NOT NULL, price NUMERIC(10, 0) NOT NULL, picture JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3ACA28F5CD28D0B3 ON tyre.tyre (thorn_id)');
        $this->addSql('CREATE INDEX IDX_3ACA28F5C8DAFA57 ON tyre.tyre (seasonality_id)');
        $this->addSql('CREATE INDEX IDX_3ACA28F544F5D008 ON tyre.tyre (brand_id)');
        $this->addSql('CREATE INDEX IDX_3ACA28F57975B7E7 ON tyre.tyre (model_id)');
        $this->addSql('CREATE INDEX IDX_3ACA28F58BAC62AF ON tyre.tyre (city_id)');
        $this->addSql('CREATE INDEX IDX_3ACA28F5979B1AD6 ON tyre.tyre (company_id)');
        $this->addSql('CREATE INDEX IDX_3ACA28F561778466 ON tyre.tyre (availability_id)');
        $this->addSql('CREATE INDEX IDX_3ACA28F5887793B6 ON tyre.tyre (condition_id)');
        $this->addSql('CREATE INDEX width_idx ON tyre.tyre (width)');
        $this->addSql('CREATE INDEX height_idx ON tyre.tyre (height)');
        $this->addSql('CREATE INDEX diameter_idx ON tyre.tyre (diameter)');
        $this->addSql('CREATE INDEX quantity_idx ON tyre.tyre (quantity)');
        $this->addSql('CREATE TABLE tyre.brand (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tyre.model (id INT NOT NULL, brand_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5BC22C3744F5D008 ON tyre.model (brand_id)');
        $this->addSql('CREATE TABLE tyre.seasonality (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tyre.thorn (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE tyre.tyre ADD CONSTRAINT FK_3ACA28F5CD28D0B3 FOREIGN KEY (thorn_id) REFERENCES tyre.thorn (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyre.tyre ADD CONSTRAINT FK_3ACA28F5C8DAFA57 FOREIGN KEY (seasonality_id) REFERENCES tyre.seasonality (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyre.tyre ADD CONSTRAINT FK_3ACA28F544F5D008 FOREIGN KEY (brand_id) REFERENCES tyre.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyre.tyre ADD CONSTRAINT FK_3ACA28F57975B7E7 FOREIGN KEY (model_id) REFERENCES tyre.model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyre.tyre ADD CONSTRAINT FK_3ACA28F58BAC62AF FOREIGN KEY (city_id) REFERENCES region.city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyre.tyre ADD CONSTRAINT FK_3ACA28F5979B1AD6 FOREIGN KEY (company_id) REFERENCES client.company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyre.tyre ADD CONSTRAINT FK_3ACA28F561778466 FOREIGN KEY (availability_id) REFERENCES client.availability (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyre.tyre ADD CONSTRAINT FK_3ACA28F5887793B6 FOREIGN KEY (condition_id) REFERENCES client.condition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyre.model ADD CONSTRAINT FK_5BC22C3744F5D008 FOREIGN KEY (brand_id) REFERENCES tyre.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE tyres.seasonality');
        $this->addSql('DROP TABLE tyres.thorn');
        $this->addSql('DROP TABLE tyres.tyre');
        $this->addSql('DROP TABLE tyres.brand');
        $this->addSql('DROP TABLE tyres.model');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA tyres');
        $this->addSql('CREATE SCHEMA admin');
        $this->addSql('ALTER TABLE tyre.tyre DROP CONSTRAINT FK_3ACA28F544F5D008');
        $this->addSql('ALTER TABLE tyre.model DROP CONSTRAINT FK_5BC22C3744F5D008');
        $this->addSql('ALTER TABLE tyre.tyre DROP CONSTRAINT FK_3ACA28F57975B7E7');
        $this->addSql('ALTER TABLE tyre.tyre DROP CONSTRAINT FK_3ACA28F5C8DAFA57');
        $this->addSql('ALTER TABLE tyre.tyre DROP CONSTRAINT FK_3ACA28F5CD28D0B3');
        $this->addSql('DROP SEQUENCE tyre.tyre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tyre.brand_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tyre.model_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tyre.seasonality_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tyre.thorn_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE tyres.brand_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tyres.model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tyres.seasonality_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tyres.thorn_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tyres.tyre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tyres.seasonality (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tyres.thorn (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tyres.tyre (id INT NOT NULL, thorn_id INT DEFAULT NULL, seasonality_id INT DEFAULT NULL, brand_id INT DEFAULT NULL, city_id INT DEFAULT NULL, company_id INT DEFAULT NULL, model_id INT DEFAULT NULL, availability_id INT DEFAULT NULL, condition_id INT DEFAULT NULL, width INT NOT NULL, height INT NOT NULL, diameter DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, hash VARCHAR(255) NOT NULL, price NUMERIC(10, 0) NOT NULL, picture JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_1b38c908887793b6 ON tyres.tyre (condition_id)');
        $this->addSql('CREATE INDEX idx_1b38c90844f5d008 ON tyres.tyre (brand_id)');
        $this->addSql('CREATE INDEX height_idx ON tyres.tyre (height)');
        $this->addSql('CREATE INDEX idx_1b38c908979b1ad6 ON tyres.tyre (company_id)');
        $this->addSql('CREATE INDEX idx_1b38c908cd28d0b3 ON tyres.tyre (thorn_id)');
        $this->addSql('CREATE INDEX diameter_idx ON tyres.tyre (diameter)');
        $this->addSql('CREATE INDEX idx_1b38c90861778466 ON tyres.tyre (availability_id)');
        $this->addSql('CREATE INDEX idx_1b38c9088bac62af ON tyres.tyre (city_id)');
        $this->addSql('CREATE INDEX idx_1b38c9087975b7e7 ON tyres.tyre (model_id)');
        $this->addSql('CREATE INDEX width_idx ON tyres.tyre (width)');
        $this->addSql('CREATE INDEX idx_1b38c908c8dafa57 ON tyres.tyre (seasonality_id)');
        $this->addSql('CREATE INDEX quantity_idx ON tyres.tyre (quantity)');
        $this->addSql('CREATE TABLE tyres.brand (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tyres.model (id INT NOT NULL, brand_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_98ef507744f5d008 ON tyres.model (brand_id)');
        $this->addSql('ALTER TABLE tyres.tyre ADD CONSTRAINT fk_1b38c90844f5d008 FOREIGN KEY (brand_id) REFERENCES tyres.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyres.tyre ADD CONSTRAINT fk_1b38c90861778466 FOREIGN KEY (availability_id) REFERENCES client.availability (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyres.tyre ADD CONSTRAINT fk_1b38c9087975b7e7 FOREIGN KEY (model_id) REFERENCES tyres.model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyres.tyre ADD CONSTRAINT fk_1b38c908887793b6 FOREIGN KEY (condition_id) REFERENCES client.condition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyres.tyre ADD CONSTRAINT fk_1b38c9088bac62af FOREIGN KEY (city_id) REFERENCES region.city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyres.tyre ADD CONSTRAINT fk_1b38c908979b1ad6 FOREIGN KEY (company_id) REFERENCES client.company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyres.tyre ADD CONSTRAINT fk_1b38c908c8dafa57 FOREIGN KEY (seasonality_id) REFERENCES tyres.seasonality (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyres.tyre ADD CONSTRAINT fk_1b38c908cd28d0b3 FOREIGN KEY (thorn_id) REFERENCES tyres.thorn (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyres.model ADD CONSTRAINT fk_98ef507744f5d008 FOREIGN KEY (brand_id) REFERENCES tyres.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE tyre.tyre');
        $this->addSql('DROP TABLE tyre.brand');
        $this->addSql('DROP TABLE tyre.model');
        $this->addSql('DROP TABLE tyre.seasonality');
        $this->addSql('DROP TABLE tyre.thorn');
    }
}
