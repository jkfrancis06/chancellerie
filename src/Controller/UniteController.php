<?php

namespace App\Controller;

use App\Entity\Affectation;
use App\Entity\Unite;
use App\Form\Unite1Type;
use App\Repository\UniteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ch/unite')]
class UniteController extends AbstractController
{
    #[Route('/', name: 'unite_index', methods: ['GET'])]
    public function index(UniteRepository $uniteRepository): Response
    {
        return $this->render('unite/index.html.twig', [
            'unites' => $uniteRepository->findAll(),
            'active' => 'unite_index',
        ]);
    }

    #[Route('/new', name: 'unite_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $unite = new Unite();
        $form = $this->createForm(Unite1Type::class, $unite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($unite);
            $entityManager->flush();
            $request->getSession()->getFlashBag()->add('create_unite', 'Unité crée avec success');
            return $this->redirectToRoute('unite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('unite/new.html.twig', [
            'unite' => $unite,
            'form' => $form,
            'active' => 'unite_index',
        ]);
    }

    #[Route('/{id}', name: 'unite_show', methods: ['GET'])]
    public function show(Unite $unite): Response
    {

        $affectations = $this->getDoctrine()->getManager()->getRepository(Affectation::class)->findBy([
            'unite' => $unite,
            'isActive' => true
        ]);

        return $this->render('unite/show.html.twig', [
            'unite' => $unite,
            'affectations' => $affectations,
            'active' => 'unite_index',
        ]);
    }

    #[Route('/{id}/edit', name: 'unite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Unite $unite): Response
    {
        $form = $this->createForm(Unite1Type::class, $unite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('create_unite', 'Unité modifiée avec success');
            return $this->redirectToRoute('unite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('unite/edit.html.twig', [
            'unite' => $unite,
            'form' => $form,
            'active' => 'unite_index',
        ]);
    }

    #[Route('/{id}', name: 'unite_delete', methods: ['POST'])]
    public function delete(Request $request, Unite $unite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$unite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($unite);
            $entityManager->flush();
        }
        $request->getSession()->getFlashBag()->add('unite_delete', 'Unité supprimée avec success');
        return $this->redirectToRoute('unite_index', [], Response::HTTP_SEE_OTHER);
    }
}
