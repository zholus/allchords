<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201114221222 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE songs_reviews_reviews_artists (review_id CHAR(36) NOT NULL, artist_id CHAR(36) NOT NULL, INDEX IDX_9E6CA38F3E2E969B (review_id), INDEX IDX_9E6CA38FB7970CF8 (artist_id), PRIMARY KEY(review_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE songs_reviews_reviews_genres (review_id CHAR(36) NOT NULL, genre_id CHAR(36) NOT NULL, INDEX IDX_AEEE2FC33E2E969B (review_id), INDEX IDX_AEEE2FC34296D31F (genre_id), PRIMARY KEY(review_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE songs_reviews_reviews_artists ADD CONSTRAINT FK_9E6CA38F3E2E969B FOREIGN KEY (review_id) REFERENCES songs_reviews_reviews (id)');
        $this->addSql('ALTER TABLE songs_reviews_reviews_artists ADD CONSTRAINT FK_9E6CA38FB7970CF8 FOREIGN KEY (artist_id) REFERENCES songs_reviews_artists (id)');
        $this->addSql('ALTER TABLE songs_reviews_reviews_genres ADD CONSTRAINT FK_AEEE2FC33E2E969B FOREIGN KEY (review_id) REFERENCES songs_reviews_reviews (id)');
        $this->addSql('ALTER TABLE songs_reviews_reviews_genres ADD CONSTRAINT FK_AEEE2FC34296D31F FOREIGN KEY (genre_id) REFERENCES songs_reviews_genres (id)');
        $this->addSql('ALTER TABLE songs_reviews_genres CHANGE id id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE songs_reviews_reviews DROP FOREIGN KEY FK_44A9388F4296D31F');
        $this->addSql('ALTER TABLE songs_reviews_reviews DROP FOREIGN KEY FK_44A9388FB7970CF8');
        $this->addSql('DROP INDEX IDX_44A9388F4296D31F ON songs_reviews_reviews');
        $this->addSql('DROP INDEX IDX_44A9388FB7970CF8 ON songs_reviews_reviews');
        $this->addSql('ALTER TABLE songs_reviews_reviews DROP artist_id, DROP genre_id, CHANGE id id CHAR(36) NOT NULL, CHANGE creator_id creator_id CHAR(36) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE songs_reviews_reviews_artists');
        $this->addSql('DROP TABLE songs_reviews_reviews_genres');
        $this->addSql('ALTER TABLE songs_reviews_reviews ADD artist_id CHAR(36) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD genre_id CHAR(36) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE id id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE creator_id creator_id CHAR(36) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE songs_reviews_reviews ADD CONSTRAINT FK_44A9388F4296D31F FOREIGN KEY (genre_id) REFERENCES songs_reviews_genres (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE songs_reviews_reviews ADD CONSTRAINT FK_44A9388FB7970CF8 FOREIGN KEY (artist_id) REFERENCES songs_reviews_artists (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_44A9388F4296D31F ON songs_reviews_reviews (genre_id)');
        $this->addSql('CREATE INDEX IDX_44A9388FB7970CF8 ON songs_reviews_reviews (artist_id)');
    }
}
