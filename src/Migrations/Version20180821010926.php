<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180821010926 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE user_company1');
        $this->addSql('ALTER TABLE users ADD avatar VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE user_company1 (id TEXT DEFAULT NULL, display TEXT DEFAULT NULL, closed TEXT DEFAULT NULL, previev TEXT DEFAULT NULL, date TEXT DEFAULT NULL, usert TEXT DEFAULT NULL, name TEXT DEFAULT NULL, text TEXT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, type TEXT DEFAULT NULL, in_index TEXT DEFAULT NULL, imgs TEXT DEFAULT NULL, region TEXT DEFAULT NULL, city TEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, phones TEXT DEFAULT NULL, address TEXT DEFAULT NULL, scheme VARCHAR(300) DEFAULT NULL, emails TEXT DEFAULT NULL, services TEXT DEFAULT NULL, rating TEXT DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, tested TEXT DEFAULT NULL, subscribe_product TEXT DEFAULT NULL, subscribe_request TEXT DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, hash VARCHAR(255) DEFAULT NULL, subscribe_review TEXT DEFAULT NULL, photos TEXT DEFAULT NULL, coordinates VARCHAR(255) DEFAULT NULL, pars_company TEXT DEFAULT NULL, coordinates_search VARCHAR(255) DEFAULT NULL, dizlike TEXT DEFAULT NULL, liket TEXT DEFAULT NULL, schedule TEXT DEFAULT NULL, sp1 TEXT DEFAULT NULL, sp2 TEXT DEFAULT NULL, sp3 TEXT DEFAULT NULL, sp4 TEXT DEFAULT NULL, sp5 TEXT DEFAULT NULL, sp6 TEXT DEFAULT NULL, sp7 TEXT DEFAULT NULL, sp8 TEXT DEFAULT NULL, sp9 TEXT DEFAULT NULL, sp10 TEXT DEFAULT NULL, sp11 TEXT DEFAULT NULL, sp12 TEXT DEFAULT NULL, subscribe_product_insert TEXT DEFAULT NULL, subscribe_request_insert TEXT DEFAULT NULL, subscribe_review_insert TEXT DEFAULT NULL, main_office TEXT DEFAULT NULL, branch TEXT DEFAULT NULL, phones_new TEXT DEFAULT NULL, phones_edited TEXT DEFAULT NULL, schedule_new TEXT DEFAULT NULL, schedule_edited TEXT DEFAULT NULL, address_legal TEXT DEFAULT NULL, bank_details TEXT DEFAULT NULL, credit_cards TEXT DEFAULT NULL, date_reminders TEXT DEFAULT NULL, info TEXT DEFAULT NULL, save_price TEXT DEFAULT NULL, under_order VARCHAR(255) DEFAULT NULL)');
        $this->addSql('ALTER TABLE users DROP avatar');
    }
}
