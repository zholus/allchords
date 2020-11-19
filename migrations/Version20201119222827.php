<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201119222827 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounts_users ADD refresh_token VARCHAR(255) DEFAULT NULL, CHANGE id id CHAR(36) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B192D4EEC74F2195 ON accounts_users (refresh_token)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_B192D4EEC74F2195 ON accounts_users');
        $this->addSql('ALTER TABLE accounts_users DROP refresh_token, CHANGE id id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
