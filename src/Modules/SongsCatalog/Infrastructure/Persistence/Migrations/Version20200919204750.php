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
        $creatorsSql = '
           CREATE TABLE songs_catalog_creators
            (
                id         CHAR(36)     NOT NULL,
                username      VARCHAR(255) NOT NULL,
                PRIMARY KEY (id),
                UNIQUE INDEX UNIQ_FC1B40D1F85E0677 (username)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci`
            ENGINE = InnoDB
        ';

        $this->addSql($creatorsSql);

        $genreSql = "
            CREATE TABLE songs_catalog_genres 
            (
                id CHAR(36) NOT NULL, 
                title VARCHAR(255) NOT NULL, 
                UNIQUE INDEX UNIQ_DD7D4CD2B36786B (title), 
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB
        ";
        $this->addSql($genreSql);

        $authorsSql = "
            CREATE TABLE songs_catalog_authors 
            (
                id CHAR(36) NOT NULL, 
                title VARCHAR(255) NOT NULL, 
                UNIQUE INDEX UNIQ_9FA81D3C2B36786B (title),
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci`
            ENGINE = InnoDB
        ";
        $this->addSql($authorsSql);

        $songSql = "
            CREATE TABLE songs_catalog_songs 
            (
                id CHAR(36) NOT NULL, 
                author_id CHAR(36) NOT NULL,
                genre_id CHAR(36) NOT NULL,
                creator_id CHAR(36) NOT NULL,
                title VARCHAR(255) NOT NULL, 
                chords LONGTEXT NOT NULL, 
                created_at DATETIME NOT NULL COMMENT '(DC2Type\:datetime_immutable)', 
                PRIMARY KEY(id),
                CONSTRAINT IDX_8C6801BCF675F31B FOREIGN KEY (author_id) REFERENCES songs_catalog_authors (id),
                CONSTRAINT IDX_8C6801BC4296D31F FOREIGN KEY (genre_id) REFERENCES songs_catalog_genres (id),
                CONSTRAINT IDX_8C6801BC61220EA6 FOREIGN KEY (creator_id) REFERENCES songs_catalog_creators (id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
                ENGINE = InnoDB
        ";
        $this->addSql($songSql);
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE songs_catalog_authors');
        $this->addSql('DROP TABLE songs_catalog_genres');
        $this->addSql('DROP TABLE songs_catalog_songs');
    }
}
