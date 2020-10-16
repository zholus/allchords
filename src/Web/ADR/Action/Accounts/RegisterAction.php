<?php
declare(strict_types=1);

namespace App\Web\ADR\Action\Accounts;

use App\Web\ADR\Action\Action;
use App\Web\ADR\Domain\Accounts\Service\UsersService;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RegisterAction extends Action
{
    private UsersService $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function __invoke(Request $request): Response
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        try {
            Assert::lazy()
                ->that($email, 'email')->email()
                ->that($username, 'username')->notEmpty()
                ->that($password, 'password')->notEmpty()
                ->verifyNow();

            $this->usersService->registerUser($username, $email, $password);
        } catch (\Throwable $exception) {
            $this->addFlash('errors', $this->errorMessage($exception));

            return $this->redirectToRoute('register_page');
        }

        $this->addFlash('success', 'You can sign in now!');

        return $this->redirectToRoute('sign_in_page');
    }
}
