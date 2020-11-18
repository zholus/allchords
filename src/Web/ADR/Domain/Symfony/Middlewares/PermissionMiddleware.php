<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\Symfony\Middlewares;

use App\Web\ADR\Domain\Accounts\Service\AuthService;
use App\Web\ADR\Domain\PermissionsMap;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zholus\SymfonyMiddleware\MiddlewareInterface;

final class PermissionMiddleware implements MiddlewareInterface
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle(Request $request): ?Response
    {
        $controllerFqcn = $request->attributes->get('_controller');

        $requiredPermissionsForAction = PermissionsMap::MAP[$controllerFqcn] ?? null;

        if ($requiredPermissionsForAction === null) {
            return null;
        }

        $user = $this->authService->getUser();

        // todo: fetch permission
        dd($requiredPermissionsForAction);
    }
}
