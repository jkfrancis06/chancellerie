<?php

namespace App\Controller;

use App\Entity\Affectation;
use App\Entity\Corps;
use App\Entity\GradeCategorie;
use App\Entity\Militaire;
use App\Entity\Spa;
use App\Service\GetMilitaireStatut;
use App\Service\LimiteAgeCalculator;
use App\Service\StringToHex;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ch')]
class DashboardController extends AbstractController
{

    private $getMilitaireStatut;
    private $stringToHex;

    public function __construct(GetMilitaireStatut $getMilitaireStatut, StringToHex $stringToHex){
        $this->getMilitaireStatut = $getMilitaireStatut;
        $this->stringToHex = $stringToHex;
    }


    /**
     * @Route("/", name="dashboard")
     */
    public function index(LimiteAgeCalculator $limiteAgeCalculator): Response
    {

        $querySpa = array();
        $affectations_array = array();
        $statuts_array = [];
        $categories_array = [];
        $militaires_limit = [];

        $categories = $this->getDoctrine()->getManager()->getRepository(GradeCategorie::class)->findAll();

        $corps = $this->getDoctrine()->getManager()->getRepository(Corps::class)->findAll();

        if ($corps != null) {


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





            $affectations = $this->getDoctrine()->getManager()->getRepository(Affectation::class)->findBy([  //find all militaires
                'isActive' => true
            ]);



            // on cherche les militaires qui sont dans la base de donnee

            foreach ($affectations as $affectation){

                if ($affectation != null) {

                    if (!array_key_exists($affectation->getUnite()->getId(),$affectations_array)){   // si le label de cette unite existe deja dans le tableau

                        $affectations_array[$affectation->getUnite()->getId()] = [];
                        $affectations_array[$affectation->getUnite()->getId()]['unite'] = $affectation->getUnite();
                        $affectations_array[$affectation->getUnite()->getId()]['count'] = [];

                        if ($affectation->getMilitaire()->getStatut() != null ) {  // si son statut a deja ete mis a jour

                            /*
                             * Si ce statut ne figure pas dans la liste des statuts de l'unite
                             */
                            if (!array_key_exists($affectation->getMilitaire()->getStatut()->getStatut(),$affectations_array[$affectation->getUnite()->getId()]['count'])){
                                $affectations_array[$affectation->getUnite()->getId()]['count'][$affectation->getMilitaire()->getStatut()->getStatut()] = 1;
                            }else{
                                $affectations_array[$affectation->getUnite()->getId()]['count'][$affectation->getMilitaire()->getStatut()->getStatut()]++;
                            }

                        }

                    }else{

                        if ($affectation->getMilitaire()->getStatut() != null) {

                            if (!array_key_exists($affectation->getMilitaire()->getStatut()->getStatut(),$affectations_array[$affectation->getUnite()->getId()]['count'])){
                                $affectations_array[$affectation->getUnite()->getId()]['count'][$affectation->getMilitaire()->getStatut()->getStatut()] = 1;
                            }else{
                                $affectations_array[$affectation->getUnite()->getId()]['count'][$affectation->getMilitaire()->getStatut()->getStatut()]++;
                            }
                        }
                    }

                    if ($affectation->getMilitaire()->getStatut() != null && $this->getMilitaireStatut->getString($affectation->getMilitaire()->getStatut()->getStatut()) !== ""){
                        $statuts_array[$this->getMilitaireStatut->getString($affectation->getMilitaire()->getStatut()->getStatut())]['count']++; // update status counter
                    }

                    $grade = $affectation->getMilitaire()->getGrade();


                    if (array_key_exists($grade->getGradeCategorie()->getId(), $categories_array)){
                        $categories_array[$grade->getGradeCategorie()->getId()]['count'] ++;
                    }
                }

                if ($limiteAgeCalculator->calculate($affectation->getMilitaire(), 6)){
                    $item = [];
                    $date = new \DateTime();
                    $item['limit'] = $date->diff($affectation->getMilitaire()->getDateNaissance())->m;
                    $dt = new \DateTime();
                    $dt->setTimestamp($affectation->getMilitaire()->addDate($affectation->getMilitaire()->getGrade()->getLimiteAge()));
                    $item['limit_date'] = $dt;
                    $item['militaire'] = $affectation->getMilitaire();
                    array_push($militaires_limit, $item);
                }

            }





        }

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'active' => 'dashboard',
            'querySpa' => $querySpa,
            'affectations' => $affectations_array,
            'statuts_array' => $statuts_array,
            'categories_array' => $categories_array,
            'militaires_limit' => $militaires_limit,
        ]);
    }



}
