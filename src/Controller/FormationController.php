<?php

namespace App\Controller;

use App\Entity\Diplome;
use App\Entity\Formation;
use App\Form\DiplomeType;
use App\Form\FormationType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    /**
     * @Route("/formation", name="formation")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $user = $this->getUser();

        $formation = new Formation();
        $diplome = new Diplome();

        $formationForm = $this->createForm(FormationType::class,$formation);
        $diplomeForm = $this->createForm(DiplomeType::class,$diplome);

        $formationForm->handleRequest($request);
        $diplomeForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($formationForm->isSubmitted() && $formationForm->isValid()){
            $em->persist($formation);
            $em->flush();
            $request->getSession()->getFlashBag()->add('formation_add', 'La formation a été crée avec succès');
            return $this->redirectToRoute('formation');
        }

        if ($diplomeForm->isSubmitted() && $diplomeForm->isValid()){
            $em->persist($diplome);
            $em->flush();
            $request->getSession()->getFlashBag()->add('diplome_add', 'Le diplome a été crée avec succès');
            return $this->redirectToRoute('formation');
        }

        $formations = $this->getDoctrine()->getManager()->getRepository(Formation::class)->findAll();
        $diplomes = $this->getDoctrine()->getManager()->getRepository(Diplome::class)->findAll();

        $db_formations_page = $paginator->paginate(
            $formations,
            $request->query->getInt('page_com_db_formations', 1)/*page number*/,
            10/*limit per page*/,
            ['pageParameterName' => 'page_com_db_formations']
        );

        $db_diplomes_page = $paginator->paginate(
            $diplomes,
            $request->query->getInt('page_com_db_diplomes', 1)/*page number*/,
            10/*limit per page*/,
            ['pageParameterName' => 'page_com_db_diplomes']
        );

        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
            'user' => $user,
            'formations' => $db_formations_page,
            'diplomes' => $db_diplomes_page,
            'active' => "formation",
            'diplomeForm' => $diplomeForm->createView(),
            'formationForm' => $formationForm->createView(),

        ]);
    }
}
