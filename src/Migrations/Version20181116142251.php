<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181116142251 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE administrator (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_58DF0651A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agency_director (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, agency_id INT DEFAULT NULL, INDEX IDX_28AB20BA76ED395 (user_id), INDEX IDX_28AB20BCDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_possession (client_id INT NOT NULL, possession_id INT NOT NULL, INDEX IDX_69BA020319EB6921 (client_id), INDEX IDX_69BA0203A337924 (possession_id), PRIMARY KEY(client_id, possession_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE agency_director ADD CONSTRAINT FK_28AB20BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE agency_director ADD CONSTRAINT FK_28AB20BCDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE client_possession ADD CONSTRAINT FK_69BA020319EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_possession ADD CONSTRAINT FK_69BA0203A337924 FOREIGN KEY (possession_id) REFERENCES possession (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agency ADD picture_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE possession ADD picture_path VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE proposition ADD counter_proposition_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC353FC5B126E FOREIGN KEY (counter_proposition_id) REFERENCES proposition (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7CDC353FC5B126E ON proposition (counter_proposition_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE agency_director');
        $this->addSql('DROP TABLE client_possession');
        $this->addSql('ALTER TABLE agency DROP picture_path');
        $this->addSql('ALTER TABLE possession DROP picture_path');
        $this->addSql('ALTER TABLE proposition DROP FOREIGN KEY FK_C7CDC353FC5B126E');
        $this->addSql('DROP INDEX UNIQ_C7CDC353FC5B126E ON proposition');
        $this->addSql('ALTER TABLE proposition DROP counter_proposition_id');
    }
}
