<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180813231811 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE client.company (id INT NOT NULL, city_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, preview TEXT NOT NULL, bank TEXT NOT NULL, syte VARCHAR(255) NOT NULL, logotype VARCHAR(255) DEFAULT NULL, address TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7D78DC3C8BAC62AF ON client.company (city_id)');
        $this->addSql('CREATE INDEX IDX_7D78DC3CA76ED395 ON client.company (user_id)');
        $this->addSql('CREATE TABLE client.price (id INT NOT NULL, company_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A9DB600A979B1AD6 ON client.price (company_id)');
        $this->addSql('ALTER TABLE client.company ADD CONSTRAINT FK_7D78DC3C8BAC62AF FOREIGN KEY (city_id) REFERENCES region.city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client.company ADD CONSTRAINT FK_7D78DC3CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client.price ADD CONSTRAINT FK_A9DB600A979B1AD6 FOREIGN KEY (company_id) REFERENCES client.company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client.company_sections ADD CONSTRAINT FK_F4DAD63E979B1AD6 FOREIGN KEY (company_id) REFERENCES client.company (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client.email ADD CONSTRAINT FK_84813EA7979B1AD6 FOREIGN KEY (company_id) REFERENCES client.company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client.phone ADD CONSTRAINT FK_275CD50E979B1AD6 FOREIGN KEY (company_id) REFERENCES client.company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts.part ADD CONSTRAINT FK_33855B0C979B1AD6 FOREIGN KEY (company_id) REFERENCES client.company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tyres.tyre ADD CONSTRAINT FK_1B38C908979B1AD6 FOREIGN KEY (company_id) REFERENCES client.company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE client.company_sections DROP CONSTRAINT FK_F4DAD63E979B1AD6');
        $this->addSql('ALTER TABLE client.email DROP CONSTRAINT FK_84813EA7979B1AD6');
        $this->addSql('ALTER TABLE client.phone DROP CONSTRAINT FK_275CD50E979B1AD6');
        $this->addSql('ALTER TABLE client.price DROP CONSTRAINT FK_A9DB600A979B1AD6');
        $this->addSql('ALTER TABLE parts.part DROP CONSTRAINT FK_33855B0C979B1AD6');
        $this->addSql('ALTER TABLE tyres.tyre DROP CONSTRAINT FK_1B38C908979B1AD6');
        $this->addSql('DROP TABLE client.company');
        $this->addSql('DROP TABLE client.price');
    }
}
