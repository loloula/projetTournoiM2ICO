<?php

namespace App\Controller\Admin;

use App\Entity\Matchjouer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MatchjouerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Matchjouer::class;
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
