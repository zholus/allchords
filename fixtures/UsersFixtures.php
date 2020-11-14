<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use App\Modules\Accounts\Domain\Users\User as AccountUser;
use App\Modules\Accounts\Domain\Users\UserId as AccountUserId;
use App\Modules\SongsCatalog\Domain\Creators\Creator as CatalogCreator;
use App\Modules\SongsCatalog\Domain\Creators\CreatorId as CatalogCreatorId;
use App\Modules\SongsReviews\Domain\Creators\Creator as ReviewsCreator;
use App\Modules\SongsReviews\Domain\Creators\CreatorId as ReviewsCreatorId;
use App\Modules\Comments\Domain\Authors\Author as CommentAuthor;
use App\Modules\Comments\Domain\Authors\AuthorId as CommentAuthorId;

class UsersFixtures extends AbstractFixture
{
    public const ACCOUNTS_USER_1 = 'ACCOUNTS_USER_1';
    public const SONGS_CATALOG_CREATOR_1 = 'SONGS_CATALOG_CREATOR_1';
    public const SONGS_REVIEWS_CREATOR_1 = 'SONGS_REVIEWS_CREATOR_1';
    public const COMMENTS_AUTHOR_1 = 'COMMENTS_AUTHOR_1';

    public function load(ObjectManager $manager)
    {
        $this->accountsUsers($manager);
        $this->songsCatalogCreators($manager);
        $this->songsReviewsCreators($manager);
        $this->commentsAuthor($manager);
        $manager->flush();
    }

    private function accountsUsers(ObjectManager $manager)
    {
        $user = new AccountUser(
            new AccountUserId($this->getUuid(1)),
            'username1',
            'test1@gmail.com',
            password_hash('123123', PASSWORD_BCRYPT),
            new \DateTimeImmutable(),
            null,
            null,
            new ArrayCollection()
        );

        $manager->persist($user);
        $this->addReference(self::ACCOUNTS_USER_1, $user);
    }

    private function songsCatalogCreators(ObjectManager $manager)
    {
        $creator = new CatalogCreator(
            new CatalogCreatorId($this->getUuid(1)),
            'username1'
        );

        $manager->persist($creator);
        $this->addReference(self::SONGS_CATALOG_CREATOR_1, $creator);
    }

    private function songsReviewsCreators(ObjectManager $manager)
    {
        $creator = new ReviewsCreator(
            new ReviewsCreatorId($this->getUuid(1)),
            'username1'
        );

        $manager->persist($creator);
        $this->addReference(self::SONGS_REVIEWS_CREATOR_1, $creator);
    }

    private function commentsAuthor(ObjectManager $manager)
    {
        $author = new CommentAuthor(
            new CommentAuthorId($this->getUuid(1)),
            'username1'
        );

        $manager->persist($author);
        $this->addReference(self::COMMENTS_AUTHOR_1, $author);
    }
}
