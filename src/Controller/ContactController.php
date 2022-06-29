<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactController extends AbstractController
{
    #[Route('/nous-contacter', name: 'app_contact')]
    public function index(Request $request,TranslatorInterface $translator): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        $message = $translator->trans('Merci de nous avoir contacté. Notre équipe va vous répondre dans les meilleurs délais.');

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', $message);
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

