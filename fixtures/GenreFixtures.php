<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Modules\SongsCatalog\Domain\Genres\Genre as CatalogGenre;
use App\Modules\SongsCatalog\Domain\Genres\GenreId as CatalogGenreId;
use App\Modules\SongsReviews\Domain\Genres\Genre as ReviewsGenre;
use App\Modules\SongsReviews\Domain\Genres\GenreId as ReviewsGenreId;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends AbstractFixture
{
    public const SONG_CATALOG_GENRE_1 = 'SONG_CATALOG_GENRE_1';
    public const SONG_REVIEWS_GENRE_1 = 'SONG_REVIEWS_GENRE_1';
    public const SONG_CATALOG_GENRE_2 = 'SONG_CATALOG_GENRE_2';
    public const SONG_REVIEWS_GENRE_2 = 'SONG_REVIEWS_GENRE_2';
    public const SONG_CATALOG_GENRE_3 = 'SONG_CATALOG_GENRE_3';
    public const SONG_REVIEWS_GENRE_3 = 'SONG_REVIEWS_GENRE_3';

    public const GENRES = [
        'Rock' => [
            'catalog' => self::SONG_CATALOG_GENRE_1,
            'reviews' => self::SONG_REVIEWS_GENRE_1,
        ],
        'Metal' => [
            'catalog' => self::SONG_CATALOG_GENRE_2,
            'reviews' => self::SONG_REVIEWS_GENRE_2,
        ],
        'Folk' => [
            'catalog' => self::SONG_CATALOG_GENRE_3,
            'reviews' => self::SONG_REVIEWS_GENRE_3,
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
        foreach (self::GENRES as $genreTitle => $data) {
            $genre = new CatalogGenre(
                new CatalogGenreId($this->getUuid($genreTitle)),
                $genreTitle
            );

            $manager->persist($genre);

            $this->addReference($data['catalog'], $genre);
        }
    }

    private function songsReviews(ObjectManager $manager)
    {
        foreach (self::GENRES as $genreTitle => $data) {
            $genre = new ReviewsGenre(
                new ReviewsGenreId($this->getUuid($genreTitle)),
                $genreTitle
            );

            $manager->persist($genre);

            $this->addReference($data['reviews'], $genre);
        }
    }
}
