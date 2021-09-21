<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Entity\Fichier;
use App\Entity\MilitaireMission;
use App\Entity\Mission;
use App\Form\ExerciceType;
use App\Form\MilitaireMissionType;
use App\Form\MilitaireType;
use App\Form\MissionType;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MissionController extends AbstractController
{
    /**
     * @Route("/mission", name="mission")
     */
    public function index(Request $request,FileUploader $fileUploader,PaginatorInterface $paginator): Response
    {

        $user = $this->getUser();

        $mission = new Mission();
        $exercice = new Exercice();



        $missionForm = $this->createForm(MissionType::class,$mission);
        $exerciceForm = $this->createForm(ExerciceType::class,$exercice);


        $missionForm->handleRequest($request);
        $exerciceForm->handleRequest($request);


        if ($missionForm->isSubmitted()){
            $missionLogos = $missionForm->get('logo')->getData();
            if (sizeof($missionLogos) < 1){
                $fileError = new FormError("Envoyer au moins une image");
                $missionForm->get('logo')->addError($fileError);
            }
        }

        $em = $this->getDoctrine()->getManager();

        if ($missionForm->isSubmitted() && $missionForm->isValid()){

            $missionLogos = $missionForm->get('logo')->getData();
            foreach ($missionLogos as $missionLogo){
                $fileName = $fileUploader->upload($missionLogo,$this->getParameter('logosDirectory'));
                $fichier = new Fichier();
                $fichier->setNom($fileName);
                $fichier->setType('image');
                $mission->setLogo($fichier);
            }

            $em->persist($mission);
            $em->flush();
            $request->getSession()->getFlashBag()->add('mission_add', 'La mission a été crée avec succès');
            return $this->redirectToRoute('mission');

        }


        if ($exerciceForm->isSubmitted() && $exerciceForm->isValid()){

            $em->persist($exercice);
            $em->flush();
            $request->getSession()->getFlashBag()->add('exercice_add', 'L\'exercice a été crée avec succès');
            return $this->redirectToRoute('mission');

        }


        $missions = $this->getDoctrine()->getManager()->getRepository(Mission::class)->findAll();
        $exercices = $this->getDoctrine()->getManager()->getRepository(Exercice::class)->findAll();



        $db_missions_page = $paginator->paginate(
            $missions,
            $request->query->getInt('page_com_db_missions', 1)/*page number*/,
            10/*limit per page*/,
            ['pageParameterName' => 'page_com_db_missions']
        );

        $db_exercice_page = $paginator->paginate(
            $exercices,
            $request->query->getInt('page_com_db_exercice', 1)/*page number*/,
            10/*limit per page*/,
            ['pageParameterName' => 'page_com_db_exercice']
        );

        return $this->render('mission/index.html.twig', [
            'controller_name' => 'MissionController',
            'user' => $user,
            'missions' => $db_missions_page,
            'exercices' => $db_exercice_page,
            'missionForm' => $missionForm->createView(),
            'exerciceForm' => $exerciceForm->createView(),
            'active' => "mission"
        ]);
    }
}
