<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Entity\Medaille;
use App\Form\ExerciceType;
use App\Form\MedailleType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/ch')]
class MedailleController extends AbstractController
{
    /**
     * @Route("/medailles", name="medaille")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {

        $user = $this->getUser();

        $medaille = new Medaille();

        $medailleForm = $this->createForm(MedailleType::class,$medaille);

        $medailleForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($medailleForm->isSubmitted() && $medailleForm->isValid()){
            $em->persist($medaille);
            $em->flush();
            $request->getSession()->getFlashBag()->add('medaille_add', 'La medaille/distinction a été crée avec succès');
            return $this->redirectToRoute('medaille');
        }


        $medailles = $this->getDoctrine()->getManager()->getRepository(Medaille::class)->findAll();

        $db_medaille_page = $paginator->paginate(
            $medailles,
            $request->query->getInt('page_com_db_medaille', 1)/*page number*/,
            10/*limit per page*/,
            ['pageParameterName' => 'page_com_db_medaille']
        );



        return $this->render('medaille/index.html.twig', [
            'controller_name' => 'MedailleController',
            'active' => 'medaille',
            'user' => $user,
            'medailles' => $db_medaille_page,
            'medailleForm' => $medailleForm->createView(),
        ]);
    }
}
