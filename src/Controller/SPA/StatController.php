<?php

namespace App\Controller\SPA;

use App\Entity\Affectation;
use App\Entity\GradeCategorie;
use App\Entity\MilitaireSpa;
use App\Entity\Spa;
use App\Form\SpaStatType;
use App\Service\GetMilitaireStatut;
use App\Service\StringToHex;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/spa/stats')]
class StatController extends AbstractController
{
    private $getMilitaireStatut;
    private $stringToHex;

    public function __construct(GetMilitaireStatut $getMilitaireStatut, StringToHex $stringToHex){
        $this->getMilitaireStatut = $getMilitaireStatut;
        $this->stringToHex = $stringToHex;
    }

    #[Route('/', name: 'spa_stat')]
    public function index(Request $request): Response
    {

        $statForm = $this->createForm(SpaStatType::class);

        $statForm->handleRequest($request);

        $querySpa = array();
        $affectations_array = array();

        $statuts_array = [];
        $categories_array = [];

        $selectedDate = null;

        if ($statForm->isSubmitted() && $statForm->isValid()){

            $categories = $this->getDoctrine()->getManager()->getRepository(GradeCategorie::class)->findAll();

            // push data in grade category stats array
            foreach ($categories as $category){

                $categories_array[$category->getId()] = [];
                $categories_array[$category->getId()]['categorie'] = [];
                $categories_array[$category->getId()]['count'] = 0;
                $categories_array[$category->getId()]['color'] = '#'.$this->stringToHex->stringToColorCode($category->getIntitule());
                $categories_array[$category->getId()]['categorie']['id'] = $category->getId();
                $categories_array[$category->getId()]['categorie']['intitule'] = $category->getIntitule();

            }

            $selectedDate = $statForm->get('period')->getData();
            $unites = $statForm->get('unite')->getData();

            // push data in status stats array

            for ($i = 0; $i <=10 ; $i++) {

                if ($this->getMilitaireStatut->getString($i) !== "") {
                    $statuts_array[$this->getMilitaireStatut->getString($i)] = [];
                    $statuts_array[$this->getMilitaireStatut->getString($i)]['color'] = '#'.$this->stringToHex->getString($i);
                    $statuts_array[$this->getMilitaireStatut->getString($i)]['count'] = 0;
                }

            }

            $unites_ids = [];

            foreach ($unites as $unite){
                array_push($unites_ids,$unite->getId());
            }


            $querySpa = $this->getDoctrine()->getManager()->getRepository(Spa::class)->findBy([
                'dateSpa' => $selectedDate,
                'unite' => $unites_ids
            ]);


            //$querySpa = $this->getDoctrine()->getManager()->getRepository(Spa::class)->findSpaByDateAndUnite($selectedDate,$unites);

            //$affectations = $this->getDoctrine()->getManager()->getRepository(Affectation::class)->findAffectationByUnite($unites);

            //$affectations = $this->getDoctrine()->getManager()->getRepository(Affectation::class)->findSelectedAffectations($unites,$selectedDate);





            // on cherche les militaires qui sont dans ces unites a cette date donnee

            if ($querySpa != null) {



                foreach ($querySpa as $spa){

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




        }

        return $this->render('spa/stat/index.html.twig', [
            'controller_name' => 'StatController',
            'active' => 'spa_stat',
            'date' => $selectedDate,
            'statForm' => $statForm->createView(),
            'querySpa' => $querySpa,
            'affectations' => $affectations_array,
            'statuts_array' => $statuts_array,
            'categories_array' => $categories_array,
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
