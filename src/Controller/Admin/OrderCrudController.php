<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;

class OrderCrudController extends AbstractCrudController
{

    private $adminUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, AdminUrlGenerator $adminUrlGenerator)
    {
       
        $this->adminUrlGenerator = $adminUrlGenerator;
    }




    public static function getEntityFqcn(): string
    {
        return Order::class;
    }


    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation = Action::new('updatePreparation', 'Préparation en cours', 'fas fa-box-open')->linkToCrudAction('updatePreparation');
        $updateDelivery = Action::new('updateDelivery', 'Livraison en cours', 'fas fa-truck')->linkToCrudAction('updateDelivery');
        $delivery= Action::new('delivery','Livrée','fas fa-check')->linkToCrudAction('delivery');

        return $actions
            ->add('detail', $updatePreparation)
            ->add('detail', $updateDelivery)
            ->add('detail', $delivery)
            ->add('index', 'detail');
    }

    

    public function updatePreparation(AdminContext $context,EntityManagerInterface $entityManager)
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(2);
        $entityManager->flush();

        $this->addFlash('notice', "<span style='color:green;'><strong>La commande ".$order->getReference()." est bien <u>en cours de préparation</u>.</strong></span>");

        $url = $this->adminUrlGenerator
        ->setController(OrderCrudController::class)
        ->setAction('index')
        ->generateUrl();
    return $this->redirect($url);
}
    


    public function updateDelivery(AdminContext $context, EntityManagerInterface $entityManager)
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(3);
        $entityManager->flush();

        $this->addFlash('notice', "<span style='color:orange;'><strong>La commande ".$order->getReference()." est bien <u>en cours de livraison</u>.</strong></span>");


        $url = $this->adminUrlGenerator
        ->setController(OrderCrudController::class)
        ->setAction('index')
        ->generateUrl();
    return $this->redirect($url);
}


public function delivery(AdminContext $context, EntityManagerInterface $entityManager)
{
    $order = $context->getEntity()->getInstance();
    $order->setState(4);
    $entityManager->flush();

    $this->addFlash('notice', "<span style='color:orange;'><strong>La commande ".$order->getReference()." est bien <u>était livré</u>.</strong></span>");


    $url = $this->adminUrlGenerator
    ->setController(OrderCrudController::class)
    ->setAction('index')
    ->generateUrl();
return $this->redirect($url);
}
    



    public function configureCrud(Crud $crud):Crud
    {
        return $crud->setDefaultSort(['id'=>'DESC']);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('createdAt'),
            TextField::new('user.fullname', 'Utilisateur'),
            TextEditorField::new('delivery', 'Adresse de livraison')->onlyOnDetail(),
            MoneyField::new('total', 'Total produit')->setCurrency('EUR'),
            MoneyField::new('carrierPrice', 'Frais de port')->setCurrency('EUR'),
            TextField::new('carrierName', 'Transporteur'),
            MoneyField::new('carrierPrice', 'Frais de port')->setCurrency('EUR'),
            ChoiceField::new('state')->setChoices([
                'Non payée' => 0,
                'Payée' => 1,
                'Préparation en cours' => 2,
                'Livraison en cours' => 3,
                'Livré' => 4
            ]),
            ArrayField::new('orderDetails', 'Produits achetés')->hideOnIndex()
        ];
    }


    
}
