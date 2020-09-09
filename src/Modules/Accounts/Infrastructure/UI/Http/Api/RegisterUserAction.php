<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\UI\Http\Api;

use App\Modules\Accounts\Application\Users\RegisterUser\RegisterUserCommand;
use DomainException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class RegisterUserAction
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
            $this->bus->dispatch(new RegisterUserCommand(
                $username,
                $email,
                $password
            ));
        } catch (DomainException $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], 400);
        } catch (\Throwable $exception) {
            return new JsonResponse([
                'message' => 'unexpected server error: ' . $exception->getMessage()
            ], 500);
        }

        return new JsonResponse([
            'message' => 'success'
        ]);
    }
}
