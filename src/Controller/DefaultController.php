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

use Doctrine\Common\Persistence\ManagerRegistry;
class DefaultController extends AbstractController{
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
/*public function newTnoi($evtid, $nom, $desc): Response {
$tnoi=new Tournoi(); // constructeur par défaut tjrs
$tnoi->setNomt($nom);
$tnoi->setDescription($desc);
$form = $this->createFormBuilder($tnoi)
->add('nomt', TextType::class)
->add('description', TextType::class)
->add('sauver', SubmitType::class, ['label' => 'Créer le tournoi !'])
->getForm(); // le formulaire est créé
$em = $this->getDoctrine()->getManager();
$evt = $em->find("App\Entity\Evenement",(int)$evtid);*/
// remarque: on peut utiliser 'App:' qui est un alias de 'App\Entity\'
/*if($evt === null){
  return $this->render('saisie.html.twig', ['form' => $form->createView()]);
} else {
$tnoi->setEv($evt);
$em->persist($tnoi); // en tampon
$em->flush();
return new Response("Le tournoi {$tnoi->getNomt()} a été enregistré dans l'événement {$evt->getNom()} !");
}
return $this->render('saisie.html.twig', ['form' => $form->createView()]);
}*/

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
public function gerer():Response{
  $evts = $this->getDoctrine()->getManager()->getRepository("App\Entity\Evenement")->findBy(["user"=>$this->getUser()]);
  return $this->render('tournoi.html.twig', ['evts' => $evts]);
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
 }
?>
