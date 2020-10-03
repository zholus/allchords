<?php

declare(strict_types=1);

namespace App\Modules\Comments\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201002211443 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $commentsSql = "
            CREATE TABLE comments_authors 
            (
                id CHAR(36) NOT NULL, 
                username VARCHAR(255) NOT NULL, 
                UNIQUE INDEX UNIQ_5CB5428FF85E0677 (username), 
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB
        ";
        $this->addSql($commentsSql);
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comments_authors');
    }
}
