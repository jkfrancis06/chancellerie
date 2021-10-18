<?php

namespace App\Controller\SPA;

use App\Entity\Affectation;
use App\Entity\Corps;
use App\Entity\Militaire;
use App\Entity\MilitaireSpa;
use App\Entity\MilitaireStatut;
use App\Entity\Spa;
use App\Entity\Unite;
use App\Service\AffectationGetter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use function Symfony\Component\Translation\t;

#[Route('/spa/unite')]
class SpaController extends AbstractController
{

    private $affectationGetter;

    public function __construct(AffectationGetter $affectationGetter)
    {
        $this->affectationGetter = $affectationGetter;
    }

    #[Route('/c/', name: 'spa_create')]
    public function index(): Response
    {


        if ($this->getUser()->getMilitaire() != null){

            $militaire = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find($this->getUser()->getMilitaire()->getId());
            $corps = $this->getDoctrine()->getManager()->getRepository(Corps::class)->findOneBy([
                'chefCorps' => $militaire
            ]);
            if ($corps != null){
                $unites = $corps->getUnites();
                $spas =  $this->getDoctrine()->getManager()->getRepository(Spa::class)->findSpaByCorps($unites);
            }

        }else{
            $unites = [];
            $militaire = null;
            $spas = [];
        }



        return $this->render('spa/spa/index.html.twig', [
            'active' => 'spa_create',
            'unites' => $unites,
            'spas' => $spas,
            'militaire' => $militaire
        ]);
    }


    #[Route('/', name: 'all_spa')]
    public function allSpa(): Response
    {


        if ($this->getUser()->getMilitaire() != null){

            $militaire = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find($this->getUser()->getMilitaire()->getId());
            $corps = $this->getDoctrine()->getManager()->getRepository(Corps::class)->findOneBy([
                'chefCorps' => $militaire
            ]);
            if ($corps != null){
                $unites = $corps->getUnites();
                $spas =  $this->getDoctrine()->getManager()->getRepository(Spa::class)->findSpaByCorps($unites);
            }

        }else{
            $unites = [];
            $militaire = null;
            $spas = [];
        }



        return $this->render('spa/spa/all.html.twig', [
            'active' => 'spa_create',
            'unites' => $unites,
            'spas' => $spas,
            'militaire' => $militaire
        ]);
    }



   /* #[Route('/{id}', name: 'spa_unite_create')]
    public function create(Unite $unite): Response
    {


        $spas =  $this->getDoctrine()->getManager()->getRepository(Spa::class)->findBy([
           'unite' => $unite
        ],
        [
            'createdAt' => 'DESC'
        ]);

        $militaires = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->findMilitairesFromUnites($unite);


        return $this->render('spa/spa/create.html.twig', [
            'active' => 'spa_create',
            'unite' => $unite,
            'spas' => $spas,
            'militaires' => $militaires,
        ]);


    }*/


    #[Route('/create-spa/{id}/{date}', name: 'spa_unite_create')]
    public function creerSpa(Unite $unite, $date): Response
    {

        $dateObject = new \DateTime($date);

        $spas = $this->getDoctrine()->getManager()->getRepository(Spa::class)->findBy([
            'dateSpa' => $dateObject,
            'unite' => $unite
        ]);

        if ($dateObject->getTimestamp() >  strtotime(date('Y-m-d'))){
            return $this->redirectToRoute('spa_create');
        }

        if ($spas != null){
            return $this->redirectToRoute('spa_create');
        }

        $militaires = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->findMilitairesFromUnites($unite);

        return $this->render('spa/spa/create.html.twig', [
            'active' => 'spa_create',
            'unite' => $unite,
            'date' => $dateObject,
            'militaires' => $militaires,
        ]);


    }



