<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325230838 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name TINYTEXT NOT NULL, supplier TINYTEXT NOT NULL, num_participants INT NOT NULL, num_remaining INT NOT NULL, type TINYTEXT NOT NULL, date DATETIME NOT NULL, state TINYINT(1) NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE special_event ADD state TINYINT(1) NOT NULL, ADD image_size INT NOT NULL, ADD updated_at DATETIME NOT NULL, CHANGE date date DATETIME NOT NULL, CHANGE picture image_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE event');
        $this->addSql('ALTER TABLE special_event DROP state, DROP image_size, DROP updated_at, CHANGE date date DATE NOT NULL, CHANGE image_name picture VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
