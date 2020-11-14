<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Modules\SongsReviews\Domain\Artists\Artist as ReviewsArtist;
use App\Modules\SongsReviews\Domain\Artists\ArtistId as ReviewsArtistId;
use App\Modules\SongsCatalog\Domain\Artists\Artist as CatalogArtist;
use App\Modules\SongsCatalog\Domain\Artists\ArtistId as CatalogArtistId;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class ArtistFixtures extends AbstractFixture
{
    public const SONG_REVIEWS_ARTIST_1 = 'SONG_REVIEWS_ARTIST_1';
    public const SONG_CATALOG_ARTIST_1 = 'SONG_CATALOG_ARTIST_1';
    public const SONG_CATALOG_ARTIST_2 = 'SONG_CATALOG_ARTIST_2';
    public const SONG_REVIEWS_ARTIST_2 = 'SONG_REVIEWS_ARTIST_2';
    public const SONG_CATALOG_ARTIST_3 = 'SONG_CATALOG_ARTIST_3';
    public const SONG_REVIEWS_ARTIST_3 = 'SONG_REVIEWS_ARTIST_3';

    public const ARTISTS = [
        'AC/DC' => [
            'catalog' => self::SONG_CATALOG_ARTIST_1,
            'reviews' => self::SONG_REVIEWS_ARTIST_1
        ],
        'Kino' => [
            'catalog' => self::SONG_CATALOG_ARTIST_2,
            'reviews' => self::SONG_REVIEWS_ARTIST_2
        ],
        'Sektor gaza' => [
            'catalog' => self::SONG_CATALOG_ARTIST_3,
            'reviews' => self::SONG_REVIEWS_ARTIST_3
        ],
    ];
    public function load(ObjectManager $manager)
    {
        $this->songsCatalog($manager);
        $this->songsReviews($manager);

        $manager->flush();
    }

    private function songsCatalog(ObjectManager $manager)
    {
        foreach (self::ARTISTS as $artistTitle => $data) {
            $artist = new CatalogArtist(
                new CatalogArtistId($this->getUuid($artistTitle)),
                $artistTitle
            );

            $manager->persist($artist);
            $this->addReference($data['catalog'], $artist);
        }
    }

    private function songsReviews(ObjectManager $manager)
    {
        foreach (self::ARTISTS as $artistTitle => $data) {
            $artist = new ReviewsArtist(
                new ReviewsArtistId($this->getUuid($artistTitle)),
                $artistTitle
            );

            $manager->persist($artist);
            $this->addReference($data['reviews'], $artist);
        }
    }
}
