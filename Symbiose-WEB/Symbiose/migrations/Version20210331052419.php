<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331052419 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE join_notification DROP FOREIGN KEY FK_A6FC4993B4622EC2');
        $this->addSql('DROP INDEX IDX_A6FC4993B4622EC2 ON join_notification');
        $this->addSql('ALTER TABLE join_notification CHANGE liked_by_id joined_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE join_notification ADD CONSTRAINT FK_A6FC4993B520FE66 FOREIGN KEY (joined_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A6FC4993B520FE66 ON join_notification (joined_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE join_notification DROP FOREIGN KEY FK_A6FC4993B520FE66');
        $this->addSql('DROP INDEX IDX_A6FC4993B520FE66 ON join_notification');
        $this->addSql('ALTER TABLE join_notification CHANGE joined_by_id liked_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE join_notification ADD CONSTRAINT FK_A6FC4993B4622EC2 FOREIGN KEY (liked_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A6FC4993B4622EC2 ON join_notification (liked_by_id)');
    }
}
