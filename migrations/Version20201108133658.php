<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201108133658 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $permissionsSql = "
            CREATE TABLE accounts_permissions 
            (
                id CHAR(36) NOT NULL, 
                name VARCHAR(255) NOT NULL, 
                UNIQUE INDEX UNIQ_name (name), 
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB
        ";

        $rolePermissionSql = "
            CREATE TABLE accounts_roles_permissions 
            (
                role_id CHAR(36) NOT NULL, 
                permission_id VARCHAR(255) NOT NULL, 
                PRIMARY KEY(role_id, permission_id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB
        ";
        $this->addSql($permissionsSql);
        $this->addSql($rolePermissionSql);
        $this->addSql('ALTER TABLE accounts_roles_permissions ADD CONSTRAINT FK_role FOREIGN KEY (role_id) REFERENCES accounts_roles (id)');
        $this->addSql('ALTER TABLE accounts_roles_permissions ADD CONSTRAINT FK_permission FOREIGN KEY (permission_id) REFERENCES accounts_permissions (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE accounts_roles_permissions');
        $this->addSql('DROP TABLE accounts_permissions');
    }
}
