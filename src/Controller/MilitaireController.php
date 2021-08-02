<?php

namespace App\Controller;

use App\Entity\Affectation;
use App\Entity\Fichier;
use App\Entity\Militaire;
use App\Entity\MilitaireExercice;
use App\Entity\MilitaireFormation;
use App\Entity\MilitaireMedaille;
use App\Entity\MilitaireMission;
use App\Entity\Telephone;
use App\Form\AffectationType;
use App\Form\MilitaireExerciceType;
use App\Form\MilitaireFormationType;
use App\Form\MilitaireMedailleType;
use App\Form\MilitaireMissionType;
use App\Form\MilitaireType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MilitaireController extends AbstractController
{
    /**
     * @Route("/militaire", name="militaire")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('militaire/index.html.twig', [
            'controller_name' => 'MilitaireController',
            'active' => 'militaire',
            'user' => $user
        ]);
    }


    /**
     * @Route("/militaire/creer", name="create_militaire")
     */
    public function createMilitaire(Request $request, FileUploader $fileUploader): Response
    {
        $user = $this->getUser();

        $militaire = new Militaire();

        $militaireForm = $this->createForm(MilitaireType::class, $militaire);

        $militaireForm->handleRequest($request);

        if ($militaireForm->isSubmitted()){
            $corpsLogos = $militaireForm->get('fichiers')->getData();
            if (sizeof($corpsLogos) < 1){
                $fileError = new FormError("Envoyer au moins une image");
                $militaireForm->get('fichiers')->addError($fileError);
            }
        }

        $em = $this->getDoctrine()->getManager();


        if ($militaireForm->isSubmitted() && $militaireForm->isValid()){

            $form_telephones = $militaireForm->get('telephone')->getData();

            $telephones = explode(";",$form_telephones);

            foreach ($telephones as $item){
                $telephone = new Telephone();
                $telephone->setNumero($item);
                $militaire->addTelephone($telephone);
            }
            $corpsLogos = $militaireForm->get('fichiers')->getData();
            foreach ($corpsLogos as $corpsLogo){
                $fileName = $fileUploader->upload($corpsLogo,$this->getParameter('elemetsDirectory'));
                $fichier = new Fichier();
                $fichier->setNom($fileName);
                $fichier->setType('image');
                $militaire->addFichier($fichier);
            }

            $em->persist($militaire);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_militaire', 'L\'element a été crée avec succès');
            return $this->redirectToRoute('militaire_details', array('id' => $militaire->getId()));

        }



        return $this->render('militaire/create.html.twig', [
            'controller_name' => 'create_militaire',
            'active' => 'create_militaire',
            'user' => $user,
            'militaireForm' => $militaireForm->createView()
        ]);
    }

    /**
     * @Route("/militaire/recherche", name="search_militaire")
     */
    public function searchMilitaire(): Response
    {
        $user = $this->getUser();
        return $this->render('militaire/search.html.twig', [
            'controller_name' => 'search_militaire',
            'user' => $user
        ]);
    }


    /**
     * @Route("/militaire/{id}", name="militaire_details")
     */
    public function details(int $id, Request $request): Response
    {

        $militaire = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find($id);

        if ($militaire == null){
            throw new NotFoundHttpException("Element non trouve");
        }

        $affectation = new Affectation();
        $militaireMission = new MilitaireMission();
        $militaireExercice = new MilitaireExercice();
        $militaireMedaille = new MilitaireMedaille();
        $militaireFormation = new MilitaireFormation();
        $militaireFormationPlan = new MilitaireFormation();


        $affectationForm = $this->createForm(AffectationType::class,$affectation);
        $militaireMissionForm = $this->createForm(MilitaireMissionType::class,$militaireMission);
        $militaireExerciceForm = $this->createForm(MilitaireExerciceType::class,$militaireExercice);
        $militaireMedailleForm = $this->createForm(MilitaireMedailleType::class,$militaireMedaille);
        $militaireFormationForm = $this->createForm(MilitaireFormationType::class,$militaireFormation);
        $militaireFormationPlanForm = $this->createForm(MilitaireFormationType::class,$militaireFormationPlan);



        $affectationForm->handleRequest($request);
        $militaireMissionForm->handleRequest($request);
        $militaireExerciceForm->handleRequest($request);
        $militaireMedailleForm->handleRequest($request);
        $militaireFormationForm->handleRequest($request);
        $militaireFormationPlanForm->handleRequest($request);

        $form_error = false;


        $em = $this->getDoctrine()->getManager();

        if (
            ($affectationForm->isSubmitted() && !$affectationForm->isValid()) ||
            ($militaireMissionForm->isSubmitted() && !$militaireMissionForm->isValid()) ||
            ($militaireExerciceForm->isSubmitted() && !$militaireExerciceForm->isValid()) ||
            ($militaireMedailleForm->isSubmitted() && !$militaireMedailleForm->isValid()) ||
            ($militaireFormationForm->isSubmitted() && !$militaireFormationForm->isValid()) ||
            ($militaireFormationPlanForm->isSubmitted() && !$militaireFormationPlanForm->isValid())
        ){
            $form_error = true;
        }



        if ($affectationForm->isSubmitted() && $affectationForm->isValid()){
            $affectation->setMilitaire($militaire);
            $em->persist($affectation);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_affectation', 'Affectation cree avec success');
        }

        if ($militaireMissionForm->isSubmitted() && $militaireMissionForm->isValid()){
            $militaireMission->setMilitaire($militaire);
            $em->persist($militaireMission);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_militaireMission', 'Success');
        }

        if ($militaireExerciceForm->isSubmitted() && $militaireExerciceForm->isValid()){
            $militaireExercice->setMilitaire($militaire);
            $em->persist($militaireExercice);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_militaireExercice', 'Success');

        }

        if ($militaireMedailleForm->isSubmitted() && $militaireMedailleForm->isValid()){
            $militaireMedaille->setMilitaire($militaire);
            $em->persist($militaireMedaille);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_militaireMedaille', 'Success');

        }

        if ($militaireFormationForm->isSubmitted() && $militaireFormationForm->isValid()){
            $militaireFormation->setMilitaire($militaire);
            $militaireFormation->setStatut(0);
            $em->persist($militaireFormation);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_militaireFormation', 'Success');
        }

        if ($militaireFormationPlanForm->isSubmitted() && $militaireFormationPlanForm->isValid()){
            echo 'non ok';
            $militaireFormationPlan->setMilitaire($militaire);
            $militaireFormationPlan->setStatut(1);
            $em->persist($militaireFormationPlan);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_militaireFormationPlan', 'Success');

        }

        $affectations = $militaire->getAffectations();

        $militaireMissions = $militaire->getMilitaireMissions();

        $militaireExercices = $militaire->getMilitaireExercices();

        $militaireMedailles = $militaire->getMilitaireMedailles();

        $militaireFormations = $militaire->getMilitaireFormations();


        $user = $this->getUser();
        return $this->render('militaire/details.html.twig', [
            'controller_name' => 'MilitaireController',
            'active' => 'militaire',
            'user' => $user,
            'error' => $form_error,
            'militaire' => $militaire,
            'militaireMissions' => $militaireMissions,
            'militaireExercices' => $militaireExercices,
            'militaireMedailles' => $militaireMedailles,
            'militaireFormations' => $militaireFormations,
            'affectations' => $affectations,
            'affectationForm' => $affectationForm->createView(),
            'militaireMissionForm' => $militaireMissionForm->createView(),
            'militaireExerciceForm' => $militaireExerciceForm->createView(),
            'militaireFormationForm' => $militaireFormationForm->createView(),
            'militaireFormationFormPlan' => $militaireFormationPlanForm->createView(),
            'militaireMedailleForm' => $militaireMedailleForm->createView()
        ]);
    }
}
