<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderValidateController extends AbstractController
{
    

    #[Route('/commande/merci/{stripeSessionId}', name: 'app_order_validate')]
    public function index(EntityManagerInterface $manager,SessionInterface $session, $stripeSessionId): Response
    {
        $order = $manager->getRepository(Order::class)->findOneBy(['stripeSessionId' => $stripeSessionId]);
        
        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }


        // if ($order->getState()) {
        //     // Vider la session "cart"
           

        //     // Modifier le statut isPaid de notre commande en mettant 1
        //     $order->setState(1);
        //     $this->entityManager->flush();
        
        
        if($order->getState()==0){
          
            $session->remove("cart");
            
            $order->setState(1);
            $manager->flush();
        }


        $mail = new Mail();
        $content = "Bonjour ".$order->getUser()->getFirstname()."<br/>Merci pour votre commande.<br><br/>Vous receverez bientôt votre colis.<br/> Vous puvez suivre statut de votre commende dans votre espace personnel." ;
        $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande sweetdate est bien validée.', $content);



        return $this->render('order_validate/index.html.twig',[
            'order'=>$order
        ]);
    }
}
