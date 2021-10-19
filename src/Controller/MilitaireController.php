<?php

namespace App\Controller;

use App\Entity\Affectation;
use App\Entity\Famille;
use App\Entity\Fichier;
use App\Entity\Militaire;
use App\Entity\MilitaireExercice;
use App\Entity\MilitaireFormation;
use App\Entity\MilitaireMedaille;
use App\Entity\MilitaireMission;
use App\Entity\MilitaireSpa;
use App\Entity\MilitaireStatut;
use App\Entity\Punition;
use App\Entity\SousDossier;
use App\Entity\Telephone;
use App\Form\AffectationType;
use App\Form\FamilleType;
use App\Form\MilitaireEditType;
use App\Form\MilitaireExerciceType;
use App\Form\MilitaireFormationType;
use App\Form\MilitaireMedailleType;
use App\Form\MilitaireMissionType;
use App\Form\MilitaireStatutType;
use App\Form\MilitaireType;
use App\Form\PunitionType;
use App\Form\RadiationConfirmType;
use App\Form\SearchMilitaireType;
use App\Service\FileUploader;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ch')]
class MilitaireController extends AbstractController
{

    /**
     * @var string
     */
    private $elementsDir;

    public function __construct(string $elementsDir)
    {
        $this->elementsDir = $elementsDir;
    }

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


        for ($i = 0; $i<=10;$i++){  // create manually sousDossier form collections

            $sousDossier = new SousDossier();
            $sousDossier->setType($i);
            $militaire->getSousDossiers()->add($sousDossier);

        }

        $militaireForm = $this->createForm(MilitaireType::class, $militaire);

        $militaireForm->handleRequest($request);


        if ($militaireForm->isSubmitted()){
            //$corpsLogos = $militaireForm->get('fichiers')->getData();
            $mainPicture = $militaireForm->get('mainPicture')->getData();


            if ($mainPicture == null){
                $fileError = new FormError("Envoyer au moins un photo d'identite");
                $militaireForm->get('mainPicture')->addError($fileError);
            }

            /*if (sizeof($corpsLogos) < 1){
                $fileError = new FormError("Envoyer au moins une image");
                $militaireForm->get('fichiers')->addError($fileError);
            }*/
        }


