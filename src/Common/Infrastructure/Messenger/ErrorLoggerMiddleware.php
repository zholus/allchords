<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Messenger;

use DomainException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

final class ErrorLoggerMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        try {
            return $stack->next()->handle($envelope, $stack);
        } catch (\Throwable $exception) {
            if ($exception instanceof HandlerFailedException) {
                $rootException = $exception->getPrevious();
            }

            $exception = $rootException ?? $exception;

            if (!$exception instanceof DomainException) {
                $this->logger->error($exception->getMessage(), [
                    'exception' => $exception
                ]);
            }

            throw $exception;
        }
    }
}
