<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180824023051 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE client.company ALTER preview DROP NOT NULL');
        $this->addSql('ALTER TABLE client.company ALTER bank DROP NOT NULL');
        $this->addSql('ALTER TABLE client.company ALTER syte DROP NOT NULL');
        $this->addSql('ALTER TABLE client.company ALTER address DROP NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE client.company ALTER preview SET NOT NULL');
        $this->addSql('ALTER TABLE client.company ALTER bank SET NOT NULL');
        $this->addSql('ALTER TABLE client.company ALTER syte SET NOT NULL');
        $this->addSql('ALTER TABLE client.company ALTER address SET NOT NULL');
    }
}
