<?php

namespace App\Controller;

use App\Entity\Corps;
use App\Form\Corps1Type;
use App\Form\CorpsType;
use App\Repository\CorpsRepository;
use App\Service\FileUploader;
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
            'active' => 'corps',
        ]);
    }

    #[Route('/new', name: 'corps_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $corps = new Corps();
        $form = $this->createForm(CorpsType::class, $corps);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $corpsLogo = $form->get('mainPicture')->getData();
            if ($corpsLogo != null){
                $fileName = $fileUploader->upload($corpsLogo,$this->getParameter('logosDirectory'));
                $corps->setMainPicture($fileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($corps);
            $entityManager->flush();

            $request->getSession()->getFlashBag()->add('corps_crud_new', 'Le corps a été crée avec succès');
            return $this->redirectToRoute('corps_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('corps_crud/new.html.twig', [
            'corps' => $corps,
            'form' => $form,
            'active' => 'corps',
        ]);
    }

    #[Route('/{id}', name: 'corps_crud_show', methods: ['GET'])]
    public function show(Corps $corps): Response
    {
        return $this->render('corps_crud/show.html.twig', [
            'corps' => $corps,
            'active' => 'corps',
            'unites' => $corps->getUnites(),
        ]);
    }

    #[Route('/{id}/edit', name: 'corps_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Corps $corps, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(CorpsType::class, $corps);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $corpsLogo = $form->get('mainPicture')->getData();
            if ($corpsLogo != null){
                $fileName = $fileUploader->upload($corpsLogo,$this->getParameter('logosDirectory'));
                $corps->setMainPicture($fileName);
            }

            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add('corps_crud_new', 'Le corps a été modifie avec succès');
            return $this->redirectToRoute('corps_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('corps_crud/edit.html.twig', [
            'corps' => $corps,
            'form' => $form,
            'active' => 'corps',
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

        $request->getSession()->getFlashBag()->add('corps_crud_new', 'Le corps a été supprime avec succès');
        return $this->redirectToRoute('corps_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