        if ($militaireForm->isSubmitted() && $militaireForm->isValid()){

            $form_telephones = $militaireForm->get('telephone')->getData();

            $telephones = explode(";",$form_telephones);

            $mainPicture = $militaireForm->get('mainPicture')->getData();

            if ($mainPicture != null){
                $fileName = $fileUploader->upload($mainPicture,$this->elementsDir.'/'.md5($militaire->getMatricule()));
                $militaire->setMainPicture($fileName);
            }

            foreach ($telephones as $item){
                $telephone = new Telephone();
                $telephone->setNumero($item);
                $militaire->addTelephone($telephone);
            }

            foreach ($militaire->getCompteBanqMilitaires() as $compteBanqMilitaire){
                $compteBanqMilitaire->setMilitaire($militaire);
            }

            //TODO: Les sous dossiers ne sont pas lies avec le militaire : Bizarre a investiguer

            foreach ($militaire->getSousDossiers() as $sousDossier){
                $sousDossier->setMilitaire($militaire);
            }


            $sousDossiers = $militaire->getSousDossiers();

            foreach ($sousDossiers as $sousDossier){

                $sousDossier->setNumero($sousDossier->getType());

                $pieces = $sousDossier->getPieces();

                if ($pieces != null && sizeof($pieces) > 0){
                    foreach ($pieces as $index => $piece){

                        $piece->setNumeroOrdre($index);

                        $fileName = $fileUploader->upload($piece->getFile(),$this->elementsDir.'/'.md5($militaire->getMatricule()));

                        $piece->setFilename($fileName);

                    }
                }

            }

            if ($militaire->getPersonnePrev() != null){
                $personnePrev = $militaire->getPersonnePrev();
                $personnePrev->setMilitaire($militaire);
            }


            $em = $this->getDoctrine()->getManager();

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
     * @Route("/militaire/d/{id}", name="militaire_details")
     */
    public function details(int $id, Request $request,FileUploader $fileUploader): Response
    {

        $militaire = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find($id);

        if ($militaire == null){
            throw new NotFoundHttpException("Element non trouve");
        }

        /*
         * Pour les pieces de mutation crees lors de l'affectation, on selectionne le sous dossier correspondant
         */



        $affectation = new Affectation();
        $affectation->setMilitaire($militaire);


        $militaireMission = new MilitaireMission();
        $militaireExercice = new MilitaireExercice();
        $militaireMedaille = new MilitaireMedaille();
        $militaireFormation = new MilitaireFormation();
        $militaireFormationPlan = new MilitaireFormation();
        $famille = new Famille();
        $militaireStatut = new MilitaireStatut();
        $famille->setMilitaire($militaire);
        $punition = new Punition();
        $punition->setMilitaireFautif($militaire);



        $affectationForm = $this->createForm(AffectationType::class,$affectation);
        $militaireMissionForm = $this->createForm(MilitaireMissionType::class,$militaireMission);
        $militaireExerciceForm = $this->createForm(MilitaireExerciceType::class,$militaireExercice);
        $militaireMedailleForm = $this->createForm(MilitaireMedailleType::class,$militaireMedaille);
        $militaireFormationForm = $this->createForm(MilitaireFormationType::class,$militaireFormation);
        $militaireFormationPlanForm = $this->createForm(MilitaireFormationType::class,$militaireFormationPlan);
        $familleForm = $this->createForm(FamilleType::class,$famille);
        $militaireStautForm = $this->createForm(MilitaireStatutType::class,$militaireStatut);
        $punitionForm = $this->createForm(PunitionType::class,$punition);



        $affectationForm->handleRequest($request);
        $militaireMissionForm->handleRequest($request);
        $militaireExerciceForm->handleRequest($request);
        $militaireMedailleForm->handleRequest($request);
        $militaireFormationForm->handleRequest($request);
        $militaireFormationPlanForm->handleRequest($request);
        $familleForm->handleRequest($request);
        $militaireStautForm->handleRequest($request);
        $punitionForm->handleRequest($request);

        $form_error = false;


        $em = $this->getDoctrine()->getManager();

        if (
            ($affectationForm->isSubmitted() && !$affectationForm->isValid()) ||
            ($militaireMissionForm->isSubmitted() && !$militaireMissionForm->isValid()) ||
            ($militaireExerciceForm->isSubmitted() && !$militaireExerciceForm->isValid()) ||
            ($militaireMedailleForm->isSubmitted() && !$militaireMedailleForm->isValid()) ||
            ($militaireFormationForm->isSubmitted() && !$militaireFormationForm->isValid()) ||
            ($militaireFormationPlanForm->isSubmitted() && !$militaireFormationPlanForm->isValid()) ||
            ($familleForm->isSubmitted() && !$familleForm->isValid()) ||
            ($militaireStautForm->isSubmitted() && !$militaireStautForm->isValid()) ||
            ($punitionForm->isSubmitted() && !$punitionForm->isValid())
        ){
            $form_error = true;
        }



        if ($affectationForm->isSubmitted() && $affectationForm->isValid()){

            /*
             * Recuperer la derniere affectation et la desactiver
             */

            $lastAffectation = $this->getDoctrine()->getManager()->getRepository(Affectation::class)->findLastInserted($militaire);

            if ($lastAffectation != null){
                $lastAffectation->setIsActive(false);
                if ($lastAffectation->getDateFin() == null){
                    $lastAffectation->setDateFin($affectation->getDateDebut());
                }
                $em->flush();
            }

            $affectation->setIsActive(true);
            $em->persist($affectation);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_affectation', 'Affectation cree avec success');
            return $this->redirectToRoute('militaire_details', array('id' => $militaire->getId()));

        }

        if ($militaireMissionForm->isSubmitted() && $militaireMissionForm->isValid()){
            $militaireMission->setMilitaire($militaire);
            $em->persist($militaireMission);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_militaireMission', 'Success');
            return $this->redirectToRoute('militaire_details', array('id' => $militaire->getId()));
        }

        if ($militaireExerciceForm->isSubmitted() && $militaireExerciceForm->isValid()){
            $militaireExercice->setMilitaire($militaire);
            $em->persist($militaireExercice);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_militaireExercice', 'Success');
            return $this->redirectToRoute('militaire_details', array('id' => $militaire->getId()));

        }

        if ($militaireMedailleForm->isSubmitted() && $militaireMedailleForm->isValid()){
            $militaireMedaille->setMilitaire($militaire);
            $em->persist($militaireMedaille);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_militaireMedaille', 'Success');
            return $this->redirectToRoute('militaire_details', array('id' => $militaire->getId()));

        }

        if ($militaireFormationForm->isSubmitted() && $militaireFormationForm->isValid()){
            $militaireFormation->setMilitaire($militaire);
            $em->persist($militaireFormation);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_militaireFormation', 'Success');
            return $this->redirectToRoute('militaire_details', array('id' => $militaire->getId()));
        }


        if ($familleForm->isSubmitted() && $familleForm->isValid()){
            $em->persist($famille);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_membreFamille', 'Success');
            return $this->redirectToRoute('militaire_details', array('id' => $militaire->getId()));
        }


        if ($punitionForm->isSubmitted() && $punitionForm->isValid()){
            $em->persist($punition);
            $em->flush();
            $request->getSession()->getFlashBag()->add('create_punition', 'Success');
            return $this->redirectToRoute('militaire_details', array('id' => $militaire->getId()));
        }

        if ($militaireStautForm->isSubmitted() && $militaireStautForm->isValid()){

            $lastSpa = $this->getDoctrine()->getManager()->getRepository(MilitaireSpa::class)->findLastSpa($militaire);


            if ($lastSpa->getSpa() == null || $lastSpa->getSpa()->getDateSpa()->getTimestamp() < $militaireStatut->getDateDebut()->getTimestamp()) {
                $militaireStatut->setDefinedBy(MilitaireStatut::UPDATED_BY_CHAN);
                $militaire->setStatut($militaireStatut);
                $em->flush();
                $request->getSession()->getFlashBag()->add('statut', 'Success');
            }

            return $this->redirectToRoute('militaire_details', array('id' => $militaire->getId()));

        }

        $affectations = $this->getDoctrine()->getManager()->getRepository(Affectation::class)->findBy([
            'militaire' => $militaire
        ],
        [
           'id' => 'DESC'
        ]);

        $militaireMissions = $militaire->getMilitaireMissions();

        $militaireExercices = $militaire->getMilitaireExercices();

        $militaireMedailles = $militaire->getMilitaireMedailles();

        $militaireFormations = $militaire->getMilitaireFormations();

        $militaireFamilles = $militaire->getFamilles();

        $punitions = $militaire->getPunitions();



        $militaireStatut = $militaire->getStatut();

        $lastStatut = null;


        $nbEnfants = 0;

        foreach ($militaireFamilles as $item) {

            if ($item->getTypeFiliation() == 4) {
                $nbEnfants++;
            }
        }


        $user = $this->getUser();
        return $this->render('militaire/details.html.twig', [
            'controller_name' => 'MilitaireController',
            'active' => 'militaire',
            'user' => $user,
            'error' => $form_error,
            'militaire' => $militaire,
            'nbEnfants' => $nbEnfants,
            'lastStatut' => $lastStatut,
            'militaireMissions' => $militaireMissions,
            'militaireExercices' => $militaireExercices,
            'militaireMedailles' => $militaireMedailles,
            'militaireFormations' => $militaireFormations,
            'militaireStatut' => $militaireStatut,
            'affectations' => $affectations,
            'militaireFamilles' => $militaireFamilles,
            'punitions' => $punitions,
            'affectationForm' => $affectationForm->createView(),
            'militaireMissionForm' => $militaireMissionForm->createView(),
            'militaireExerciceForm' => $militaireExerciceForm->createView(),
            'militaireFormationForm' => $militaireFormationForm->createView(),
            'militaireMedailleForm' => $militaireMedailleForm->createView(),
            'familleForm' => $familleForm->createView(),
            'militaireStautForm' => $militaireStautForm->createView(),
            'punitionForm' => $punitionForm->createView(),
        ]);
    }


    /**
     * @Route("/militaire/p/{id}", name="print_militaire")
     */
    public function printMilitaire($id,Pdf $knpSnappyPdf): Response
    {
        $user = $this->getUser();

        $militaire = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find($id);

        if ($militaire == null){
            throw new NotFoundHttpException("Element non trouve");
        }



        // @var Knp\Snappy\Pdf
        /* $knpSnappyPdf->generateFromHtml(
            $this->renderView(
                'MyBundle:Foo:bar.html.twig',
                array(
                    'some'  => $vars
                )
            ),
            '/path/to/the/file.pdf'
        ); */

        $affectations = $militaire->getAffectations();

        $militaireMissions = $militaire->getMilitaireMissions();

        $militaireExercices = $militaire->getMilitaireExercices();

        $militaireMedailles = $militaire->getMilitaireMedailles();

        $militaireFormations = $militaire->getMilitaireFormations();

        $militaireFamilles = $militaire->getFamilles();


        $militaireStatus = $this->getDoctrine()->getManager()->getRepository(MilitaireStatut::class)->findBy([   // verifier si le dernier statut n'est pas radiation pour ne pas superposer les radiations
            'militaire'=> $militaire
        ],
            [
                'id' => 'DESC'
            ]);

        $lastStatut = null;


        if (sizeof($militaireStatus) > 0){
            $lastStatut = $militaireStatus[0];
        }



        $nbEnfants = 0;

        foreach ($militaireFamilles as $item) {

            if ($item->getTypeFiliation() == 4) {
                $nbEnfants++;
            }
        }






        $html =  $this->renderView('militaire/print.html.twig', [
            'user' => $user,
            'militaire' => $militaire,
            'active' => '',
            'nbEnfants' => $nbEnfants,
            'lastStatut' => $lastStatut,
            'militaireMissions' => $militaireMissions,
            'militaireExercices' => $militaireExercices,
            'militaireMedailles' => $militaireMedailles,
            'militaireFormations' => $militaireFormations,
            'militaireStatus' => $militaireStatus,
            'affectations' => $affectations,
            'militaireFamilles' => $militaireFamilles,
        ]);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'Dossier-'.$militaire->getMatricule().'.pdf'
        );
    }


