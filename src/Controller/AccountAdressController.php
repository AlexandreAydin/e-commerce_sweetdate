<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Form\AdressType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class AccountAdressController extends AbstractController
{
    #[Route('/compte/adresses', name: 'app_account_adress')]
    public function index(): Response
    {

        return $this->render('acount/adress.html.twig');
    }

    #[Route('/compte/ajouter-une-adresse', name: 'app_account_adress_add')]
    public function add(Request $request, EntityManagerInterface $manager, SessionInterface $session ): Response
    {
        $adress=new Adress();

        $form = $this->createForm(AdressType::class, $adress );
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $adress->setUser($this->getUser());
            $manager->persist($adress);
            $manager->flush();
              if ($session->get('cart', [])){
                 return $this->redirectToRoute('app_order');
              }
             
             return $this->redirectToRoute('app_account_adress');
        }
        return $this->render('acount/adress_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/compte/modifier-une-adresse/{id}', name: 'app_account_adress_edit')]
    public function edit(Request $request, EntityManagerInterface $manager, $id ): Response
    {
        $adress= $manager->getRepository(Adress::class)->find($id);

            if(!$adress || $adress->getUser() != $this->getUser()){
                return $this->redirectToRoute('app_account_adress');
            }

        $form = $this->createForm(AdressType::class, $adress );
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){        
            $manager->flush();            
            return $this->redirectToRoute('app_account_adress');
        }
        return $this->render('acount/adress_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    
    #[Route('/compte/supprimer-une-adresse/{id}', name: 'app_account_adress_delete')]
    public function delete( EntityManagerInterface $manager, $id ): Response
    {
        $adress= $manager->getRepository(Adress::class)->find($id);

            if($adress && $adress->getUser() == $this->getUser()){
            $manager->remove($adress);
            $manager->flush();            
            return $this->redirectToRoute('app_account_adress');
            }
       
    }

}
