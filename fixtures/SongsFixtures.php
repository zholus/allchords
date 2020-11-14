<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Modules\SongsCatalog\Domain\Songs\Song as CatalogSong;
use App\Modules\SongsCatalog\Domain\Songs\SongId as CatalogSongId;
use App\Modules\Comments\Domain\Songs\Song as CommentSong;
use App\Modules\Comments\Domain\Songs\SongId as CommentSongId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SongsFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->songsCatalogSong($manager);
        $this->commentsSong($manager);

        $manager->flush();
    }

    private function songsCatalogSong(ObjectManager $manager)
    {
        $song = new CatalogSong(
            new CatalogSongId($this->getUuid(1)),
            $this->getReference(ArtistFixtures::SONG_CATALOG_ARTIST_1),
            $this->getReference(UsersFixtures::SONGS_CATALOG_CREATOR_1),
            $this->getReference(GenreFixtures::SONG_CATALOG_GENRE_1),
            'title1',
            'chords1',
            new \DateTimeImmutable()
        );

        $manager->persist($song);
    }

    private function commentsSong(ObjectManager $manager)
    {
        $song = new CommentSong(new CommentSongId($this->getUuid(1)), new ArrayCollection());

        $manager->persist($song);
    }

    public function getDependencies()
    {
        return [
            ArtistFixtures::class,
            GenreFixtures::class,
            UsersFixtures::class,
        ];
    }
}
