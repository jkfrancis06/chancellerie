<?php

namespace App\Controller;

use App\Entity\Corps;
use App\Entity\Militaire;
use App\Service\LimiteAgeCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(LimiteAgeCalculator $limiteAgeCalculator): Response
    {
        $user = $this->getUser();

        $militaires = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->findAll();

        $militaire_service = [];
        $militaire_retraite = [];
        $militaire_radie = [];
        $militaire_disponibilite = [];
        $array= [2,4,8];

        $corps = $this->getDoctrine()->getManager()->getRepository(Corps::class)->findAll();

        $corp_array = [];

        $militaires_limit = [];

        foreach ($corps as $corp){
            $item = [];
            $item["corps"] = $corp;
            $item["effectif"] = 0;
            array_push($corp_array, $item);

        }

        foreach ($militaires as $militaire){

            if ($militaire->getMilitaireStatuts() != null) {

                if ($militaire->getMilitaireStatuts()[sizeof($militaire->getMilitaireStatuts())-1]->getStatut() == 0) {
                     array_push($militaire_retraite, $militaire);
                 }

                if ($militaire->getMilitaireStatuts()[sizeof($militaire->getMilitaireStatuts())-1]->getStatut() == 3) {
                    array_push($militaire_service, $militaire);
                }
                 if ($militaire->getMilitaireStatuts()[sizeof($militaire->getMilitaireStatuts())-1]->getStatut() == 1 ||
                     $militaire->getMilitaireStatuts()[sizeof($militaire->getMilitaireStatuts())-1]->getStatut() == 6) {
                     array_push($militaire_radie, $militaire);
                 }

                 if (in_array($militaire->getMilitaireStatuts()[sizeof($militaire->getMilitaireStatuts())-1]->getStatut(),$array)) {
                     array_push($militaire_disponibilite, $militaire);
                 }

                 $affectation = $militaire->getAffectations();

                 if ($affectation != null){
                     foreach ($corp_array as &$corp){
                         if ($affectation[sizeof($affectation)-1]->getUnite()->getCorps() == $corp["corps"]){
                             $corp["effectif"]++;
                         }
                     }
                 }

                 if ($limiteAgeCalculator->calculate($militaire, 6)){
                     $item = [];
                     $date = new \DateTime();
                     $item['limit'] = $date->diff($militaire->getDateNaissance())->m;
                     $dt = new \DateTime();
                     $dt->setTimestamp($militaire->addDate($militaire->getGrade()->getLimiteAge()));
                     $item['limit_date'] = $dt;
                     $item['militaire'] = $militaire;
                     array_push($militaires_limit, $item);
                 }

            }


        }


        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'active' => 'dashboard',
            'militaires' => $militaires,
            'militaire_service' => $militaire_service,
            'militaire_retraite' => $militaire_retraite,
            'militaire_radie' => $militaire_radie,
            'militaires_limit' => $militaires_limit,
            'militaire_disponibilite' => $militaire_disponibilite,
            'corp_array' => $corp_array,
        ]);
    }
}
