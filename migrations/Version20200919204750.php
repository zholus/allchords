<?php

declare(strict_types=1);

namespace App\Migrations;

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

        $artistsSql = "
            CREATE TABLE songs_catalog_artists
            (
                id CHAR(36) NOT NULL, 
                title VARCHAR(255) NOT NULL, 
                UNIQUE INDEX UNIQ_7977B7732B36786B (title),
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci`
            ENGINE = InnoDB
        ";
        $this->addSql($artistsSql);

        $songSql = "
            CREATE TABLE songs_catalog_songs 
            (
                id CHAR(36) NOT NULL, 
                artist_id CHAR(36) NOT NULL,
                genre_id CHAR(36) NOT NULL,
                creator_id CHAR(36) NOT NULL,
                title VARCHAR(255) NOT NULL, 
                chords LONGTEXT NOT NULL, 
                created_at DATETIME NOT NULL COMMENT '(DC2Type\:datetime_immutable)', 
                PRIMARY KEY(id),
                CONSTRAINT IDX_8C6801BCB7970CF8 FOREIGN KEY (artist_id) REFERENCES songs_catalog_artists (id),
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
        $this->addSql('ALTER TABLE songs_catalog_songs DROP FOREIGN KEY IDX_8C6801BC61220EA6');
        $this->addSql('ALTER TABLE songs_catalog_songs DROP FOREIGN KEY IDX_8C6801BC4296D31F');
        $this->addSql('ALTER TABLE songs_catalog_songs DROP FOREIGN KEY IDX_8C6801BCB7970CF8');
        $this->addSql('DROP TABLE songs_catalog_creators');
        $this->addSql('DROP TABLE songs_catalog_artists');
        $this->addSql('DROP TABLE songs_catalog_genres');
        $this->addSql('DROP TABLE songs_catalog_songs');
    }
}
