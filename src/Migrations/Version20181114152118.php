<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181114152118 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE out_building_possession');
        $this->addSql('ALTER TABLE own_out_building ADD possession_id INT NOT NULL, ADD out_building_id INT NOT NULL');
        $this->addSql('ALTER TABLE own_out_building ADD CONSTRAINT FK_AC465483A337924 FOREIGN KEY (possession_id) REFERENCES possession (id)');
        $this->addSql('ALTER TABLE own_out_building ADD CONSTRAINT FK_AC465483BDA64420 FOREIGN KEY (out_building_id) REFERENCES out_building (id)');
        $this->addSql('CREATE INDEX IDX_AC465483A337924 ON own_out_building (possession_id)');
        $this->addSql('CREATE INDEX IDX_AC465483BDA64420 ON own_out_building (out_building_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE out_building_possession (out_building_id INT NOT NULL, possession_id INT NOT NULL, INDEX IDX_3D1B7A25BDA64420 (out_building_id), INDEX IDX_3D1B7A25A337924 (possession_id), PRIMARY KEY(out_building_id, possession_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE out_building_possession ADD CONSTRAINT FK_3D1B7A25A337924 FOREIGN KEY (possession_id) REFERENCES possession (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE out_building_possession ADD CONSTRAINT FK_3D1B7A25BDA64420 FOREIGN KEY (out_building_id) REFERENCES out_building (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE own_out_building DROP FOREIGN KEY FK_AC465483A337924');
        $this->addSql('ALTER TABLE own_out_building DROP FOREIGN KEY FK_AC465483BDA64420');
        $this->addSql('DROP INDEX IDX_AC465483A337924 ON own_out_building');
        $this->addSql('DROP INDEX IDX_AC465483BDA64420 ON own_out_building');
        $this->addSql('ALTER TABLE own_out_building DROP possession_id, DROP out_building_id');
    }
}