    /**
     * @Route("/militaires", name="all_militaires")
     */
    public function allMilitaires(): Response
    {
        $user = $this->getUser();

        $elements = [];

        $militaires =  $this->getDoctrine()->getManager()->getRepository(Militaire::class)->findAllMilitaires();


        foreach ($militaires as $militaire){
            $militaire_item = [];
            $militaire_item['militaire'] = $militaire;
            $militaire_item['d_naiss'] = date('Y-m-d',$militaire->getDateNaissance()->getTimestamp());
            $militaire_item['d_incor'] = date('Y-m-d',$militaire->getDateIncorp()->getTimestamp());
            array_push($elements,$militaire_item);
        }

        return $this->render('militaire/all.html.twig', [
            'controller_name' => 'DashboardController',
            'active' => 'militaire',
            'user' => $user,
            'militaires' => $elements
        ]);
    }


    /**
     * @Route("/militaires/s", name="search_militaire")
     */
    public function searchMilitaires(Request $request): Response
    {
        $user = $this->getUser();

        $searchForm = $this->createForm(SearchMilitaireType::class);

        $searchForm->handleRequest($request);

        $qr_result = [];

        if ($searchForm->isSubmitted() && $searchForm->isValid()){


            $qr_result = $this->getDoctrine()->getRepository(Militaire::class)->searchMilitaire($searchForm);


        }




        return $this->render('militaire/search.html.twig', [
            'controller_name' => 'DashboardController',
            'active' => 'search_militaire',
            'user' => $user,
            'qr_result' => $qr_result,
            'searchForm' => $searchForm->createView(),
        ]);
    }


