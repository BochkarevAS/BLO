<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180809014917 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE admin.company_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE admin.news_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE admin.news_categories_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE client.news_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE client.news (id INT NOT NULL, name VARCHAR(255) NOT NULL, picture JSON NOT NULL, slag VARCHAR(255) NOT NULL, display INT NOT NULL, massage VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE admin.company');
        $this->addSql('DROP TABLE admin.news_categories');
        $this->addSql('DROP TABLE admin.news');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA admin');
        $this->addSql('DROP SEQUENCE client.news_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE admin.company_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE admin.news_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE admin.news_categories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE admin.company (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE admin.news_categories (id INT NOT NULL, name VARCHAR(255) NOT NULL, rating INT NOT NULL, display INT NOT NULL, display_on_main INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE admin.news (id INT NOT NULL, company_id INT NOT NULL, img VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, url VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type_news VARCHAR(255) NOT NULL, display INT NOT NULL, display_on_main INT NOT NULL, uid INT NOT NULL, massage VARCHAR(255) DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_f978d2cf979b1ad6 ON admin.news (company_id)');
        $this->addSql('ALTER TABLE admin.news ADD CONSTRAINT fk_f978d2cf979b1ad6 FOREIGN KEY (company_id) REFERENCES client.company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE client.news');
    }
}
