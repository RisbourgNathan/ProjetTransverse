<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181114140752 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE agency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, is_main_agency TINYINT(1) NOT NULL, agency_cost INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agent (id INT AUTO_INCREMENT NOT NULL, agency_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_268B9C9DCDEADB2A (agency_id), INDEX IDX_268B9C9DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, agent_id INT DEFAULT NULL, sponsor_id INT DEFAULT NULL, INDEX IDX_C7440455A76ED395 (user_id), INDEX IDX_C74404553414710B (agent_id), INDEX IDX_C744045512F7FB51 (sponsor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DCDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404553414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045512F7FB51 FOREIGN KEY (sponsor_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD zip_code VARCHAR(255) DEFAULT NULL, ADD street VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DCDEADB2A');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404553414710B');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045512F7FB51');
        $this->addSql('DROP TABLE agency');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE client');
        $this->addSql('ALTER TABLE user DROP firstname, DROP lastname, DROP city, DROP zip_code, DROP street, DROP phone');
    }
}
