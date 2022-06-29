<?php

namespace App\Controller;


use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(
    SessionInterface $session,
    ProductRepository $productrepository,
    EntityManagerInterface $entityManager,    
    ): Response
    {    
        $cart = $session->get('cart',[]);             
        $cartComplete = [];

        foreach ($cart as $id=> $quantity){
            $product = $productrepository->find($id);
            $cartComplete[]=[
                'product'=>$product,
                'quantity'=>$quantity,
            ]; 
         }
                               
    return $this->render('cart/index.html.twig', compact("cartComplete"));
    }

     #[Route('/mon-panier/{id}/ajouter', name: 'app_add_to_cart')]
     public function add(Product $product,SessionInterface $session): Response
     {

        $cart = $session->get("cart",[]);
        $id = $product->getId();

        if (!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }

        $session->set("cart",$cart);

        return $this->redirectToRoute("app_cart");
        
    }

    #[Route('/mon-panier/eliminer', name: 'app_remove_my_cart')]
    public function remove(SessionInterface $session): Response
    {
        $session->remove("cart");

        return $this->redirectToRoute("app_cart");
    }



    #[Route('/mon-panier/{id}/supprimer', name: 'app_delete_to_cart')]
    public function delete(Product $product,SessionInterface $session): Response
    { 
        $cart = $session->get("cart", []);
        $id = $product->getId();

        if(!empty($cart[$id])){
            unset($cart[$id]);
        }

        $session->set("cart", $cart);
        return $this->redirectToRoute('app_cart');
    }



    #[Route('/mon-panier/{id}/diminuer', name: 'app_decrease_to_cart')]
    public function decrease(Product $product,SessionInterface $session): Response
    {
        $cart = $session->get("cart",[]);
        $id = $product->getId();

        if (!empty($cart[$id])){
            if($cart[$id]>1){
                $cart[$id]--;
            }else{
                unset($cart[$id]);
            }
        }
        $session->set("cart",$cart);
        
        
        return $this->redirectToRoute('app_cart');
      
     }

}
