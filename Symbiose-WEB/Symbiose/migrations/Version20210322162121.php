<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210322162121 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE special_event (id INT AUTO_INCREMENT NOT NULL, name TINYTEXT NOT NULL, supplier TINYTEXT NOT NULL, num_participants INT NOT NULL, num_remaining INT NOT NULL, type TINYTEXT NOT NULL, date DATE NOT NULL, picture VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD date DATE NOT NULL, ADD picture VARCHAR(255) NOT NULL, CHANGE type type TINYTEXT NOT NULL, CHANGE num_place_restant num_remaining INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE special_event');
        $this->addSql('ALTER TABLE event DROP date, DROP picture, CHANGE type type INT NOT NULL, CHANGE num_remaining num_place_restant INT NOT NULL');
    }
}
