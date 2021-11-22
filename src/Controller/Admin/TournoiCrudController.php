<?php

namespace App\Controller\Admin;

use App\Entity\Tournoi;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
class TournoiCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tournoi::class;
    }


    public function configureFields(string $pageName): iterable
    {
      yield AssociationField::new('ev');
      yield TextField::new('nomt');
      yield TextField::new('description');
      /*  return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];*/
    }

}
