<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181114143830 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE out_building (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE out_building_possession (out_building_id INT NOT NULL, possession_id INT NOT NULL, INDEX IDX_3D1B7A25BDA64420 (out_building_id), INDEX IDX_3D1B7A25A337924 (possession_id), PRIMARY KEY(out_building_id, possession_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE own_out_building (id INT AUTO_INCREMENT NOT NULL, surface INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE possession (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, seller_id INT NOT NULL, surface INT DEFAULT NULL, room_number INT DEFAULT NULL, floor_number INT DEFAULT NULL, city VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, street VARCHAR(255) DEFAULT NULL, minimum_price INT DEFAULT NULL, selling_price INT NOT NULL, description VARCHAR(255) DEFAULT NULL, validation_state VARCHAR(255) DEFAULT NULL, INDEX IDX_F9EE3F42C54C8C93 (type_id), INDEX IDX_F9EE3F428DE820D9 (seller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE possession_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE out_building_possession ADD CONSTRAINT FK_3D1B7A25BDA64420 FOREIGN KEY (out_building_id) REFERENCES out_building (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE out_building_possession ADD CONSTRAINT FK_3D1B7A25A337924 FOREIGN KEY (possession_id) REFERENCES possession (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE possession ADD CONSTRAINT FK_F9EE3F42C54C8C93 FOREIGN KEY (type_id) REFERENCES possession_type (id)');
        $this->addSql('ALTER TABLE possession ADD CONSTRAINT FK_F9EE3F428DE820D9 FOREIGN KEY (seller_id) REFERENCES client (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE out_building_possession DROP FOREIGN KEY FK_3D1B7A25BDA64420');
        $this->addSql('ALTER TABLE out_building_possession DROP FOREIGN KEY FK_3D1B7A25A337924');
        $this->addSql('ALTER TABLE possession DROP FOREIGN KEY FK_F9EE3F42C54C8C93');
        $this->addSql('DROP TABLE out_building');
        $this->addSql('DROP TABLE out_building_possession');
        $this->addSql('DROP TABLE own_out_building');
        $this->addSql('DROP TABLE possession');
        $this->addSql('DROP TABLE possession_type');
    }
}
