<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Evenement;
use App\Form\TournoiType;
use App\Entity\Tournoi;
use App\Entity\Equipe;
use App\Entity\Poulee;
use App\Entity\Tour;
use App\Entity\Matchjouer;
use App\Form\EquipeType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class DefaultController extends AbstractController{
  /**
	* @Route("/", name="accueil")
	*/
  public function accueil(AuthenticationUtils $authenticationUtils): Response{
    //$evtid = $this->getDoctrine()->getManager()->getRepository("App\Entity\Evenement")->find(3);
    $error = $authenticationUtils->getLastAuthenticationError();
    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();
    $evts = $this->getDoctrine()->getManager()->getRepository("App\Entity\Evenement")->findAll();
    return $this->render('accueil.html.twig', ['evts' => $evts,'last_username' => $lastUsername, 'error' => $error]);
  }
  /**
	* @Route("/tournoi/newEvt/{nom}/{dtdebut}/{dtfin}")
	*/
  public function newevt($nom,$dtdebut,$dtfin){
    //$dtdebutt->setStartedAt(new \DateTime(2012-10-05));
   $ev=new Evenement(); // constructeur par défaut tjrs
   //$entityManager = $this->getDoctrine()->getManager();
   $ev->setNom($nom);
   $ev->setDateDebut($dtdebut);
   $ev->setDateFin($dtfin);
   $entityManager = $this->getDoctrine()->getManager();
   $entityManager->persist($ev); // en tampon
   $entityManager->flush(); // en BD
   return new Response("Événement '$nom' créé avec l'id :".$ev->getId().' débute le '.$dtdebut.' et termine le '.$dtfin);
   }
    /**
* @Route("/tournoi/newTnoi/{evtid}/{nom}/{desc}", name="newTnoi")
*/
public function saisieTnoi($evtid): Response {
$tnoi=new Tournoi();
$tnoi->setNomt("");
$tnoi->setDescription(""); // saisie donc vide
$form = $this->createFormBuilder($tnoi)
->add('nomt', TextType::class)
->add('description', TextType::class)
->add('sauver', SubmitType::class, ['label' => 'Créer letournoi !'])
->getForm(); // le formulaire est créé
return $this->render('saisie.html.twig', [
'form' => $form->createView()
]);
}
/**
* @Route("/tournoi",name="tournois")
* liste des évts et des tournois
*/
public function tournois(): Response {
$evts = $this->getDoctrine()->getManager()->getRepository("App\Entity\Evenement")->findAll();
return $this->render('tournoi.html.twig', ['evts' => $evts]);
}

/**
*@Route("/gerer", name="gere")
*/
/*public function gerer():Response{
  $evts = $this->getDoctrine()->getManager()->getRepository("App\Entity\Evenement")->findBy(["user"=>$this->getUser()]);
  if($this->getUser()->getRoles()[0] == 'ROLE_GUEST'){
    return $this->render('gestionaire/gestion.html.twig', ['evts' => $evts]);
  }
  return $this->redirectToRoute('app_logout');
}*/

/**
*@Route("/listetournoi/{idev}", name="gereev")
*/
public function listetournoi ($idev):Response{
  $evtid = $this->getDoctrine()->getManager()->getRepository("App\Entity\Evenement")->find($idev);
  //if($this->getUser()->getRoles()[0] == 'ROLE_GUEST'){
  //  return $this->render('gestionaire/gestion.html.twig', ['evts' => $evts]);
//  }
  //return $this->redirectToRoute('accueil', ['evtid' =>$evtid->getNom()]);
  $evts = $this->getDoctrine()->getManager()->getRepository("App\Entity\Evenement")->findAll();
  return $this->render('accueil.html.twig', ['evts' => $evts,'evtid'=>$evtid]);
}


/**
*@Route("/gerer/{id}", name="gereruntournoi")
*/
public function gereruntournoi($id,Request $request):Response{
  //prendre le tournoi dont l'id = $id
  $tournoi = $this->getDoctrine()->getManager()->getRepository("App\Entity\Tournoi")->find($id);
  $equipe=new Equipe();
  $i=count($tournoi->getEquipes());//le nombre d'équipe inscrit
  $form = $this->createForm(EquipeType::class, $equipe);
  $form->handleRequest($request);
  //le bouton associer à la creer d'un nouveau tour1
  $formtour1 = $this->createFormBuilder()
  ->add('tour1', SubmitType::class, ['label' => 'gerer le premier tour!'])
  ->getForm(); // le formulaire est créé
  $formtour1->handleRequest($request);

  //gerer le deuxieme tour
  $formtour2 = $this->createFormBuilder()
  ->add('tour2', SubmitType::class, ['label' => 'gerer le deuxieme tour!'])
  ->getForm(); // le formulaire est créé
  $formtour2->handleRequest($request);


  //gerer le troisiéme tour
  $formtour3 = $this->createFormBuilder()
  ->add('sauver', SubmitType::class, ['label' => 'gerer le troisiéme tour!'])
  ->getForm(); // le formulaire est créé
  $formtour3->handleRequest($request);
//creer des poules à deux équipes pour le premier tour1


$poules = $this->getDoctrine()->getManager()->getRepository("App\Entity\Poulee")->findAll();

  if ($formtour1->isSubmitted() && count($tournoi->getTours()) == 0){
    $tour1=new Tour(); // constructeur par défaut tjrs
    $tour1->setNomtour('premier tour');
    $tour1->setTournoi($tournoi);
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($tour1); // en tampon
    $entityManager->flush();
    for($n=1;$n<=$i/2;$n++){
        ${'$poule'.$n}=new Poulee(); // constructeur par défaut tjrs
        ${'$poule'.$n}->setNompoule('poule'.$n);
        ${'$poule'.$n}->setTour($tour1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist(${'$poule'.$n}); // en tampon
        $entityManager->flush();
    }
    for($n=0;$n<$i;$n++){
        $tour1->addEquipe($tournoi->getEquipes()[$n]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($tour1); // en tampon
        $entityManager->flush();
    }

      $j=0;
      $m=count($tour1->getEquipes());
      $poules = $this->getDoctrine()->getManager()->getRepository("App\Entity\Poulee")->findBy(["tour"=>$tour1]);


     for($n=0; $n<4; $n++){
      //  $tour1->getPoulees()[$n]->addEquipe($tour1->getEquipes()[$n+$j]);
        $tour1->getEquipes()[$n+$j]->setPoule($poules[$n]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($tour1->getEquipes()[$n+$j]); // en tampon
        $entityManager->flush();
      //  $tour1->getPoulees()[$n]->addEquipe($tour1->getEquipes()[$n+1+$j]);
        $tour1->getEquipes()[$n+1+$j]->setPoule($poules[$n]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($tour1->getEquipes()[$n+1+$j]); // en tampon
        $entityManager->flush();
        $j++;
      }
      $nbrepoule=count($this->getDoctrine()->getManager()->getRepository("App\Entity\Poulee")->findBy(["tour"=>$tour1]));
      for($n=1;$n<=$nbrepoule;$n++){
        ${'$match'.$n}=new Matchjouer(); // constructeur par défaut tjrs
        ${'$match'.$n}->setNommatch('match'.$n);
        ${'$match'.$n}->setTour($tour1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist(${'$match'.$n}); // en tampon
        $entityManager->flush();
      }

  return $this->render('gestionaire/gereruntournoi.html.twig',['change' => $id,'form' => $form->createView(),
  'boutontour1'=>$formtour1->createView(),
  'boutontour2'=>$formtour2->createView(),
  'boutontour3'=>$formtour3->createView(),
  'tournoiactuel' => $tournoi,
  'nbrequipe'=>$i,
  'lespoules' => $poules]);
}

  if ($form->isSubmitted() && $form->isValid()) {
  $entityManager = $this->getDoctrine()->getManager();
  $entityManager->persist($equipe);
  $entityManager->flush();
  return $this->render('gestionaire/gereruntournoi.html.twig',['change' => $id,
  'form' => $form->createView(),
  'boutontour1'=>$formtour1->createView(),
  'boutontour2'=>$formtour2->createView(),
  'boutontour3'=>$formtour3->createView(),
  'tournoiactuel' => $tournoi,
  'nbrequipe' =>$i,
  'lespoules' => $poules]);}
  return $this->render('gestionaire/gereruntournoi.html.twig',['change' => $id,
  'form' => $form->createView(),
  'boutontour1'=>$formtour1->createView(),
  'boutontour2'=>$formtour2->createView(),
  'boutontour3'=>$formtour3->createView(),
  'tournoiactuel' => $tournoi,
  'nbrequipe' =>$i,
  'lespoules' => $poules]);
  //return $this->render('gestionaire/gereruntournoi.html.twig');
}
/**
* @Route("/tournoi/saisirTnoi", name="saisirTnoi")
* AVEC type de formulaire
*/
public function saisirTnoi(Request $request): Response {
$tnoi=new Tournoi();
$form = $this->createForm(TournoiType::class, $tnoi);
$form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()) {
$entityManager = $this->getDoctrine()->getManager();
$entityManager->persist($tnoi);
$entityManager->flush();
return $this->redirectToRoute('saisirTnoi');
}
return $this->render('saisie.html.twig', ['form' => $form->createView()
]);
}
/**
* @Route("/tournoi/poule", name="saisirpoule")
* AVEC type de formulaire
*/
/*public function saisirpoule(Request $request): Response {
$poule=new Poule();
$form = $this->createForm(PouleType::class, $poule);
$form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()) {
$entityManager = $this->getDoctrine()->getManager();
$entityManager->persist($poule);
$entityManager->flush();
return $this->redirectToRoute('saisirTnoi');
}
return $this->render('gestionaire/gereruntournoi.html.twig', ['form' => $form->createView()
]);
}*/
 }
?>
