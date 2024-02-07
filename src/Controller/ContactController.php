<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contactez-nous', name: 'app_contactez-nous')]
    public function index(): Response
    {
        $form = $this->createForm(ContactType::class);
        return $this->render('contactez-nous.html.twig', ['form' => $form]);
    }
}
