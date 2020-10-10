<?php
declare(strict_types=1);

namespace App\Web\ADR\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomePageAction extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('home_page.twig');
    }
}
