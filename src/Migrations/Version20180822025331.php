<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180822025331 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA parts');
        $this->addSql('ALTER TABLE part.parts_engines DROP CONSTRAINT fk_1ae1f4e78c9c0a');
        $this->addSql('ALTER TABLE part.parts_oems DROP CONSTRAINT fk_769a7e4549fed7ed');
        $this->addSql('ALTER TABLE part.part DROP CONSTRAINT fk_33855b0c44f5d008');
        $this->addSql('ALTER TABLE part.model DROP CONSTRAINT fk_ac5ed35c44f5d008');
        $this->addSql('ALTER TABLE part.parts_engines DROP CONSTRAINT fk_1ae1f44ce34bec');
        $this->addSql('ALTER TABLE part.parts_oems DROP CONSTRAINT fk_769a7e454ce34bec');
        $this->addSql('ALTER TABLE part.parts_carcases DROP CONSTRAINT fk_d4026b4b4ce34bec');
        $this->addSql('ALTER TABLE part.parts_carcases DROP CONSTRAINT fk_d4026b4b2e4bdf84');
        $this->addSql('ALTER TABLE part.models_carcases DROP CONSTRAINT fk_f26c23cb2e4bdf84');
        $this->addSql('ALTER TABLE part.part DROP CONSTRAINT fk_33855b0c7975b7e7');
        $this->addSql('ALTER TABLE part.models_carcases DROP CONSTRAINT fk_f26c23cb7975b7e7');
        $this->addSql('DROP SEQUENCE part.brand_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE part.carcase_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE part.engine_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE part.model_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE part.oem_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE part.part_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE parts.brand_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parts.carcase_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parts.engine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parts.model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parts.oem_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parts.part_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE parts.brand (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE parts.carcase (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE parts.models_carcases (carcase_id INT NOT NULL, model_id INT NOT NULL, PRIMARY KEY(carcase_id, model_id))');
        $this->addSql('CREATE INDEX IDX_F26C23CB2E4BDF84 ON parts.models_carcases (carcase_id)');
        $this->addSql('CREATE INDEX IDX_F26C23CB7975B7E7 ON parts.models_carcases (model_id)');
        $this->addSql('CREATE TABLE parts.engine (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE parts.model (id INT NOT NULL, brand_id INT DEFAULT NULL, rank INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AC5ED35C44F5D008 ON parts.model (brand_id)');
        $this->addSql('CREATE TABLE parts.oem (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE parts.part (id INT NOT NULL, brand_id INT DEFAULT NULL, model_id INT DEFAULT NULL, city_id INT DEFAULT NULL, company_id INT DEFAULT NULL, name TEXT NOT NULL, hash VARCHAR(255) NOT NULL, price NUMERIC(10, 0) NOT NULL, slug VARCHAR(255) NOT NULL, picture JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_33855B0C44F5D008 ON parts.part (brand_id)');
        $this->addSql('CREATE INDEX IDX_33855B0C7975B7E7 ON parts.part (model_id)');
        $this->addSql('CREATE INDEX IDX_33855B0C8BAC62AF ON parts.part (city_id)');
        $this->addSql('CREATE INDEX IDX_33855B0C979B1AD6 ON parts.part (company_id)');
        $this->addSql('CREATE TABLE parts.parts_carcases (part_id INT NOT NULL, carcase_id INT NOT NULL, PRIMARY KEY(part_id, carcase_id))');
        $this->addSql('CREATE INDEX IDX_D4026B4B4CE34BEC ON parts.parts_carcases (part_id)');
        $this->addSql('CREATE INDEX IDX_D4026B4B2E4BDF84 ON parts.parts_carcases (carcase_id)');
        $this->addSql('CREATE TABLE parts.parts_engines (part_id INT NOT NULL, engine_id INT NOT NULL, PRIMARY KEY(part_id, engine_id))');
        $this->addSql('CREATE INDEX IDX_1AE1F44CE34BEC ON parts.parts_engines (part_id)');
        $this->addSql('CREATE INDEX IDX_1AE1F4E78C9C0A ON parts.parts_engines (engine_id)');
        $this->addSql('CREATE TABLE parts.parts_oems (part_id INT NOT NULL, oem_id INT NOT NULL, PRIMARY KEY(part_id, oem_id))');
        $this->addSql('CREATE INDEX IDX_769A7E454CE34BEC ON parts.parts_oems (part_id)');
        $this->addSql('CREATE INDEX IDX_769A7E4549FED7ED ON parts.parts_oems (oem_id)');
        $this->addSql('ALTER TABLE parts.models_carcases ADD CONSTRAINT FK_F26C23CB2E4BDF84 FOREIGN KEY (carcase_id) REFERENCES parts.carcase (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.models_carcases ADD CONSTRAINT FK_F26C23CB7975B7E7 FOREIGN KEY (model_id) REFERENCES parts.model (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.model ADD CONSTRAINT FK_AC5ED35C44F5D008 FOREIGN KEY (brand_id) REFERENCES parts.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.part ADD CONSTRAINT FK_33855B0C44F5D008 FOREIGN KEY (brand_id) REFERENCES parts.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.part ADD CONSTRAINT FK_33855B0C7975B7E7 FOREIGN KEY (model_id) REFERENCES parts.model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.part ADD CONSTRAINT FK_33855B0C8BAC62AF FOREIGN KEY (city_id) REFERENCES region.city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.part ADD CONSTRAINT FK_33855B0C979B1AD6 FOREIGN KEY (company_id) REFERENCES client.company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.parts_carcases ADD CONSTRAINT FK_D4026B4B4CE34BEC FOREIGN KEY (part_id) REFERENCES parts.part (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.parts_carcases ADD CONSTRAINT FK_D4026B4B2E4BDF84 FOREIGN KEY (carcase_id) REFERENCES parts.carcase (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.parts_engines ADD CONSTRAINT FK_1AE1F44CE34BEC FOREIGN KEY (part_id) REFERENCES parts.part (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.parts_engines ADD CONSTRAINT FK_1AE1F4E78C9C0A FOREIGN KEY (engine_id) REFERENCES parts.engine (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.parts_oems ADD CONSTRAINT FK_769A7E454CE34BEC FOREIGN KEY (part_id) REFERENCES parts.part (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.parts_oems ADD CONSTRAINT FK_769A7E4549FED7ED FOREIGN KEY (oem_id) REFERENCES parts.oem (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE user_company1');
        $this->addSql('DROP TABLE part.engine');
        $this->addSql('DROP TABLE part.parts_engines');
        $this->addSql('DROP TABLE part.oem');
        $this->addSql('DROP TABLE part.parts_oems');
        $this->addSql('DROP TABLE part.brand');
        $this->addSql('DROP TABLE part.part');
        $this->addSql('DROP TABLE part.parts_carcases');
        $this->addSql('DROP TABLE part.carcase');
        $this->addSql('DROP TABLE part.model');
        $this->addSql('DROP TABLE part.models_carcases');
        $this->addSql('ALTER TABLE users ADD avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER INDEX tyre.idx_98ef507744f5d008 RENAME TO IDX_5BC22C3744F5D008');
        $this->addSql('ALTER INDEX tyre.idx_1b38c908cd28d0b3 RENAME TO IDX_3ACA28F5CD28D0B3');
        $this->addSql('ALTER INDEX tyre.idx_1b38c908c8dafa57 RENAME TO IDX_3ACA28F5C8DAFA57');
        $this->addSql('ALTER INDEX tyre.idx_1b38c90844f5d008 RENAME TO IDX_3ACA28F544F5D008');
        $this->addSql('ALTER INDEX tyre.idx_1b38c9087975b7e7 RENAME TO IDX_3ACA28F57975B7E7');
        $this->addSql('ALTER INDEX tyre.idx_1b38c9088bac62af RENAME TO IDX_3ACA28F58BAC62AF');
        $this->addSql('ALTER INDEX tyre.idx_1b38c908979b1ad6 RENAME TO IDX_3ACA28F5979B1AD6');
        $this->addSql('ALTER INDEX tyre.idx_1b38c90861778466 RENAME TO IDX_3ACA28F561778466');
        $this->addSql('ALTER INDEX tyre.idx_1b38c908887793b6 RENAME TO IDX_3ACA28F5887793B6');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA part');
        $this->addSql('ALTER TABLE parts.model DROP CONSTRAINT FK_AC5ED35C44F5D008');
        $this->addSql('ALTER TABLE parts.part DROP CONSTRAINT FK_33855B0C44F5D008');
        $this->addSql('ALTER TABLE parts.models_carcases DROP CONSTRAINT FK_F26C23CB2E4BDF84');
        $this->addSql('ALTER TABLE parts.parts_carcases DROP CONSTRAINT FK_D4026B4B2E4BDF84');
        $this->addSql('ALTER TABLE parts.parts_engines DROP CONSTRAINT FK_1AE1F4E78C9C0A');
        $this->addSql('ALTER TABLE parts.models_carcases DROP CONSTRAINT FK_F26C23CB7975B7E7');
        $this->addSql('ALTER TABLE parts.part DROP CONSTRAINT FK_33855B0C7975B7E7');
        $this->addSql('ALTER TABLE parts.parts_oems DROP CONSTRAINT FK_769A7E4549FED7ED');
        $this->addSql('ALTER TABLE parts.parts_carcases DROP CONSTRAINT FK_D4026B4B4CE34BEC');
        $this->addSql('ALTER TABLE parts.parts_engines DROP CONSTRAINT FK_1AE1F44CE34BEC');
        $this->addSql('ALTER TABLE parts.parts_oems DROP CONSTRAINT FK_769A7E454CE34BEC');
        $this->addSql('DROP SEQUENCE parts.brand_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parts.carcase_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parts.engine_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parts.model_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parts.oem_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parts.part_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE part.brand_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE part.carcase_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE part.engine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE part.model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE part.oem_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE part.part_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_company1 (id TEXT DEFAULT NULL, display TEXT DEFAULT NULL, closed TEXT DEFAULT NULL, previev TEXT DEFAULT NULL, date TEXT DEFAULT NULL, usert TEXT DEFAULT NULL, name TEXT DEFAULT NULL, text TEXT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, type TEXT DEFAULT NULL, in_index TEXT DEFAULT NULL, imgs TEXT DEFAULT NULL, region TEXT DEFAULT NULL, city TEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, phones TEXT DEFAULT NULL, address TEXT DEFAULT NULL, scheme VARCHAR(300) DEFAULT NULL, emails TEXT DEFAULT NULL, services TEXT DEFAULT NULL, rating TEXT DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, tested TEXT DEFAULT NULL, subscribe_product TEXT DEFAULT NULL, subscribe_request TEXT DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, hash VARCHAR(255) DEFAULT NULL, subscribe_review TEXT DEFAULT NULL, photos TEXT DEFAULT NULL, coordinates VARCHAR(255) DEFAULT NULL, pars_company TEXT DEFAULT NULL, coordinates_search VARCHAR(255) DEFAULT NULL, dizlike TEXT DEFAULT NULL, liket TEXT DEFAULT NULL, schedule TEXT DEFAULT NULL, sp1 TEXT DEFAULT NULL, sp2 TEXT DEFAULT NULL, sp3 TEXT DEFAULT NULL, sp4 TEXT DEFAULT NULL, sp5 TEXT DEFAULT NULL, sp6 TEXT DEFAULT NULL, sp7 TEXT DEFAULT NULL, sp8 TEXT DEFAULT NULL, sp9 TEXT DEFAULT NULL, sp10 TEXT DEFAULT NULL, sp11 TEXT DEFAULT NULL, sp12 TEXT DEFAULT NULL, subscribe_product_insert TEXT DEFAULT NULL, subscribe_request_insert TEXT DEFAULT NULL, subscribe_review_insert TEXT DEFAULT NULL, main_office TEXT DEFAULT NULL, branch TEXT DEFAULT NULL, phones_new TEXT DEFAULT NULL, phones_edited TEXT DEFAULT NULL, schedule_new TEXT DEFAULT NULL, schedule_edited TEXT DEFAULT NULL, address_legal TEXT DEFAULT NULL, bank_details TEXT DEFAULT NULL, credit_cards TEXT DEFAULT NULL, date_reminders TEXT DEFAULT NULL, info TEXT DEFAULT NULL, save_price TEXT DEFAULT NULL, under_order VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE part.engine (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE part.parts_engines (part_id INT NOT NULL, engine_id INT NOT NULL, PRIMARY KEY(part_id, engine_id))');
        $this->addSql('CREATE INDEX idx_1ae1f44ce34bec ON part.parts_engines (part_id)');
        $this->addSql('CREATE INDEX idx_1ae1f4e78c9c0a ON part.parts_engines (engine_id)');
        $this->addSql('CREATE TABLE part.oem (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE part.parts_oems (part_id INT NOT NULL, oem_id INT NOT NULL, PRIMARY KEY(part_id, oem_id))');
        $this->addSql('CREATE INDEX idx_769a7e4549fed7ed ON part.parts_oems (oem_id)');
        $this->addSql('CREATE INDEX idx_769a7e454ce34bec ON part.parts_oems (part_id)');
        $this->addSql('CREATE TABLE part.brand (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE part.part (id INT NOT NULL, brand_id INT DEFAULT NULL, city_id INT DEFAULT NULL, company_id INT DEFAULT NULL, model_id INT DEFAULT NULL, name TEXT NOT NULL, hash VARCHAR(255) NOT NULL, price NUMERIC(10, 0) NOT NULL, slug VARCHAR(255) NOT NULL, picture JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_33855b0c44f5d008 ON part.part (brand_id)');
        $this->addSql('CREATE INDEX idx_33855b0c7975b7e7 ON part.part (model_id)');
        $this->addSql('CREATE INDEX idx_33855b0c8bac62af ON part.part (city_id)');
        $this->addSql('CREATE INDEX idx_33855b0c979b1ad6 ON part.part (company_id)');
        $this->addSql('CREATE TABLE part.parts_carcases (part_id INT NOT NULL, carcase_id INT NOT NULL, PRIMARY KEY(part_id, carcase_id))');
        $this->addSql('CREATE INDEX idx_d4026b4b2e4bdf84 ON part.parts_carcases (carcase_id)');
        $this->addSql('CREATE INDEX idx_d4026b4b4ce34bec ON part.parts_carcases (part_id)');
        $this->addSql('CREATE TABLE part.carcase (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE part.model (id INT NOT NULL, brand_id INT DEFAULT NULL, rank INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_ac5ed35c44f5d008 ON part.model (brand_id)');
        $this->addSql('CREATE TABLE part.models_carcases (carcase_id INT NOT NULL, model_id INT NOT NULL, PRIMARY KEY(carcase_id, model_id))');
        $this->addSql('CREATE INDEX idx_f26c23cb2e4bdf84 ON part.models_carcases (carcase_id)');
        $this->addSql('CREATE INDEX idx_f26c23cb7975b7e7 ON part.models_carcases (model_id)');
        $this->addSql('ALTER TABLE part.parts_engines ADD CONSTRAINT fk_1ae1f44ce34bec FOREIGN KEY (part_id) REFERENCES part.part (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.parts_engines ADD CONSTRAINT fk_1ae1f4e78c9c0a FOREIGN KEY (engine_id) REFERENCES part.engine (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.parts_oems ADD CONSTRAINT fk_769a7e4549fed7ed FOREIGN KEY (oem_id) REFERENCES part.oem (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.parts_oems ADD CONSTRAINT fk_769a7e454ce34bec FOREIGN KEY (part_id) REFERENCES part.part (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.part ADD CONSTRAINT fk_33855b0c44f5d008 FOREIGN KEY (brand_id) REFERENCES part.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.part ADD CONSTRAINT fk_33855b0c7975b7e7 FOREIGN KEY (model_id) REFERENCES part.model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.part ADD CONSTRAINT fk_33855b0c8bac62af FOREIGN KEY (city_id) REFERENCES region.city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.part ADD CONSTRAINT fk_33855b0c979b1ad6 FOREIGN KEY (company_id) REFERENCES client.company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.parts_carcases ADD CONSTRAINT fk_d4026b4b2e4bdf84 FOREIGN KEY (carcase_id) REFERENCES part.carcase (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.parts_carcases ADD CONSTRAINT fk_d4026b4b4ce34bec FOREIGN KEY (part_id) REFERENCES part.part (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.model ADD CONSTRAINT fk_ac5ed35c44f5d008 FOREIGN KEY (brand_id) REFERENCES part.brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.models_carcases ADD CONSTRAINT fk_f26c23cb2e4bdf84 FOREIGN KEY (carcase_id) REFERENCES part.carcase (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE part.models_carcases ADD CONSTRAINT fk_f26c23cb7975b7e7 FOREIGN KEY (model_id) REFERENCES part.model (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE parts.brand');
        $this->addSql('DROP TABLE parts.carcase');
        $this->addSql('DROP TABLE parts.models_carcases');
        $this->addSql('DROP TABLE parts.engine');
        $this->addSql('DROP TABLE parts.model');
        $this->addSql('DROP TABLE parts.oem');
        $this->addSql('DROP TABLE parts.part');
        $this->addSql('DROP TABLE parts.parts_carcases');
        $this->addSql('DROP TABLE parts.parts_engines');
        $this->addSql('DROP TABLE parts.parts_oems');
        $this->addSql('ALTER TABLE users DROP avatar');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f544f5d008 RENAME TO idx_1b38c90844f5d008');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f5c8dafa57 RENAME TO idx_1b38c908c8dafa57');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f57975b7e7 RENAME TO idx_1b38c9087975b7e7');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f5887793b6 RENAME TO idx_1b38c908887793b6');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f561778466 RENAME TO idx_1b38c90861778466');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f5979b1ad6 RENAME TO idx_1b38c908979b1ad6');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f58bac62af RENAME TO idx_1b38c9088bac62af');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f5cd28d0b3 RENAME TO idx_1b38c908cd28d0b3');
        $this->addSql('ALTER INDEX tyre.idx_5bc22c3744f5d008 RENAME TO idx_98ef507744f5d008');
    }
}
