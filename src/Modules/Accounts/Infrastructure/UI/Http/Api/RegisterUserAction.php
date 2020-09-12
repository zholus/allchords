<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\UI\Http\Api;

use App\Modules\Accounts\Application\Users\RegisterUser\RegisterUserCommand;
use Assert\Assert;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class RegisterUserAction extends Action
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $email = $request->get('email');
        $username = $request->get('username');
        $password = $request->get('password');

        try {
            Assert::lazy()
                ->that($email, 'email')->email()
                ->that($username, 'username')->notEmpty()
                ->that($password, 'password')->notEmpty()
                ->verifyNow();

            $this->bus->dispatch(new RegisterUserCommand(
                $username,
                $email,
                $password
            ));
        } catch (Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse([
            'message' => 'success'
        ]);
    }
}
