<?php
declare(strict_types=1);

namespace App\Web\ADR\Action\Accounts;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class RegisterPageAction extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('accounts/register.twig');
    }
}
