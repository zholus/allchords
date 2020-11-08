<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201108132301 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accounts_roles (id CHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_132F5FC05E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accounts_users_roles (user_id CHAR(36) NOT NULL, role_id CHAR(36) NOT NULL, INDEX IDX_BFE8DC38A76ED395 (user_id), INDEX IDX_BFE8DC38D60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accounts_users_roles ADD CONSTRAINT FK_BFE8DC38A76ED395 FOREIGN KEY (user_id) REFERENCES accounts_users (id)');
        $this->addSql('ALTER TABLE accounts_users_roles ADD CONSTRAINT FK_BFE8DC38D60322AC FOREIGN KEY (role_id) REFERENCES accounts_roles (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounts_users_roles DROP FOREIGN KEY FK_BFE8DC38D60322AC');
        $this->addSql('DROP TABLE accounts_roles');
        $this->addSql('DROP TABLE accounts_users_roles');
    }
}
