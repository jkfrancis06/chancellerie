<?php

namespace App\Controller\SPA;

use App\Entity\Affectation;
use App\Entity\Corps;
use App\Entity\GradeCategorie;
use App\Entity\Militaire;
use App\Entity\Spa;
use App\Service\GetMilitaireStatut;
use App\Service\StringToHex;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpaDashboardController extends AbstractController
{

    private $getMilitaireStatut;
    private $stringToHex;

    public function __construct(GetMilitaireStatut $getMilitaireStatut, StringToHex $stringToHex){
        $this->getMilitaireStatut = $getMilitaireStatut;
        $this->stringToHex = $stringToHex;
    }

    #[Route('/spa/dashboard', name: 'spa_dashboard')]
    #[Route('/spa', name: 'spa_home')]
    public function index(): Response
    {
        $affectations_array = array();

        if ($this->getUser()->getMilitaire() != null){

            $querySpa = array();
            $affectations_array = array();
            $statuts_array = [];
            $categories_array = [];
            $militaires = [];

            $categories = $this->getDoctrine()->getManager()->getRepository(GradeCategorie::class)->findAll();


            $militaire = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find($this->getUser()->getMilitaire()->getId());

            $corps = $this->getDoctrine()->getManager()->getRepository(Corps::class)->findOneBy([
                'chefCorps' => $militaire
            ]);
            if ($corps != null) {

                $unites = $corps->getUnites();

                // push labels in grade category stats array
                foreach ($categories as $category){

                    $categories_array[$category->getId()] = [];
                    $categories_array[$category->getId()]['categorie'] = [];
                    $categories_array[$category->getId()]['count'] = 0;
                    $categories_array[$category->getId()]['color'] = '#'.$this->stringToHex->stringToColorCode($category->getIntitule());
                    $categories_array[$category->getId()]['categorie']['id'] = $category->getId();
                    $categories_array[$category->getId()]['categorie']['intitule'] = $category->getIntitule();

                }


                // push labels in status stats array

                for ($i = 0; $i <=10 ; $i++) {

                    if ($this->getMilitaireStatut->getString($i) !== "") {
                        $statuts_array[$this->getMilitaireStatut->getString($i)] = [];
                        $statuts_array[$this->getMilitaireStatut->getString($i)]['color'] = '#'.$this->stringToHex->getString($i);
                        $statuts_array[$this->getMilitaireStatut->getString($i)]['count'] = 0;
                    }

                }

                $unites_ids = [];

                $querySpa = [];

                foreach ($unites as $unite){
                    array_push($unites_ids,$unite->getId());

                    $items = $this->getDoctrine()->getManager()->getRepository(Spa::class)->findBy([  //find last SPA of all units
                        'unite' => $unite,
                    ],array('dateSpa'=>'DESC'),1,0);

                    if (sizeof($items) > 0) {
                        array_push($querySpa,$items[0]);
                    }else{
                        array_push($querySpa,null);
                    }
                }


                // on cherche les militaires qui sont dans ces unites a cette date donnee

                foreach ($querySpa as $spa){

                    if ($spa != null) {


                        if (!array_key_exists($spa->getUnite()->getId(),$affectations_array)){

                            $affectations_array[$spa->getUnite()->getId()] = [];
                            $affectations_array[$spa->getUnite()->getId()]['unite'] = $spa->getUnite();
                            $affectations_array[$spa->getUnite()->getId()]['count'] = $this->getStatsByUnite($spa->getMilitaireSpas());
                        }

                        foreach ($spa->getMilitaireSpas() as $militaireSpa){

                            if ($militaireSpa->getStatut() != null){

                                $statuts_array[$this->getMilitaireStatut->getString($militaireSpa->getStatut())]['count']++; // update status counter
                            }

                            $grade = $militaireSpa->getSavedGrade();


                            if (array_key_exists($grade['categorie']['id'], $categories_array)){
                                $categories_array[$grade['categorie']['id']]['count'] ++;
                            }
                        }
                    }

                }


                $militaires = $this->getDoctrine()->getManager()->getRepository(Affectation::class)->findBy([
                   'isActive' => true,
                   'unite' => $unites_ids,
                ]);



            }

        }else{

            return $this->redirectToRoute('app_logout');


        }


        return $this->render('spa/spa_dashboard/index.html.twig', [
            'controller_name' => 'SpaDashboardController',
            'active' => 'spa_dashboard',
            'querySpa' => $querySpa,
            'affectations' => $affectations_array,
            'statuts_array' => $statuts_array,
            'categories_array' => $categories_array,
            'militaires' => $militaires,
        ]);
    }



    private function getStatsByUnite($militaires_spa){

        $status_array = [];

        foreach ($militaires_spa as $spa) {

            if (!array_key_exists($spa->getStatut(), $status_array)) {
                $status_array[$spa->getStatut()] = 1;
            }else{
                $status_array[$spa->getStatut()]++;
            }
        }

        return $status_array;


    }
}
