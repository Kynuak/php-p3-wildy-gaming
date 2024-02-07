<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContacteController extends AbstractController
{
    #[Route('contactez-nous', name: 'contacte')]
    public function index(): Response
    {
        return $this->render('contactez-nous.html.twig');
    }
}
