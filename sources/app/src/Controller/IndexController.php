<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    #[Route('/{vueRouting}', name: 'index')]

    public function index(): Response
    {
        return $this->render('base.html.twig', []);
    }
}
