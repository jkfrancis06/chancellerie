<?php

namespace App\Controller;

use App\Entity\Corps;
use App\Entity\Fichier;
use App\Entity\OrigineRecrutement;
use App\Entity\Specialite;
use App\Entity\Unite;
use App\Form\CorpsType;
use App\Form\OriginRecrutementType;
use App\Form\SpecialiteFormType;
use App\Form\UniteType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class CorpsController extends AbstractController
{
    /**
     * @Route("/corps", name="corps")
     */
    public function index(Request $request,FileUploader $fileUploader,PaginatorInterface $paginator): Response
    {
        $user = $this->getUser();

        $unite = new Unite();
        $corps = new Corps();
        $specialite = new Specialite();
        $origin = new OrigineRecrutement();

        $uniteForm = $this->createForm(UniteType::class,$unite);
        $corpsForm = $this->createForm(CorpsType::class,$corps);
        $specialiteForm = $this->createForm(SpecialiteFormType::class,$specialite);
        $originForm = $this->createForm(OriginRecrutementType::class,$origin);

        $uniteForm->handleRequest($request);
        $corpsForm->handleRequest($request);
        $specialiteForm->handleRequest($request);
        $originForm->handleRequest($request);


        if ($corpsForm->isSubmitted()){
            $corpsLogos = $corpsForm->get('fichiers')->getData();
            if (sizeof($corpsLogos) < 1){
                $fileError = new FormError("Envoyer au moins une image");
                $corpsForm->get('fichiers')->addError($fileError);
            }
        }

        $em = $this->getDoctrine()->getManager();


        if ($uniteForm->isSubmitted() && $uniteForm->isValid()) { // traitement du formulaire
            $em->persist($unite);
            $em->flush();
            $request->getSession()->getFlashBag()->add('unite_add', 'L\'unite a été crée avec succès');
            return $this->redirectToRoute('corps');
        }

        if ($corpsForm->isSubmitted() && $corpsForm->isValid()) { // traitement du formulaire
            $corpsLogos = $corpsForm->get('fichiers')->getData();
            foreach ($corpsLogos as $corpsLogo){
                $fileName = $fileUploader->upload($corpsLogo,$this->getParameter('logosDirectory'));
                $fichier = new Fichier();
                $fichier->setNom($fileName);
                $fichier->setType('image');
                $corps->addFichier($fichier);
            }

            $em->persist($corps);
            $em->flush();
            $request->getSession()->getFlashBag()->add('corps_add', 'Le corps a été crée avec succès');
            return $this->redirectToRoute('corps');

        }

        if ($specialiteForm->isSubmitted() && $specialiteForm->isValid()) {// traitement du formulaire
            $em->persist($specialite);
            $em->flush();
            $request->getSession()->getFlashBag()->add('specialite_add', 'La specialite a été crée avec succès');
            return $this->redirectToRoute('corps');
        }

        if ($originForm->isSubmitted() && $originForm->isValid()) {// traitement du formulaire
            $em->persist($origin);
            $em->flush();
            $request->getSession()->getFlashBag()->add('origin_add', 'L\'origine a été crée avec succès');
            return $this->redirectToRoute('corps');
        }


        $db_corps = $this->getDoctrine()->getManager()->getRepository(Corps::class)->findAll();
        $db_unites = $this->getDoctrine()->getManager()->getRepository(Unite::class)->findAll();
        $db_specialites = $this->getDoctrine()->getManager()->getRepository(Specialite::class)->findAll();
        $db_origins = $this->getDoctrine()->getManager()->getRepository(OrigineRecrutement::class)->findAll();

        $db_corps_page = $paginator->paginate(
            $db_corps,
            $request->query->getInt('page_com_db_corps', 1)/*page number*/,
            10/*limit per page*/,
            ['pageParameterName' => 'page_com_db_corps']
        );

        $db_unites_page = $paginator->paginate(
            $db_unites,
            $request->query->getInt('page_com_db_unites', 1)/*page number*/,
            10/*limit per page*/,
            ['pageParameterName' => 'page_com_db_unites']
        );

        $db_specialites_page = $paginator->paginate(
            $db_specialites,
            $request->query->getInt('page_com_db_specialites', 1)/*page number*/,
            10/*limit per page*/,
            ['pageParameterName' => 'page_com_db_specialites']
        );

        $db_origins_page = $paginator->paginate(
            $db_origins,
            $request->query->getInt('page_com_db_origins', 1)/*page number*/,
            10/*limit per page*/,
            ['pageParameterName' => 'page_com_db_origins']
        );

        return $this->render('corps/index.html.twig', [
            'controller_name' => 'CorpsController',
            'user' => $user,
            'db_corps' => $db_corps_page,
            'db_unites' => $db_unites_page,
            'db_specialites' => $db_specialites_page,
            'db_origins' => $db_origins_page,
            'active' => 'corps',
            'uniteForm' => $uniteForm->createView(),
            'corpsForm' => $corpsForm->createView(),
            'specialiteForm' => $specialiteForm->createView(),
            'originForm' => $originForm->createView(),
        ]);
    }
}
