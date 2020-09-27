<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200913161428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $sql = "
            CREATE TABLE accounts_users 
            (
                id CHAR(36) NOT NULL, 
                email VARCHAR(255) NOT NULL, 
                password VARCHAR(255) NOT NULL,
                username VARCHAR(255) NOT NULL, 
                access_token VARCHAR(255) DEFAULT NULL, 
                access_token_expiry_at DATETIME DEFAULT NULL COMMENT '(DC2Type\:datetime_immutable)', 
                created_at DATETIME NOT NULL COMMENT '(DC2Type\:datetime_immutable)', 
                UNIQUE INDEX UNIQ_B192D4EEE7927C74 (email), 
                UNIQUE INDEX UNIQ_B192D4EEF85E0677 (username), 
                UNIQUE INDEX UNIQ_B192D4EEB6A2DD68 (access_token),
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB
        ";
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE accounts_users');
    }
}
