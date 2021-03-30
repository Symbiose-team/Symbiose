<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210328185021 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar ADD field_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_97DFC310443707B0 FOREIGN KEY (field_id) REFERENCES Field (id)');
        $this->addSql('CREATE INDEX IDX_97DFC310443707B0 ON calendar (field_id)');
        $this->addSql('ALTER TABLE field DROP FOREIGN KEY FK_9A346A5CA40A2C8');
        $this->addSql('DROP INDEX UNIQ_9A346A5CA40A2C8 ON field');
        $this->addSql('ALTER TABLE field DROP calendar_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Calendar DROP FOREIGN KEY FK_97DFC310443707B0');
        $this->addSql('DROP INDEX IDX_97DFC310443707B0 ON Calendar');
        $this->addSql('ALTER TABLE Calendar DROP field_id');
        $this->addSql('ALTER TABLE Field ADD calendar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Field ADD CONSTRAINT FK_9A346A5CA40A2C8 FOREIGN KEY (calendar_id) REFERENCES calendar (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9A346A5CA40A2C8 ON Field (calendar_id)');
    }
}
