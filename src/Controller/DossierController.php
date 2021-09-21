<?php

namespace App\Controller;

use App\Entity\Militaire;
use App\Entity\SousDossier;
use App\Form\MilitaireSousDossierUpdateType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DossierController extends AbstractController
{

    /**
     * @var string
     */
    private $elementsDir;

    public function __construct(string $elementsDir)
    {
        $this->elementsDir = $elementsDir;
    }

    #[Route('/{id}/dossiers', name: 'militaire_dossiers',methods: ['GET','POST'])]
    public function index(Request $request, Militaire $militaire, FileUploader $fileUploader): Response
    {

        $done = false;


        $militaireForm = $this->createForm(MilitaireSousDossierUpdateType::class,$militaire);

        $militaireForm->handleRequest($request);

        if ($militaireForm->isSubmitted() && $militaireForm->isValid()){

            $sousDossiers = $militaire->getSousDossiers();

            foreach ($sousDossiers as $sousDossier){

                $sousDossier->setNumero($sousDossier->getType());

                $pieces = $sousDossier->getPieces();

                if ($pieces != null && sizeof($pieces) > 0){
                    foreach ($pieces as $index => $piece){

                        $piece->setNumeroOrdre($index);

                        if ($piece->getFile() != null){

                            $fileName = $fileUploader->upload($piece->getFile(),$this->elementsDir.'/'.md5($militaire->getMatricule()));
                            $piece->setFilename($fileName);
                        }

                    }
                }

            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $done = true;

        }

        return $this->render('dossier/index.html.twig', [
            'controller_name' => 'DossierController',
            'active' => 'dossier',
            'militaire' => $militaire,
            'militaireForm' => $militaireForm->createView(),
            'done' => $done
        ]);
    }
}
