<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210303221333 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE add_request DROP id_rq');
        $this->addSql('ALTER TABLE client DROP idclient');
        $this->addSql('ALTER TABLE friends_list DROP id_list');
        $this->addSql('ALTER TABLE msgchat DROP idmsgchat');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE add_request ADD id_rq INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD idclient INT NOT NULL');
        $this->addSql('ALTER TABLE friends_list ADD id_list INT NOT NULL');
        $this->addSql('ALTER TABLE msgchat ADD idmsgchat INT NOT NULL');
    }
}
