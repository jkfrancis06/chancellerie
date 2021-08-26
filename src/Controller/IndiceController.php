<?php

namespace App\Controller;

use App\Entity\Indice;
use App\Form\IndiceType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class IndiceController extends AbstractController
{
    /**
     * @Route("/indices", name="indices")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {

        $indice  = new Indice();

        $indiceForm = $this->createForm(IndiceType::class, $indice);

        $indiceForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($indiceForm->isSubmitted() && $indiceForm->isValid()){

            $em->persist($indice);
            $em->flush();
            $request->getSession()->getFlashBag()->add('indice_add', 'L\'indice a été crée avec succès');

        }


        $indices = $this->getDoctrine()->getManager()->getRepository(Indice::class)->findAll();

        $db_indices_page = $paginator->paginate(
            $indices,
            $request->query->getInt('page_com_db_indice', 1)/*page number*/,
            10/*limit per page*/,
            ['pageParameterName' => 'page_com_db_indice']
        );


        return $this->render('indice/index.html.twig', [
            'controller_name' => 'IndiceController',
            'active' => 'indices',
            'indices' => $db_indices_page,
            'indiceForm' => $indiceForm->createView(),
        ]);
    }
}
