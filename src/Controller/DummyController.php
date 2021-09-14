<?php

namespace App\Controller;

use App\Entity\Affectation;
use App\Entity\Diplome;
use App\Entity\Exercice;
use App\Entity\Fichier;
use App\Entity\Formation;
use App\Entity\Grade;
use App\Entity\Indice;
use App\Entity\Medaille;
use App\Entity\Militaire;
use App\Entity\MilitaireDiplome;
use App\Entity\MilitaireExercice;
use App\Entity\MilitaireFormation;
use App\Entity\MilitaireMedaille;
use App\Entity\MilitaireMission;
use App\Entity\MilitaireStatut;
use App\Entity\Mission;
use App\Entity\OrigineRecrutement;
use App\Entity\Specialite;
use App\Entity\Telephone;
use App\Entity\Unite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DummyController extends AbstractController
{
    /**
     * @Route("/d/{id}", name="de")
     */
    public function remove($id): Response
    {
        $militaire  = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find($id);

        //19593

        $em = $this->getDoctrine()->getManager();
        $em->remove($militaire);
        $em->flush();


        

        return new Response('ok');
    }

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


    /**
     * @Route("/dummy/test", name="dummy_test")
     */

    function test1(): Response {


        $unites = $this->getDoctrine()->getManager()->getRepository(Unite::class)->findAll();

        $militaires = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->findAll();

        foreach ($militaires as $militaire){

            $array = [];

            $rand_aff = rand(1, sizeof($unites)-1);

            $j = 0;
            while ($j < $rand_aff){
                array_push($array,$j);
                $j++;
            }

            for ($i = 0; $i <= $rand_aff ; $i++){

                $militaireAffectation = new Affectation();

                $militaireAffectation->setMilitaire($militaire);


                $prv = null;

                $date = $this->pickDate($prv);
                $prv = $date;
                $newformat = date('Y-m-d',$date);
                $militaireAffectation->setDateDebut( new \DateTime($newformat));

                $date = $this->pickDate($prv);
                $prv = $date;
                $newformat = date('Y-m-d',$date);

                $militaireAffectation->setDateFin(new \DateTime($newformat));

                $randomElement = $array[array_rand($array,1)];

                if (sizeof($array) > 1){
                    unset($array[$randomElement]);
                }

                $militaireAffectation->setUnite($unites[$randomElement]);

                $militaireAffectation->setFonction($unites[$randomElement]->getDescription().'  '.$unites[$randomElement]->getCorps()->getIntitule());

                $militaire->addAffectation($militaireAffectation);

            }
            $em = $this->getDoctrine()->getManager();
            echo 'ok';

            $em->flush();
        }


        /* $i = 0;
        $array = [];

        while ($i < 1000){
            array_push($array,$i);
            $i++;
        }

        $des_array = [];

        for ($j = 0; $j<30 ;$j++){
            $randomElement = $array[array_rand($array, 1)];
            array_push($des_array,$randomElement);
            unset($array[$randomElement]);
        }

        

        var_dump($des_array);
        var_dump(sizeof($array)); */


        return new Response('ok');
    }

    /**
     * @Route("/dummy/fn", name="dummy_fn")
     */
    function test(): Response{

        $missions = $this->getDoctrine()->getManager()->getRepository(Mission::class)->findAll();
        $exercices = $this->getDoctrine()->getManager()->getRepository(Exercice::class)->findAll();
        $medailles = $this->getDoctrine()->getManager()->getRepository(Medaille::class)->findAll();
        $diplomes = $this->getDoctrine()->getManager()->getRepository(Diplome::class)->findAll();
        $formations = $this->getDoctrine()->getManager()->getRepository(Formation::class)->findAll();
        $militaires = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->findAll();



        foreach ($militaires as $militaire){
            $min = 0;
            $max = 8;
            $rand_num = rand($min, $max);

            $prv = null;

            $ran = array(2,3,4,5,7,8);
            $randomElement = $ran[array_rand($ran, 1)];


            for ($i = 0; $i <= $rand_num ; $i++){
                $militaireStatut = new MilitaireStatut();
                $militaireStatut->setStatut($i);
                $militaireStatut->setMilitaire($militaire);
                $date = $this->pickDate($prv);
                $prv = $date;
                $newformat = date('Y-m-d',$date);
                $militaireStatut->setDateDebut( new \DateTime($newformat));
                $militaire->addMilitaireStatut($militaireStatut);
            }

            $rand_num = rand(0, sizeof($missions)-1);



            $rand_med = rand(0, sizeof($medailles)-1);

            for ($i = 0; $i <= $rand_med ; $i++){

                $militaireMedaille = new MilitaireMedaille();
                $militaireMedaille->setMilitaire($militaire);
                $militaireMedaille->setCommentaire('Commentaire');


                $incor_date = $militaire->getDateIncorp();
                $st_date = $incor_date->format('Y-m-d');
                $date = rand(strtotime($st_date),strtotime('2021-06-02'));


                $newformat = date('Y-m-d',$date);
                $militaireMedaille->setDate(new \DateTime($newformat));
                $militaireMedaille->setMedaille($medailles[$i]);
                $militaire->addMilitaireMedaille($militaireMedaille);

            }


            $rand_dip = rand(0, sizeof($diplomes)-1);

            for ($i = 0; $i <= $rand_dip ; $i++){

                $militaireDiplome = new MilitaireDiplome();
                $militaireDiplome->setMilitaire($militaire);
                $militaireDiplome->setCommentaire('Commentaire');

                $naiss_date = $militaire->getDateNaissance();
                $st_date = $naiss_date->format('Y-m-d');
                $date = rand(strtotime($st_date),strtotime('2021-06-02'));



                $newformat = date('Y-m-d',$date);
                $militaireDiplome->setDateObtention(new \DateTime($newformat));

                $militaireDiplome->setDiplome($diplomes[$i]);
                $militaire->addMilitaireDiplome($militaireDiplome);

            }


            $rand_form = rand(0, sizeof($formations)-1);

            for ($i = 0; $i <= $rand_form ; $i++){

                $militaireFormation = new MilitaireFormation();
                $militaireFormation->setMilitaire($militaire);

                $incor_date = $militaire->getDateIncorp();
                $st_date = $incor_date->format('Y-m-d');
                $date = rand(strtotime($st_date),strtotime('2021-06-02'));

                $newformat = date('Y-m-d',$date);
                $militaireFormation->setDateDebut(new \DateTime($newformat));


                $date = $this->pickDate($st_date);



                $newformat = date('Y-m-d',$date);
                $militaireFormation->setDateFin(new \DateTime($newformat));


                $militaireFormation->setStatut(1);

                $militaireFormation->setFormation($formations[$i]);

                $militaireFormation->setLieu('Comores');

                $militaire->addMilitaireFormation($militaireFormation);

            }




            $rand_ex = rand(0, sizeof($exercices)-1);

            for ($i = 0; $i <= $rand_ex ; $i++){

                $militaireExercice = new MilitaireExercice();

                $militaireExercice->setExercice($exercices[$i]);

                $militaireExercice->setCommentaire('Commentaire');

                $militaireExercice->setMilitaire($militaire);

                $incor_date = $militaire->getDateIncorp();
                $st_date = $incor_date->format('Y-m-d');
                $date = rand(strtotime($st_date),strtotime('2021-06-02'));


                $newformat = date('Y-m-d',$date);

                $militaireExercice->setDate(new \DateTime($newformat));

                $militaire->addMilitaireExercice($militaireExercice);

            }

            $em = $this->getDoctrine()->getManager();
            echo 'ok';

            $em->flush();


        }

        return new Response('ok');
    }
}
