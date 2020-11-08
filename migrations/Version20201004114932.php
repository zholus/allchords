<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201004114932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $songsCommentsSql = "
            CREATE TABLE comments_songs_comments 
            (
                id CHAR(36) NOT NULL, 
                author_id CHAR(36) DEFAULT NULL, 
                song_id CHAR(36) DEFAULT NULL, 
                text LONGTEXT NOT NULL, 
                created_at DATETIME NOT NULL COMMENT '(DC2Type\:datetime_immutable)', 
                INDEX IDX_D247E9DFF675F31B (author_id), 
                INDEX IDX_D247E9DFA0BDB2F3 (song_id), 
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB
        ";
        $this->addSql($songsCommentsSql);
        $this->addSql('ALTER TABLE comments_songs_comments ADD CONSTRAINT FK_D247E9DFF675F31B FOREIGN KEY (author_id) REFERENCES comments_authors (id)');
        $this->addSql('ALTER TABLE comments_songs_comments ADD CONSTRAINT FK_D247E9DFA0BDB2F3 FOREIGN KEY (song_id) REFERENCES comments_songs (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comments_songs_comments');
    }
}
