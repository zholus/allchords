<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Persistence\Users;

use App\Modules\Accounts\Domain\Users\User;
use App\Modules\Accounts\Domain\Users\UserId;
use App\Modules\Accounts\Domain\Users\UserRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\Uuid;

final class DbUserRepository implements UserRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function nextIdentity(): UserId
    {
        return new UserId(Uuid::uuid4()->toString());
    }

    public function add(User $user): void
    {
        $sql = "
            INSERT INTO 
                `users`
                (`id`, `username`, `email`, `password`, `created_at`)
            VALUES
                (:id, :username, :email, :password, :created_at)
        ";

        $statement = $this->connection->prepare($sql);

        $statement->bindValue(':id', $user->getId()->toString());
        $statement->bindValue(':username', $user->getUsername());
        $statement->bindValue(':email', $user->getEmail());
        $statement->bindValue(':password', $user->getPassword());
        $statement->bindValue(':created_at', (new DateTimeImmutable())->format(\DateTimeInterface::RFC3339));

        $statement->execute();
    }

    public function existsWithUsername(string $username): bool
    {
        $sql = "
            SELECT
                1
            FROM
                `users`
            WHERE
                `username` = :username
        ";

        $statement = $this->connection->prepare($sql);

        $statement->bindValue(':username', $username);

        $statement->execute();

        return (int)$statement->fetchColumn() === 1;
    }

    public function existsWithEmail(string $email): bool
    {
        $sql = "
            SELECT
                1
            FROM
                `users`
            WHERE
                `email` = :email
        ";

        $statement = $this->connection->prepare($sql);

        $statement->bindValue(':email', $email);

        $statement->execute();

        return (int)$statement->fetchColumn() === 1;
    }
}