    /**
     * @Route("/militaires/e/{militaire}", name="edit_militaire")
     */
    public function editMilitaires(Militaire $militaire,Request $request): Response
    {

        $editForm = $this->createForm(MilitaireEditType::class,$militaire);

        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute('militaire_details', array('id' => $militaire->getId()));


        }


        return $this->renderForm('militaire/edit.html.twig', [
            'controller_name' => 'DashboardController',
            'active' => 'search_militaire',
            'militaire' => $militaire,
            'militaireForm' => $editForm,
        ]);
    }


    /**
     * @Route("/militaires/f/{formation}", name="mark_as_done")
     */
    public function markFormAsDone(MilitaireFormation $formation,  Request $request): Response
    {

        if ($formation->getStatut() == MilitaireFormation::FORM_PLAN){
            $today = new \DateTime();

            if ($today->getTimestamp() < $formation->getDateDebut()->getTimestamp()) {

                $request->getSession()->getFlashBag()->add('mark_formation', 'Erreur');
                return $this->redirectToRoute('militaire_details', array('id' => $formation->getMilitaire()->getId()));

            }else{

                $formation->setStatut(MilitaireFormation::FORM_DONE);
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $request->getSession()->getFlashBag()->add('create_militaireFormation', 'Success');
            }


        }
        return $this->redirectToRoute('militaire_details', array('id' => $formation->getMilitaire()->getId()));
    }

    /**
     * @Route("/militaires/fc/{formation}", name="cancel_formation")
     */
    public function cancelFormation(MilitaireFormation $formation,  Request $request): Response
    {

        if ($formation->getStatut() == MilitaireFormation::FORM_PLAN){

            $em = $this->getDoctrine()->getManager();

            $em->remove($formation);

            $em->flush();

            $request->getSession()->getFlashBag()->add('cancel_militaireFormation', 'Formation annulée');
        }

        return $this->redirectToRoute('militaire_details', array('id' => $formation->getMilitaire()->getId()));



    }



}
