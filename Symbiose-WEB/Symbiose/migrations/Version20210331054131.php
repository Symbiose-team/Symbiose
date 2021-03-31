<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331054131 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE join_notification');
        $this->addSql('ALTER TABLE notification ADD game_id INT DEFAULT NULL, ADD joined_by_id INT DEFAULT NULL, ADD discr VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAB520FE66 FOREIGN KEY (joined_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CAE48FD905 ON notification (game_id)');
        $this->addSql('CREATE INDEX IDX_BF5476CAB520FE66 ON notification (joined_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE join_notification (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, joined_by_id INT DEFAULT NULL, seen TINYINT(1) NOT NULL, INDEX IDX_A6FC4993E48FD905 (game_id), INDEX IDX_A6FC4993B520FE66 (joined_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE join_notification ADD CONSTRAINT FK_A6FC4993B520FE66 FOREIGN KEY (joined_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE join_notification ADD CONSTRAINT FK_A6FC4993E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAE48FD905');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAB520FE66');
        $this->addSql('DROP INDEX IDX_BF5476CAE48FD905 ON notification');
        $this->addSql('DROP INDEX IDX_BF5476CAB520FE66 ON notification');
        $this->addSql('ALTER TABLE notification DROP game_id, DROP joined_by_id, DROP discr');
    }
}
