<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Reviews\NewReview;

use App\Common\Application\Command\CommandHandler;
use App\Modules\SongsReviews\Domain\Artists\ArtistId;
use App\Modules\SongsReviews\Domain\Artists\ArtistNotFoundException;
use App\Modules\SongsReviews\Domain\Artists\ArtistRepository;
use App\Modules\SongsReviews\Domain\Creators\CreatorId;
use App\Modules\SongsReviews\Domain\Creators\CreatorNotFoundException;
use App\Modules\SongsReviews\Domain\Creators\CreatorRepository;
use App\Modules\SongsReviews\Domain\Genres\GenreId;
use App\Modules\SongsReviews\Domain\Genres\GenreNotFoundException;
use App\Modules\SongsReviews\Domain\Genres\GenreRepository;
use App\Modules\SongsReviews\Domain\Reviews\Review;
use App\Modules\SongsReviews\Domain\Reviews\ReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;

final class NewReviewHandler implements CommandHandler
{
    private ReviewRepository $reviews;
    private CreatorRepository $creators;
    private ArtistRepository $artists;
    private GenreRepository $genres;

    public function __construct(
        ReviewRepository $reviews,
        CreatorRepository $creators,
        ArtistRepository $artists,
        GenreRepository $genres
    ) {
        $this->reviews = $reviews;
        $this->creators = $creators;
        $this->artists = $artists;
        $this->genres = $genres;
    }

    public function __invoke(NewReviewCommand $command): void
    {
        $artistsIds = array_map(
            fn(string $artistId) => new ArtistId($artistId),
            $command->getArtistsIds()
        );
        $artists = $this->artists->getManyById($artistsIds);

        if (empty($artists) || count($artists) !== count($artistsIds)) {
            throw ArtistNotFoundException::withIds($artistsIds);
        }

        $creatorId = new CreatorId($command->getCreatorId());
        $creator = $this->creators->getById($creatorId);

        if ($creator === null) {
            throw CreatorNotFoundException::withId($creatorId);
        }

        $genresIds = array_map(
            fn(string $genreId) => new GenreId($genreId),
            $command->getGenresIds()
        );
        $genres = $this->genres->getManyById($genresIds);

        if (empty($genres) || count($genres) !== count($genresIds)) {
            throw GenreNotFoundException::withIds($genresIds);
        }

        $review = Review::new(
            $this->reviews->nextIdentity(),
            new ArrayCollection($artists),
            $creator,
            new ArrayCollection($genres),
            $command->getTitle(),
            $command->getChords()
        );

        $this->reviews->add($review);
    }
}
