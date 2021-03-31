<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331051448 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE join_notification (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, liked_by_id INT DEFAULT NULL, seen TINYINT(1) NOT NULL, INDEX IDX_A6FC4993E48FD905 (game_id), INDEX IDX_A6FC4993B4622EC2 (liked_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE join_notification ADD CONSTRAINT FK_A6FC4993E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE join_notification ADD CONSTRAINT FK_A6FC4993B4622EC2 FOREIGN KEY (liked_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAB4622EC2');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAE48FD905');
        $this->addSql('DROP INDEX IDX_BF5476CAE48FD905 ON notification');
        $this->addSql('DROP INDEX IDX_BF5476CAB4622EC2 ON notification');
        $this->addSql('ALTER TABLE notification DROP game_id, DROP liked_by_id, DROP discr');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE join_notification');
        $this->addSql('ALTER TABLE notification ADD game_id INT DEFAULT NULL, ADD liked_by_id INT DEFAULT NULL, ADD discr VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAB4622EC2 FOREIGN KEY (liked_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CAE48FD905 ON notification (game_id)');
        $this->addSql('CREATE INDEX IDX_BF5476CAB4622EC2 ON notification (liked_by_id)');
    }
}
