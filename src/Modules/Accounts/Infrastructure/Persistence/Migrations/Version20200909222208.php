<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200909222208 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("
            create table users
            (
                id varchar(36) not null,
                email varchar(255) not null,
                username varchar(255) not null,
                password varchar(255) not null,
                created_at datetime not null,
                constraint users_pk
                    primary key (id)
            );
            
            create unique index users_email_uindex
                on users (email);
            
            create unique index users_username_uindex
                on users (username);
        ");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("
            DROP TABLE IF EXISTS users
        ");
    }
}
