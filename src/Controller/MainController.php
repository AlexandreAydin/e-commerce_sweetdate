<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/change-locale/{locale}', name: 'app_main')]
    public function index($locale, Request $request): Response
    {
        // On stocke la langue dans la session
    $request->getSession()->set('_locale', $locale);

    // On revient sur la page précédente
    return $this->redirect($request->headers->get('referer'));
    }
}
