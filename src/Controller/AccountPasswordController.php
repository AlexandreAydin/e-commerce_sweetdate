<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    /**
     * AccountPasswordController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    // public function __construct(User $user)
    // {
    //     $this->user = $user;
    // }

    #[Route('/modifier-mon-mots-de-passe', name: 'app_account_password')]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request, UserPasswordHasherInterface $hasher,)
    {
        $notification = null;

        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();

            $user = $form->getData();

            if ($hasher->isPasswordValid($user, $old_pwd)) {
                $new_pwd = $form->get('new_password')->getData();
                $password = $hasher->hashPassword($user, $new_pwd);

                $user->setPassword($password);
                $this->entityManager->flush();
                $notification = "Votre mot de passe a bien été mis à jour.";
            } else {
                $notification = "Votre mot de passe actuel n'est pas le bon";
            }
        }

        return $this->render('acount/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
