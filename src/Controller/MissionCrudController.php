<?php

namespace App\Controller;

use App\Entity\MilitaireMission;
use App\Entity\Mission;
use App\Form\Mission1Type;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ch/mission/crud')]
class MissionCrudController extends AbstractController
{
    #[Route('/', name: 'mission_crud_index', methods: ['GET'])]
    public function index(MissionRepository $missionRepository): Response
    {
        return $this->render('mission_crud/index.html.twig', [
            'missions' => $missionRepository->findAll(),
            'active' => 'mission'
        ]);
    }

    #[Route('/new', name: 'mission_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $mission = new Mission();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mission);
            $entityManager->flush();
            $request->getSession()->getFlashBag()->add('create_mission', 'La mission a été crée avec succès');
            return $this->redirectToRoute('mission_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mission_crud/new.html.twig', [
            'mission' => $mission,
            'missionForm' => $form,
            'active' => 'mission'
        ]);
    }

    #[Route('/{id}', name: 'mission_crud_show', methods: ['GET'])]
    public function show(Mission $mission): Response
    {
        return $this->render('mission_crud/show.html.twig', [
            'mission' => $mission,
            'active' => 'mission',
            'militairesMissions' => $this->getDoctrine()->getManager()->getRepository(MilitaireMission::class)->findBy(['mission'=>$mission])
        ]);
    }

    #[Route('/{id}/edit', name: 'mission_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mission $mission): Response
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add('create_mission', 'La mission a été modifiée avec succès');
            return $this->redirectToRoute('mission_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mission_crud/edit.html.twig', [
            'mission' => $mission,
            'missionForm' => $form,
            'active' => 'mission'
        ]);
    }

    #[Route('/{id}', name: 'mission_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Mission $mission): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mission->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mission);
            $entityManager->flush();
            $request->getSession()->getFlashBag()->add('mission_delete', 'La mission a été supprim ée avec succès');
        }

        return $this->redirectToRoute('mission_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
