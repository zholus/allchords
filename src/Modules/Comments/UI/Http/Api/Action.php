<?php
declare(strict_types=1);

namespace App\Modules\Comments\UI\Http\Api;

use Assert\InvalidArgumentException;
use DomainException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class Action
{
    public function responseByException(\Throwable $exception): JsonResponse
    {
        try {
            throw $exception;
        } catch (DomainException $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            dd($exception);
            return new JsonResponse([
                'message' => 'Unexpected server error.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
