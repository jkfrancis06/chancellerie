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


#[Route('/ch')]
class CorpsController extends AbstractController
{
    /**
     * @Route("/specialite-origine", name="spe_ori")
     */
    public function index( Request $request,FileUploader $fileUploader,PaginatorInterface $paginator): Response
    {
        $user = $this->getUser();

        $specialite = new Specialite();
        $origin = new OrigineRecrutement();

        $specialiteForm = $this->createForm(SpecialiteFormType::class,$specialite);
        $originForm = $this->createForm(OriginRecrutementType::class,$origin);

        $specialiteForm->handleRequest($request);
        $originForm->handleRequest($request);




        $em = $this->getDoctrine()->getManager();


        if ($specialiteForm->isSubmitted() && $specialiteForm->isValid()) {// traitement du formulaire
            $em->persist($specialite);
            $em->flush();
            $request->getSession()->getFlashBag()->add('specialite_add', 'La specialite a été crée avec succès');
            return $this->redirectToRoute('spe_ori');
        }

        if ($originForm->isSubmitted() && $originForm->isValid()) {// traitement du formulaire
            $em->persist($origin);
            $em->flush();
            $request->getSession()->getFlashBag()->add('origin_add', 'L\'origine a été crée avec succès');
            return $this->redirectToRoute('spe_ori');
        }

        $db_specialites = $this->getDoctrine()->getManager()->getRepository(Specialite::class)->findAll();
        $db_origins = $this->getDoctrine()->getManager()->getRepository(OrigineRecrutement::class)->findAll();



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

        return $this->render('specialite_origine/index.html.twig', [
            'controller_name' => 'CorpsController',
            'user' => $user,
            'db_specialites' => $db_specialites_page,
            'db_origins' => $db_origins_page,
            'active' => 'spe_origine',
            'specialiteForm' => $specialiteForm->createView(),
            'originForm' => $originForm->createView(),
        ]);
    }
}
