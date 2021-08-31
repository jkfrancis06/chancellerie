<?php

namespace App\Controller;

use App\Entity\Unite;
use App\Form\Unite1Type;
use App\Repository\UniteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/unite')]
class UniteController extends AbstractController
{
    #[Route('/', name: 'unite_index', methods: ['GET'])]
    public function index(UniteRepository $uniteRepository): Response
    {
        return $this->render('unite/index.html.twig', [
            'unites' => $uniteRepository->findAll(),
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

            return $this->redirectToRoute('unite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('unite/new.html.twig', [
            'unite' => $unite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'unite_show', methods: ['GET'])]
    public function show(Unite $unite): Response
    {
        return $this->render('unite/show.html.twig', [
            'unite' => $unite,
        ]);
    }

    #[Route('/{id}/edit', name: 'unite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Unite $unite): Response
    {
        $form = $this->createForm(Unite1Type::class, $unite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('unite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('unite/edit.html.twig', [
            'unite' => $unite,
            'form' => $form,
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

        return $this->redirectToRoute('unite_index', [], Response::HTTP_SEE_OTHER);
    }
}
