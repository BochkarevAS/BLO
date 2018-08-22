<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180822070119 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE user_company1');
        $this->addSql('ALTER TABLE users ADD avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER INDEX tyre.idx_1b38c908cd28d0b3 RENAME TO IDX_3ACA28F5CD28D0B3');
        $this->addSql('ALTER INDEX tyre.idx_1b38c908c8dafa57 RENAME TO IDX_3ACA28F5C8DAFA57');
        $this->addSql('ALTER INDEX tyre.idx_1b38c90844f5d008 RENAME TO IDX_3ACA28F544F5D008');
        $this->addSql('ALTER INDEX tyre.idx_1b38c9087975b7e7 RENAME TO IDX_3ACA28F57975B7E7');
        $this->addSql('ALTER INDEX tyre.idx_1b38c9088bac62af RENAME TO IDX_3ACA28F58BAC62AF');
        $this->addSql('ALTER INDEX tyre.idx_1b38c908979b1ad6 RENAME TO IDX_3ACA28F5979B1AD6');
        $this->addSql('ALTER INDEX tyre.idx_1b38c90861778466 RENAME TO IDX_3ACA28F561778466');
        $this->addSql('ALTER INDEX tyre.idx_1b38c908887793b6 RENAME TO IDX_3ACA28F5887793B6');
        $this->addSql('ALTER INDEX part.idx_f26c23cb2e4bdf84 RENAME TO IDX_8F2BEA062E4BDF84');
        $this->addSql('ALTER INDEX part.idx_f26c23cb7975b7e7 RENAME TO IDX_8F2BEA067975B7E7');
        $this->addSql('ALTER INDEX part.idx_ac5ed35c44f5d008 RENAME TO IDX_8498FB5E44F5D008');
        $this->addSql('ALTER INDEX part.idx_33855b0c44f5d008 RENAME TO IDX_F715C73444F5D008');
        $this->addSql('ALTER INDEX part.idx_33855b0c7975b7e7 RENAME TO IDX_F715C7347975B7E7');
        $this->addSql('ALTER INDEX part.idx_33855b0c8bac62af RENAME TO IDX_F715C7348BAC62AF');
        $this->addSql('ALTER INDEX part.idx_33855b0c979b1ad6 RENAME TO IDX_F715C734979B1AD6');
        $this->addSql('ALTER INDEX part.idx_d4026b4b4ce34bec RENAME TO IDX_945517C44CE34BEC');
        $this->addSql('ALTER INDEX part.idx_d4026b4b2e4bdf84 RENAME TO IDX_945517C42E4BDF84');
        $this->addSql('ALTER INDEX part.idx_1ae1f44ce34bec RENAME TO IDX_886D081E4CE34BEC');
        $this->addSql('ALTER INDEX part.idx_1ae1f4e78c9c0a RENAME TO IDX_886D081EE78C9C0A');
        $this->addSql('ALTER INDEX part.idx_769a7e454ce34bec RENAME TO IDX_A1A3EEAC4CE34BEC');
        $this->addSql('ALTER INDEX part.idx_769a7e4549fed7ed RENAME TO IDX_A1A3EEAC49FED7ED');
        $this->addSql('ALTER INDEX tyre.idx_98ef507744f5d008 RENAME TO IDX_5BC22C3744F5D008');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE user_company1 (id TEXT DEFAULT NULL, display TEXT DEFAULT NULL, closed TEXT DEFAULT NULL, previev TEXT DEFAULT NULL, date TEXT DEFAULT NULL, usert TEXT DEFAULT NULL, name TEXT DEFAULT NULL, text TEXT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, type TEXT DEFAULT NULL, in_index TEXT DEFAULT NULL, imgs TEXT DEFAULT NULL, region TEXT DEFAULT NULL, city TEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, phones TEXT DEFAULT NULL, address TEXT DEFAULT NULL, scheme VARCHAR(300) DEFAULT NULL, emails TEXT DEFAULT NULL, services TEXT DEFAULT NULL, rating TEXT DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, tested TEXT DEFAULT NULL, subscribe_product TEXT DEFAULT NULL, subscribe_request TEXT DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, hash VARCHAR(255) DEFAULT NULL, subscribe_review TEXT DEFAULT NULL, photos TEXT DEFAULT NULL, coordinates VARCHAR(255) DEFAULT NULL, pars_company TEXT DEFAULT NULL, coordinates_search VARCHAR(255) DEFAULT NULL, dizlike TEXT DEFAULT NULL, liket TEXT DEFAULT NULL, schedule TEXT DEFAULT NULL, sp1 TEXT DEFAULT NULL, sp2 TEXT DEFAULT NULL, sp3 TEXT DEFAULT NULL, sp4 TEXT DEFAULT NULL, sp5 TEXT DEFAULT NULL, sp6 TEXT DEFAULT NULL, sp7 TEXT DEFAULT NULL, sp8 TEXT DEFAULT NULL, sp9 TEXT DEFAULT NULL, sp10 TEXT DEFAULT NULL, sp11 TEXT DEFAULT NULL, sp12 TEXT DEFAULT NULL, subscribe_product_insert TEXT DEFAULT NULL, subscribe_request_insert TEXT DEFAULT NULL, subscribe_review_insert TEXT DEFAULT NULL, main_office TEXT DEFAULT NULL, branch TEXT DEFAULT NULL, phones_new TEXT DEFAULT NULL, phones_edited TEXT DEFAULT NULL, schedule_new TEXT DEFAULT NULL, schedule_edited TEXT DEFAULT NULL, address_legal TEXT DEFAULT NULL, bank_details TEXT DEFAULT NULL, credit_cards TEXT DEFAULT NULL, date_reminders TEXT DEFAULT NULL, info TEXT DEFAULT NULL, save_price TEXT DEFAULT NULL, under_order VARCHAR(255) DEFAULT NULL)');
        $this->addSql('ALTER INDEX part.idx_886d081e4ce34bec RENAME TO idx_1ae1f44ce34bec');
        $this->addSql('ALTER INDEX part.idx_886d081ee78c9c0a RENAME TO idx_1ae1f4e78c9c0a');
        $this->addSql('ALTER INDEX part.idx_a1a3eeac49fed7ed RENAME TO idx_769a7e4549fed7ed');
        $this->addSql('ALTER INDEX part.idx_a1a3eeac4ce34bec RENAME TO idx_769a7e454ce34bec');
        $this->addSql('ALTER INDEX part.idx_f715c7348bac62af RENAME TO idx_33855b0c8bac62af');
        $this->addSql('ALTER INDEX part.idx_f715c7347975b7e7 RENAME TO idx_33855b0c7975b7e7');
        $this->addSql('ALTER INDEX part.idx_f715c734979b1ad6 RENAME TO idx_33855b0c979b1ad6');
        $this->addSql('ALTER INDEX part.idx_f715c73444f5d008 RENAME TO idx_33855b0c44f5d008');
        $this->addSql('ALTER INDEX part.idx_945517c42e4bdf84 RENAME TO idx_d4026b4b2e4bdf84');
        $this->addSql('ALTER INDEX part.idx_945517c44ce34bec RENAME TO idx_d4026b4b4ce34bec');
        $this->addSql('ALTER INDEX part.idx_8498fb5e44f5d008 RENAME TO idx_ac5ed35c44f5d008');
        $this->addSql('ALTER INDEX part.idx_8f2bea067975b7e7 RENAME TO idx_f26c23cb7975b7e7');
        $this->addSql('ALTER INDEX part.idx_8f2bea062e4bdf84 RENAME TO idx_f26c23cb2e4bdf84');
        $this->addSql('ALTER TABLE users DROP avatar');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f57975b7e7 RENAME TO idx_1b38c9087975b7e7');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f561778466 RENAME TO idx_1b38c90861778466');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f5cd28d0b3 RENAME TO idx_1b38c908cd28d0b3');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f5979b1ad6 RENAME TO idx_1b38c908979b1ad6');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f58bac62af RENAME TO idx_1b38c9088bac62af');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f544f5d008 RENAME TO idx_1b38c90844f5d008');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f5887793b6 RENAME TO idx_1b38c908887793b6');
        $this->addSql('ALTER INDEX tyre.idx_3aca28f5c8dafa57 RENAME TO idx_1b38c908c8dafa57');
        $this->addSql('ALTER INDEX tyre.idx_5bc22c3744f5d008 RENAME TO idx_98ef507744f5d008');
    }
}
