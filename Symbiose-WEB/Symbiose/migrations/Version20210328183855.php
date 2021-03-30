<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210328183855 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE field DROP INDEX IDX_9A346A5CA40A2C8, ADD UNIQUE INDEX UNIQ_9A346A5CA40A2C8 (calendar_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Field DROP INDEX UNIQ_9A346A5CA40A2C8, ADD INDEX IDX_9A346A5CA40A2C8 (calendar_id)');
    }
}
