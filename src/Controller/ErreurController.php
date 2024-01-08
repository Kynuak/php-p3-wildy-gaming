<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ErreurController extends AbstractController 
{
   #[Route('page_404', name: 'page404')]
   public function index(): Response
   {
      return $this->render('page_404.html.twig');
   }
}