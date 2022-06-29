<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcountController extends AbstractController
{
    #[Route('/compte', name: 'app_acount')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        return $this->render('acount/index.html.twig');
    }
}
