<?php

namespace App\Controller;

use App\Entity\Corps;
use App\Entity\Fichier;
use App\Entity\Unite;
use App\Form\CorpsType;
use App\Form\UniteType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\Pagination\PaginationInterface;

class CorpsController extends AbstractController
{
    /**
     * @Route("/corps", name="corps")
     */
    public function index(Request $request,FileUploader $fileUploader,PaginationInterface $paginator): Response
    {
        $user = $this->getUser();

        $unite = new Unite();
        $corps = new Corps();

        $uniteForm = $this->createForm(UniteType::class,$unite);
        $corpsForm = $this->createForm(CorpsType::class,$corps);

        $uniteForm->handleRequest($request);
        $corpsForm->handleRequest($request);


        if ($corpsForm->isSubmitted()){
            $corpsLogos = $corpsForm->get('fichiers')->getData();
            if (sizeof($corpsLogos) < 1){
                $fileError = new FormError("Envoyer au moins une image");
                $corpsForm->get('fichiers')->addError($fileError);
            }
        }

        $em = $this->getDoctrine()->getManager();


        if ($uniteForm->isSubmitted() && $uniteForm->isValid()) { // traitement du formulaire
            $em->persist($unite);
            $em->flush();
            $request->getSession()->getFlashBag()->add('unite_add', 'L\'unite a été crée avec succès');
            return $this->redirectToRoute('corps');
        }

        if ($corpsForm->isSubmitted() && $corpsForm->isValid()) { // traitement du formulaire
            $corpsLogos = $corpsForm->get('fichiers')->getData();
            foreach ($corpsLogos as $corpsLogo){
                $fileName = $fileUploader->upload($corpsLogo,$this->getParameter('logosDirectory'));
                $fichier = new Fichier();
                $fichier->setNom($fileName);
                $fichier->setType('image');
                $corps->addFichier($fichier);
            }

            $em->persist($corps);
            $em->flush();
            $request->getSession()->getFlashBag()->add('corps_add', 'Le corps a été crée avec succès');
            return $this->redirectToRoute('corps');

        }

        $db_corps = $this->getDoctrine()->getManager()->getRepository(Corps::class)->findAll();
        $db_unites = $this->getDoctrine()->getManager()->getRepository(Unite::class)->findAll();

        return $this->render('corps/index.html.twig', [
            'controller_name' => 'CorpsController',
            'user' => $user,
            'db_corps' => $db_corps,
            'db_unites' => $db_unites,
            'active' => 'corps',
            'uniteForm' => $uniteForm->createView(),
            'corpsForm' => $corpsForm->createView(),
        ]);
    }
}
