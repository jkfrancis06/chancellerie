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
use App\Entity\MilitaireStatut;
use App\Entity\Punition;
use App\Entity\SousDossier;
use App\Entity\Telephone;
use App\Form\AffectationType;
use App\Form\FamilleType;
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
    public function details(int $id, Request $request): Response
    {

        $militaire = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find($id);

        if ($militaire == null){
            throw new NotFoundHttpException("Element non trouve");
        }

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
                $em->flush();
            }

            $affectation->setMilitaire($militaire);
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

            $militaireStatut->setMilitaire($militaire);
            if ($militaireStatut->getStatut() == 1) { // radiation
                $db_militaireStatut = $this->getDoctrine()->getManager()->getRepository(MilitaireStatut::class)->findBy([   // verifier si le dernier statut n'est pas radiation pour ne pas superposer les radiations
                    'militaire'=> $militaire
                ]);

                if (sizeof( $db_militaireStatut) > 0){   // si il a deja un historique
                    if ($db_militaireStatut[sizeof($db_militaireStatut) -1 ]->getStatut() == 1){  // radie donc ne rien faire
                        return $this->redirectToRoute('militaire_details', array('id' => $militaire->getId()));
                    }elseif ($db_militaireStatut[sizeof($db_militaireStatut) -1 ]->getStatut() == 11){  // en attente de confirmation donc rediriger vers la page de confirmation
                        return $this->redirectToRoute('militaire_radiation', array(
                            'id' => $militaire->getId(),
                            'status' => $db_militaireStatut[sizeof($db_militaireStatut) -1 ]->getId()
                        ));
                    }else{                                                                              // ajouter le statut
                        $militaireStatut->setStatut(11);
                        $em->persist($militaireStatut);
                        $em->flush();
                        return $this->redirectToRoute('militaire_radiation', array(
                            'id' => $militaire->getId(),
                            'status' => $militaireStatut->getId()
                        ));
                    }
                }else{    // ajouter le statut
                    $militaireStatut->setStatut(11);
                    $em->persist($militaireStatut);
                    $em->flush();
                    return $this->redirectToRoute('militaire_radiation', array(
                        'id' => $militaire->getId(),
                        'status' => $militaireStatut->getId()
                    ));
                }

            }else{
                $em->persist($militaireStatut);
                $em->flush();
                $request->getSession()->getFlashBag()->add('statut', 'Success');
                return $this->redirectToRoute('militaire_details', array('id' => $militaire->getId()));
            }

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
            'militaireStatus' => $militaireStatus,
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
     * @Route("/militaire/r/{id}/{status}", name="militaire_radiation")
     */
    public function confirmStatus($id,$status,Request $request): Response
    {
        $user = $this->getUser();

        $militaire = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find($id);

        $db_militaireStatut = $this->getDoctrine()->getManager()->getRepository(MilitaireStatut::class)->find($status);


        if ($militaire == null || $db_militaireStatut == null ){
            throw new NotFoundHttpException("Element non trouve");
        }


        $confirmForm = $this->createForm(RadiationConfirmType::class);

        $confirmForm->handleRequest($request);

        if ($confirmForm->isSubmitted()){
            $submittedMatricule = $confirmForm->get('numero_matricule')->getData();
            if ($submittedMatricule != $militaire->getMatricule()){
                $error = new FormError("Le numero matricule est incorrect");
                $confirmForm->get('numero_matricule')->addError($error);
            }
        }

        $em = $this->getDoctrine()->getManager();

        if ($confirmForm->isSubmitted() && $confirmForm->isValid()){

            $db_militaireStatut->setStatut(1);

            $em->flush();
            $request->getSession()->getFlashBag()->add('statut', 'Success');
            return $this->redirectToRoute('militaire_details', array('id' => $militaire->getId()));
        }


        return $this->render('militaire/confirm_statut.html.twig', [
            'controller_name' => 'DashboardController',
            'active' => 'dashboard',
            'militaire' => $militaire,
            'user' => $user,
            'confirmForm' => $confirmForm->createView()
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

        $militaires =  $this->getDoctrine()->getManager()->getRepository(Militaire::class)->findBy(array(), array('matricule' => 'ASC'));


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




}
