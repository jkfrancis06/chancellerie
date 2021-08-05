<?php

namespace App\Controller;

use App\Entity\Diplome;
use App\Entity\Exercice;
use App\Entity\Fichier;
use App\Entity\Formation;
use App\Entity\Grade;
use App\Entity\Medaille;
use App\Entity\Militaire;
use App\Entity\MilitaireMedaille;
use App\Entity\MilitaireMission;
use App\Entity\MilitaireStatut;
use App\Entity\Mission;
use App\Entity\OrigineRecrutement;
use App\Entity\Specialite;
use App\Entity\Telephone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DummyController extends AbstractController
{
    /**
     * @Route("/dummy", name="dummy")
     */
    public function index(): Response
    {


        $dir = $this->getParameter('kernel.project_dir').'/public/temp/';

        $cpt = 0;

        $missions = $this->getDoctrine()->getManager()->getRepository(Mission::class)->findAll();
        $exercices = $this->getDoctrine()->getManager()->getRepository(Exercice::class)->findAll();
        $medailles = $this->getDoctrine()->getManager()->getRepository(Medaille::class)->findAll();
        $diplomes = $this->getDoctrine()->getManager()->getRepository(Diplome::class)->findAll();
        $formations = $this->getDoctrine()->getManager()->getRepository(Formation::class)->findAll();

        if (($handle = fopen($dir.'data.csv', "r")) !== false) {
            while (($data = fgetcsv($handle,"",";")) !== false) {
                $prv = null;
                $militaire = new Militaire();
                $militaire->setMatricule($data[0]);
                $militaire->setNom($data[1]);
                $militaire->setPrenoms($data[2]);
                if ($data[3] == 'Female'){
                    $militaire->setSexe('f');
                }else{
                    $militaire->setSexe('h');
                }
                $time = strtotime($data[3]);
                $date = $this->pickDate($prv);
                $prv = $date;
                $newformat = date('Y-m-d',$date);
                $militaire->setDateNaissance(new \DateTime($newformat));
                $militaire->setTaille($data[7]);
                $militaire->setCouleurYeux($data[6]);
                if ($data[8] == 'marie'){
                    $militaire->setSituationMatri("Marie");
                }
                if ($data[8] == 'divorce'){
                    $militaire->setSituationMatri("Divorce");
                }
                if ($data[8] == 'celibataire'){
                    $militaire->setSituationMatri("Celibataire");
                }

                $time = strtotime($data[11]);

                $newformat = date('Y-m-d',$time);

                $date = $this->pickDate($prv);
                $prv = $date;
                $newformat = date('Y-m-d',$date);
                $militaire->setDateIncorp(new \DateTime($newformat));
                $militaire->setProfessionAnt($data[12]);
                $militaire->setAdresse($data[10]);

                $fichier = new Fichier();

                if ($militaire->getSexe() == 'f' ){
                    $fileName = 'female.jpeg';
                }else{
                    $fileName = 'male.png';
                }

                $fichier->setNom($fileName);
                $fichier->setType('image');
                $militaire->addFichier($fichier);

                $telephone = new Telephone();
                $telephone->setNumero($data[5]);
                $militaire->addTelephone($telephone);

                $grade = $this->getDoctrine()->getManager()->getRepository(Grade::class)->findOneBy([
                   'intitule'  => $data[13]
                ]);

                if ($grade != null){
                    $militaire->setGrade($grade);
                }

                $specialite = $this->getDoctrine()->getManager()->getRepository(Specialite::class)->findOneBy([
                    'intitule'  => $data[14]
                ]);

                $militaire->setSpecialite($specialite);

                $origineRecrutement = $this->getDoctrine()->getManager()->getRepository(OrigineRecrutement::class)->findOneBy([
                    'intitule'  => $data[15]
                ]);
                $militaire->setOrigineRecrutement($origineRecrutement);


                if (intval($data[9]) == 0){
                    $militaire->setHasChildren(false);
                }else{
                    $militaire->setHasChildren(true);
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($militaire);
                $em->flush();

                $cpt++;
            }
            fclose($handle);
        }

        return new Response($cpt);
    }

    function pickDate($prv = null){

        $st_date = '1970-02-02';
        $en_date = '1990-06-02';
        $t_date = '2015-06-02';

        if ($prv == null){
            return rand(strtotime($st_date),strtotime($en_date));
        }else{
            $rd = rand(strtotime($st_date),strtotime($t_date));
            while ($rd <= $prv){
                $rd = rand(strtotime($st_date),strtotime($t_date));
            }
            return $rd;
        }

    }

    function test(){
        /* $min = 0;
        $max = 8;
        $rand_num = rand($min, $max);

        $prv = null;
        for ($i = 0; $i <= $rand_num ; $i++){
            $militaireStatut = new MilitaireStatut();
            $militaireStatut->setStatut($i);
            $militaireStatut->setMilitaire($militaire);
            $date = $this->pickDate($prv);
            $prv = $date;
            $militaireStatut->setDateDebut(date('Y-m-d',$date));
            $militaire->addMilitaireStatut($militaireStatut);
        }

        $rand_num = rand(0, sizeof($missions));

        $prv = null;
        for ($i = 0; $i <= $rand_num ; $i++){

            $militairemissions = new MilitaireMission();
            $militairemissions->setMission($missions[$i]);
            $militairemissions->setMilitaire($militaire);
            $militairemissions->setCommentaire('Commentaire');
            $date = $this->pickDate($prv);
            $prv = $date;
            $militairemissions->setDateDebut(date('Y-m-d',$date));
            $dateFin = $this->pickDate($militairemissions->getDateDebut());
            $militairemissions->setDateFin(date('Y-m-d',$dateFin));
            $militaire->addMilitaireMission($militairemissions);

        }


        $rand_med = rand(0, sizeof($medailles));

        $prv = null;
        for ($i = 0; $i <= $rand_med ; $i++){

            $militaireMedaille = new MilitaireMedaille();
            $militaireMedaille->setMission($missions[$i]);
            $militairemissions->setCommentaire('Commentaire');
            $date = $this->pickDate($prv);
            $prv = $date;
            $militairemissions->setDateDebut(date('Y-m-d',$date));
            $dateFin = $this->pickDate($militairemissions->getDateDebut());
            $militairemissions->setDateFin(date('Y-m-d',$dateFin));
            $militaire->addMilitaireMission($militairemissions);

        } */
    }
}
