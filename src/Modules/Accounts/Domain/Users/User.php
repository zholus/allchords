<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\Users;

use App\Common\Domain\EventDispatcher;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class User
{
    private UserId $id;
    private string $username;
    private string $email;
    private string $password;
    private DateTimeImmutable $createdAt;
    private ?string $accessToken;
    private ?string $refreshToken;
    private ?DateTimeImmutable $accessTokenExpiryAt;
    private Collection $roles;

    public function __construct(
        UserId $id,
        string $username,
        string $email,
        string $password,
        DateTimeImmutable $createdAt,
        ?string $accessToken,
        ?string $refreshToken,
        ?DateTimeImmutable $accessTokenExpiryAt,
        Collection $roles
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
        $this->accessToken = $accessToken;
        $this->accessTokenExpiryAt = $accessTokenExpiryAt;
        $this->refreshToken = $refreshToken;
        $this->roles = $roles;
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
            null,
            new ArrayCollection()
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
        $this->regenerateToken($accessTokenGenerator);
    }

    public function regenerateToken(AccessTokenGenerator $accessTokenGenerator): void
    {
        $expiryAt = (new \DateTimeImmutable())->add(new \DateInterval('PT3H'));

        $this->accessToken = $accessTokenGenerator->generate();
        $this->refreshToken = $accessTokenGenerator->generate();
        $this->accessTokenExpiryAt = $expiryAt;
    }

    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
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
