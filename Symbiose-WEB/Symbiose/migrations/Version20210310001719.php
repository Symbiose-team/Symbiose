<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310001719 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD registered_at DATETIME  NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD account_must_be_verified_before DATETIME  NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD registration_token VARCHAR(255) DEFAULT NULL, ADD is_verified TINYINT(1)  NULL, ADD account_verified_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD forgot_password_token VARCHAR(255) DEFAULT NULL, ADD forgot_password_token_requested_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD forgot_password_token_must_be_verified_before DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD forgot_password_token_verified_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP registered_at, DROP account_must_be_verified_before, DROP registration_token, DROP is_verified, DROP account_verified_at, DROP forgot_password_token, DROP forgot_password_token_requested_at, DROP forgot_password_token_must_be_verified_before, DROP forgot_password_token_verified_at');
    }
}
