<?php

namespace App\Controller\Admin;

use App\Entity\Poulee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PouleeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Poulee::class;
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
