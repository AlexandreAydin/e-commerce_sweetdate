<?php

namespace App\Controller;

use App\DTO\ProductSearch;
use App\Entity\Header;
use App\Entity\Product;
use App\Form\ProductSearchType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager,Request $request,ProductRepository $repository): Response
    {
        $headers=$entityManager->getRepository(Header::class)->findAll(1);
        $products = $entityManager->getRepository(Product::class)->findAll(1);
        $productMeilleur = $entityManager->getRepository(Product::class)->findBymeilleur(1);
        $productBaklava = $entityManager->getRepository(Product::class)->findByBaklawa(1);
        $productNosSpecialites = $entityManager->getRepository(Product::class)->findByNosSpecialites(1);
        $productFruitSec = $entityManager->getRepository(Product::class)->findByFruitSec(1);
        $productAutre = $entityManager->getRepository(Product::class)->findByAutre(1);

        //  dd([$productBest, $productBaklava,$productBaklavaSurPlateau,$productBaklavaSpeciale,$productCadeaux,$productAutre,$productBientot ]);
        //  $headers=$entityManager->getRepository(Header::class)->findAll(1);

        $search = new ProductSearch();
        $form = $this->createForm(ProductSearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){    
            $products = $repository->findBySearch($form->getData());
        } else {
            $products = $entityManager->getRepository(Product::class)->findAll();
        }

        return $this->render('home/index.html.twig', [
            'products' => $products,
            'form'=>$form->createView(),
            "headers"=>$headers,
            'productMeilleur'=>$productMeilleur,
            'productBaklava'=>$productBaklava,
            'productNosSpecialites'=>$productNosSpecialites,
            'productFruitSec'=>$productFruitSec,
            'productAutre'=>$productAutre,
            
        ]);
    
    }
}
