<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330142722 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Calendar (id INT AUTO_INCREMENT NOT NULL, field_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, description LONGTEXT NOT NULL, all_day TINYINT(1) NOT NULL, background_color VARCHAR(7) NOT NULL, INDEX IDX_97DFC310443707B0 (field_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Field (id INT AUTO_INCREMENT NOT NULL, serial_number INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, space VARCHAR(255) NOT NULL, provider VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, status TINYINT(1) NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE availability (id INT NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Calendar ADD CONSTRAINT FK_97DFC310443707B0 FOREIGN KEY (field_id) REFERENCES Field (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Calendar DROP FOREIGN KEY FK_97DFC310443707B0');
        $this->addSql('DROP TABLE Calendar');
        $this->addSql('DROP TABLE Field');
        $this->addSql('DROP TABLE availability');
    }
}
