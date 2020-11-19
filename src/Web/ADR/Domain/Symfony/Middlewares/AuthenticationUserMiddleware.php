<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\Symfony\Middlewares;

use App\Web\ADR\Domain\Accounts\Service\AuthService;
use App\Web\ADR\Domain\Accounts\Service\UsersService;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Throwable;
use Zholus\SymfonyMiddleware\GlobalMiddlewareInterface;

final class AuthenticationUserMiddleware implements GlobalMiddlewareInterface
{
    private UsersService $usersService;
    private AuthService $authService;
    private RouterInterface $router;
    private SessionInterface $session;
    private LoggerInterface $logger;

    public function __construct(
        AuthService $authService,
        UsersService $usersService,
        RouterInterface $router,
        SessionInterface $session,
        LoggerInterface $logger
    ) {
        $this->usersService = $usersService;
        $this->authService = $authService;
        $this->router = $router;
        $this->session = $session;
        $this->logger = $logger;
    }

    public function handle(Request $request): ?Response
    {
        if (!$this->authService->isAuthenticated()) {
            return null;
        }

        try {
            $user = $this->authService->getUser();

            if ($user->getExpiryAt() <= new DateTimeImmutable()) {
                $this->usersService->generateNewToken($user->getRefreshToken());
                $token = $this->usersService->getTokenByEmail($user->getEmail());
            } else {
                $token = $user->getToken();
            }


            $this->usersService->signInUserByToken($token);
        } catch (Throwable $exception) {
            $this->logger->error('Error during authenticate user with token', [
                'exception' => $exception
            ]);

            $this->authService->logout();
            $this->session->getFlashBag()->add('errors', 'Error during authenticate user with token');
            return new RedirectResponse(
                $this->router->generate('sign_in_page')
            );
        }

        return null;
    }
}
