<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\Symfony\Middlewares;

use App\Web\ADR\Domain\Accounts\Service\AuthService;
use App\Web\ADR\Domain\Accounts\UserUnauthorizedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Zholus\SymfonyMiddleware\MiddlewareInterface;

final class AuthMiddleware implements MiddlewareInterface
{
    private AuthService $authService;
    private RouterInterface $router;

    public function __construct(AuthService $authService, RouterInterface $router)
    {
        $this->authService = $authService;
        $this->router = $router;
    }

    public function handle(Request $request): ?Response
    {
        try {
            $this->authService->getUser();

            return null;
        } catch (UserUnauthorizedException $exception) {
            return new RedirectResponse(
                $this->router->generate('sign_in_page')
            );
        }
    }
}
