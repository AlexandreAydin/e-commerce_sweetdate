<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/commande', name: 'app_order')]
    public function index(SessionInterface $session,
    ProductRepository $productrepository): Response
    {
        $cart = $session->get('cart',[]);
        $cartComplete = [];
        
        foreach ($cart as $id=> $quantity){
            $product = $productrepository->find($id);
            $cartComplete[]=[
                'product'=>$product,
                'quantity'=>$quantity
            ];  
        }
        
        if (!$this->getUser()->getAdresses()->getValues())
         {
             return $this->redirectToRoute('app_account_adress_add');
         }

        $form = $this->createForm(OrderType::class, null,[
            'user'=>$this->getUser()
        ]);


        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cartComplete' => $cartComplete
           
            
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/commande/recapitulatif', name: 'app_order_recap', methods: ['POST', 'GET'])]
    public function add(SessionInterface $session,
    ProductRepository $productrepository,
    Request $request,
    EntityManagerInterface $manager): Response
    {
        
        if (!$this->getUser()->getAdresses()->getValues())
         {
             return $this->redirectToRoute('app_account_adress_add');
         }

        $form = $this->createForm(OrderType::class, null,[
            'user'=>$this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime();
            $carriers = $form->get('carriers')->getData();

            $delivery = $form->get('adresses')->getData();
            $delivery_content = $delivery->getFirstname().' '.$delivery->getLastname();
            $delivery_content .= '<br/>'.$delivery->getPhone();

            if ($delivery->getCompany()) {
                $delivery_content .= '<br/>'.$delivery->getCompany();
            }

            $delivery_content .= '<br/>'.$delivery->getAdress();
            $delivery_content .= '<br/>'.$delivery->getPostal().' '.$delivery->getCity();
            $delivery_content .= '<br/>'.$delivery->getCountry();

            // Enregistrer ma commande Order()
            $order = new Order();
            $reference = $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);           
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setState(0);
            

            $manager->persist($order);


             

             // Enregistrer mes produits OrderDetails()
          

            $cart = $session->get('cart',[]);

            foreach ($cart as $id => $quantity){
                $product = $productrepository->find($id);
                $cartComplete[]=[
                    'product'=>$product,
                    'quantity'=>$quantity
                ];  
                    $orderDetails = new OrderDetails(); 
                    $orderDetails->setMyOrder($order);
                    $orderDetails->setProduct($product->getName());                                   
                    $orderDetails->setQuantity($quantity);                                             
                    $orderDetails->setPrice($product->getPrice());                
                    $orderDetails->setTotal($product->getPrice() * $quantity);
                    
                    $manager->persist($orderDetails);

                    

                }                    

                
                $manager->flush();
            }

            return $this->render('order/add.html.twig', [

                'cartComplete' => $cartComplete,
                 'carrier' => $carriers,
                 'delivery' => $delivery_content,
                 'reference' => $order->getReference()
              
            ]);
            return $this->redirectToRoute('app_cart');
        }
        

       
}
    

