<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderCancelController extends AbstractController
{
    #[Route('commande/erreur/{stripeSessionId}', name: 'app_order_cancel')]
    public function index(EntityManagerInterface $manager,$stripeSessionId):Response
    {
        $order = $manager->getRepository(Order::class)->findOneBy(['stripeSessionId' => $stripeSessionId]);
        
        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }


        // Envoyer un email à notre utilisateur pour lui indiquer l'échec de paiement

        return $this->render('order_cancel/index.html.twig', [
            'order' => $order
        ]);
    }
}

