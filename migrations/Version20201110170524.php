<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110170524 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE songs_reviews_artists (id CHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_450A539E2B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE songs_reviews_creators (id CHAR(36) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_229CA3F0F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE songs_reviews_genres (id CHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_73D7E8E92B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE songs_reviews_reviews (id CHAR(36) NOT NULL, artist_id CHAR(36) DEFAULT NULL, genre_id CHAR(36) DEFAULT NULL, creator_id CHAR(36) DEFAULT NULL, title VARCHAR(255) NOT NULL, chords LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_44A9388FB7970CF8 (artist_id), INDEX IDX_44A9388F4296D31F (genre_id), INDEX IDX_44A9388F61220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE songs_reviews_reviews ADD CONSTRAINT FK_44A9388FB7970CF8 FOREIGN KEY (artist_id) REFERENCES songs_reviews_artists (id)');
        $this->addSql('ALTER TABLE songs_reviews_reviews ADD CONSTRAINT FK_44A9388F4296D31F FOREIGN KEY (genre_id) REFERENCES songs_reviews_genres (id)');
        $this->addSql('ALTER TABLE songs_reviews_reviews ADD CONSTRAINT FK_44A9388F61220EA6 FOREIGN KEY (creator_id) REFERENCES songs_reviews_creators (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE songs_reviews_reviews DROP FOREIGN KEY FK_44A9388FB7970CF8');
        $this->addSql('ALTER TABLE songs_reviews_reviews DROP FOREIGN KEY FK_44A9388F61220EA6');
        $this->addSql('ALTER TABLE songs_reviews_reviews DROP FOREIGN KEY FK_44A9388F4296D31F');
        $this->addSql('DROP TABLE songs_reviews_artists');
        $this->addSql('DROP TABLE songs_reviews_creators');
        $this->addSql('DROP TABLE songs_reviews_genres');
        $this->addSql('DROP TABLE songs_reviews_reviews');
    }
}
