<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\Users;

use App\Common\Domain\EventDispatcher;
use DateTimeImmutable;

class User
{
    private UserId $id;
    private string $username;
    private string $email;
    private string $password;
    private DateTimeImmutable $createdAt;
    private ?string $accessToken;
    private ?DateTimeImmutable $accessTokenExpiryAt;

    public function __construct(
        UserId $id,
        string $username,
        string $email,
        string $password,
        DateTimeImmutable $createdAt,
        ?string $accessToken,
        ?DateTimeImmutable $accessTokenExpiryAt
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
        $this->accessToken = $accessToken;
        $this->accessTokenExpiryAt = $accessTokenExpiryAt;
    }

    public static function register(UserId $id, string $username, string $email, string $password): User
    {
        $user = new User(
            $id,
            $username,
            $email,
            $password,
            new DateTimeImmutable(),
            null,
            null,
        );

        EventDispatcher::instance()->publish(new UserCreated(
            $id,
            $username,
            $email
        ));

        return $user;
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function signIn(AccessTokenGenerator $accessTokenGenerator): void
    {
        $token = $accessTokenGenerator->generate();
        $expiryAt = (new \DateTimeImmutable())->add(new \DateInterval('PT3H'));

        $this->accessToken = $token;
        $this->accessTokenExpiryAt = $expiryAt;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function getAccessTokenExpiryAt(): ?DateTimeImmutable
    {
        return $this->accessTokenExpiryAt;
    }
}
