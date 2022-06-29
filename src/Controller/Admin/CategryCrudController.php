<?php

namespace App\Controller\Admin;

use App\Entity\Categry;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categry::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
