<?php
declare(strict_types=1);

namespace App\Web\ADR\Action\Accounts;

use App\Web\ADR\Action\Action;
use App\Web\ADR\Domain\Accounts\Service\AuthService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LogoutAction extends Action
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(Request $request): Response
    {
        $this->authService->logout();

        return $this->redirectToRoute('home_page');
    }
}
