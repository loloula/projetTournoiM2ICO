<?php

namespace App\Form;

use App\Entity\Equipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Tournoi;
use App\Repository\TournoiRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
class EquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('tournoi', EntityType::class, [ // nom de l'attribut dans Tournoi
        'class' => Tournoi::class, // quelles entités
        //'data' => $this->security->getUser(),
        //$this->getManager()->getRepository("App\Entity\Evenement")->findBy(["user"=>$this->security->getUser()]),
        'query_builder' => function (TournoiRepository $er) {
        $qb=$er->createQueryBuilder('t'); // t = Tournoi
        $request = $_SERVER['REQUEST_URI'];
        //$url=$_SERVER['REQUEST_URI'];
        $data=explode('/', $request);
      //  $data = strstr($request, '/', true);
        $day = $data[2];
        return $qb->where('t.id= :UserId')->setParameter(":UserId", $day); //creer des tournois que dans les evenement qu'on a créer
        //return $qb; //ok
        },
        'choice_label' => 'nomt', // label des options du select
        'label' => 'Tournoi' // label avant le select
        ])
            ->add('nomEquipe',TextType::class)
            ->add('sauver', SubmitType::class,
            ['label' => 'Inscrire une equipe !'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }
}
