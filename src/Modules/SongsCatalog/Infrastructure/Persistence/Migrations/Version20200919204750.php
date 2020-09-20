<?php

declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200919204750 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE songs (id CHAR(36) NOT NULL, creator_id CHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, chords LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genres (id CHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A8EBE5162B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE authors (id CHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8E0C2A512B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE authors');
        $this->addSql('DROP TABLE genres');
        $this->addSql('DROP TABLE songs');
    }
}