    #[Route('/xhr-cd/{date}/{unite_id}', name: 'check_spa_date')]
    public function checkSpaDate($date,$unite_id): Response
    {

        $found = true;
        $isOutDated = false;

        $dateObject = new \DateTime($date);

        $isNextDate = false;

        if ($dateObject->getTimestamp() !=  strtotime(date('Y-m-d'))) {
            $isOutDated = true;
        }
        if ($dateObject->getTimestamp() >  strtotime(date('Y-m-d'))){
            $isNextDate = true;
        }

        $unite = $this->getDoctrine()->getManager()->getRepository(Unite::class)->find($unite_id);


        if ($unite == null){
            $found = true;
        }else{
            $spas = $this->getDoctrine()->getManager()->getRepository(Spa::class)->findBy([
                'dateSpa' => $dateObject,
                'unite' => $unite
            ]);
            if ($spas == null){
                $found = false;
            }else{
                $found = true;
            }
        }



        return new JsonResponse([
            'found' => $found,
            'isOutDated' => $isOutDated,
            'time' => $dateObject->getTimestamp(),
            'today' => strtotime($date),
            'date' => $date,
            'spa' => $spas,
            'unite' => $unite,
            'isNextDate' => $isNextDate,
        ]);

    }




    #[Route('/parse-spa/{unite}', name: 'spa_unite_parse')]
    public function parseSpa(Unite $unite, Request $request): Response
    {

        $json_data = $request->getContent();
        $data = json_decode($json_data,true);

        $militaireSpaRows = $data['data'];

        $date = $data['date'];

        $spa = new Spa();
        $spa->setCreatedBy($this->getUser()->getMilitaire());
        $spa->setUnite($unite);
        $spa->setCommentaire($data['commentaire']);
        $spa->setDateSpa(new \DateTime($date));

        $em = $this->getDoctrine()->getManager();
        $em->persist($spa);
        $em->flush();


        try {
            foreach ($militaireSpaRows as $row){

                $militaire = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find(intval($row['id']));

                if ($militaire != null){

                    $lastSpa = $this->getDoctrine()->getManager()->getRepository(MilitaireSpa::class)->findLastSpa($militaire);


                    $grade = $militaire->getGrade();

                    $grade_array = [];
                    $grade_array['id'] = $grade->getId();
                    $grade_array['intitule'] = $grade->getIntitule();
                    $grade_array['description'] = $grade->getDescription();
                    $grade_array['categorie'] = [];
                    $grade_array['categorie']['id'] = $grade->getGradeCategorie()->getId();
                    $grade_array['categorie']['intitule'] = $grade->getGradeCategorie()->getIntitule();

                    $militaireSpa = new MilitaireSpa();
                    $militaireSpa->setMilitaire($militaire);
                    $militaireSpa->setSpa($spa);
                    $militaireSpa->setStatut($row['statut']);
                    $militaireSpa->setCommentaire($row['commentaire']);
                    $militaireSpa->setSavedGrade($grade_array);
                    $em->persist($militaireSpa);
                    $em->flush();

                    // Verifier si la SPA sera ecraser par le statut de la chancellerie

                    if ($militaire->getStatut() == null || $lastSpa == null || $lastSpa->getSpa()->getDateSpa()->getTimestamp() >= $militaire->getStatut()->getDateDebut()->getTimestamp()) {

                        $militaireStatut = new MilitaireStatut();

                        $militaireStatut->setStatut(intval($row['statut']));

                        $militaireStatut->setCommentaire($row['commentaire']);

                        $militaireStatut->setDateDebut(new \DateTime($date));

                        $militaireStatut->setDefinedBy(MilitaireStatut::UPDATED_BY_CHEF_CORPS);

                        $militaire->setStatut($militaireStatut);

                        $em->flush();
                    }

                    $dateObj = new \DateTime($date);



                }


            }
        }catch (\Exception $exception){

            $em->remove($spa);
            $em->remove();

        }

        $request->getSession()->getFlashBag()->add('spa_create', "La SPA du ".$dateObj->format('d-m-Y')." de l'unite ".$unite->getIntitule(). " a ete cree avec succes");


        return new JsonResponse(1,200);

    }





    #[Route('/show-spa/{spa}', name: 'spa_show')]
    public function showSpa(Spa $spa): Response
    {



        return $this->render('spa/spa/show.html.twig', [
            'spa' => $spa,
            'active' => "spa_create",
        ]);


    }

}
