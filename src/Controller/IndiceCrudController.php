<?php

namespace App\Controller;

use App\Entity\Indice;
use App\Entity\Militaire;
use App\Form\Indice1Type;
use App\Form\IndiceType;
use App\Repository\IndiceRepository;
use App\Service\IndiceCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/ch/indice/crud')]
class IndiceCrudController extends AbstractController
{

    private $calculator;

    public function __construct(IndiceCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    #[Route('/', name: 'indice_crud_index', methods: ['GET'])]
    public function index(IndiceRepository $indiceRepository): Response
    {
        return $this->render('indice_crud/index.html.twig', [
            'indices' => $indiceRepository->findBy([],['indice'=>'DESC']),
            'active' => 'indice',
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/new', name: 'indice_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $indice = new Indice();
        $form = $this->createForm(IndiceType::class, $indice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($indice);
            $entityManager->flush();
            $request->getSession()->getFlashBag()->add('indice_crud_new', 'L\'indice a été crée avec succès');
            return $this->redirectToRoute('indice_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('indice_crud/new.html.twig', [
            'indice' => $indice,
            'indiceForm' => $form,
            'active' => 'indice',

        ]);
    }

    #[Route('/{id}', name: 'indice_crud_show', methods: ['GET'])]
    public function show(Indice $indice): Response
    {

        //$militaires = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->findActiveMilitaires();
        $militaires = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->findAll();

        $indice_militaires = [];

        foreach ($militaires as $militaire){


            if ($this->calculator->calculateIndice($militaire) == $indice){

                array_push($indice_militaires,$militaire);
            }

        }

        return $this->render('indice_crud/show.html.twig', [
            'indice' => $indice,
            'active' => 'indice',
            'militaires' => $indice_militaires,

        ]);
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/{id}/edit', name: 'indice_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Indice $indice): Response
    {
        $form = $this->createForm(IndiceType::class, $indice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add('indice_crud_new', 'L\'indice a été modifié avec succès');
            return $this->redirectToRoute('indice_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('indice_crud/edit.html.twig', [
            'indice' => $indice,
            'indiceForm' => $form,
            'active' => 'indice',
        ]);
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/{id}', name: 'indice_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Indice $indice): Response
    {
        if ($this->isCsrfTokenValid('delete'.$indice->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($indice);
            $entityManager->flush();

            $request->getSession()->getFlashBag()->add('indice_crud_new', 'L\'indice a été supprimeé avec succès');
        }
        return $this->redirectToRoute('indice_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
