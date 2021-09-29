<?php

namespace App\Controller;

use App\Entity\Corps;
use App\Form\Corps1Type;
use App\Repository\CorpsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ch/corps/crud')]
class CorpsCrudController extends AbstractController
{
    #[Route('/', name: 'corps_crud_index', methods: ['GET'])]
    public function index(CorpsRepository $corpsRepository): Response
    {
        return $this->render('corps_crud/index.html.twig', [
            'corps' => $corpsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'corps_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $corps = new Corps();
        $form = $this->createForm(Corps1Type::class, $corps);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($corps);
            $entityManager->flush();

            return $this->redirectToRoute('corps_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('corps_crud/new.html.twig', [
            'corps' => $corps,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'corps_crud_show', methods: ['GET'])]
    public function show(Corps $corps): Response
    {
        return $this->render('corps_crud/show.html.twig', [
            'corps' => $corps,
        ]);
    }

    #[Route('/{id}/edit', name: 'corps_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Corps $corps): Response
    {
        $form = $this->createForm(Corps1Type::class, $corps);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('corps_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('corps_crud/edit.html.twig', [
            'corps' => $corps,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'corps_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Corps $corps): Response
    {
        if ($this->isCsrfTokenValid('delete'.$corps->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($corps);
            $entityManager->flush();
        }

        return $this->redirectToRoute('corps_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
