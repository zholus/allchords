<?php
declare(strict_types=1);

namespace App\Web\ADR\Action\Accounts;

use App\Web\ADR\Action\Action;
use App\Web\ADR\Domain\Accounts\Service\UsersService;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SignInAction extends Action
{
    private UsersService $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function __invoke(Request $request): Response
    {
        $email = $request->get('email');
        $password = $request->get('password');

        try {
            Assert::lazy()
                ->that($email, 'email')->email()
                ->that($password, 'password')->notEmpty()
                ->verifyNow();

            $this->usersService->signInUser($email, $password);
        } catch (\Throwable $exception) {
            $this->addFlash('errors', $this->errorMessage($exception));
            return $this->redirectToRoute('sign_in_page');
        }

        return $this->redirectToRoute('home_page');
    }
}
