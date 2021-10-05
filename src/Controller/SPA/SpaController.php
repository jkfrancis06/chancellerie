<?php

namespace App\Controller\SPA;

use App\Entity\Affectation;
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
use function Symfony\Component\Translation\t;

#[Route('/spa/unite')]
class SpaController extends AbstractController
{

    private $affectationGetter;

    public function __construct(AffectationGetter $affectationGetter)
    {
        $this->affectationGetter = $affectationGetter;
    }

    #[Route('/', name: 'spa_create')]
    public function index(): Response
    {


        if ($this->getUser()->getMilitaire() != null){
            $militaire = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find($this->getUser()->getMilitaire()->getId());
            $unites = $this->getDoctrine()->getManager()->getRepository(Unite::class)->findBy([
                'chefFormation' => $militaire
            ]);

            $spas =  $this->getDoctrine()->getManager()->getRepository(Spa::class)->findBy([
                'unite' => $unites
            ],
                [
                    'createdAt' => 'DESC'
                ]
            );

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



        if ($dateObject->getTimestamp() !=  strtotime(date('Y-m-d'))) {
            $isOutDated = true;
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




        foreach ($militaireSpaRows as $row){

            $militaire = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find(intval($row['id']));

            if ($militaire != null){

                $militaireSpa = new MilitaireSpa();
                $militaireSpa->setMilitaire($militaire);
                $militaireSpa->setSpa($spa);
                $militaireSpa->setCommentaire($row['commentaire']);
                $em->persist($militaireSpa);
                $em->flush();

                $militaireStatut = new MilitaireStatut();

                $militaireStatut->setMilitaire($militaire);

                $militaireStatut->setStatut(intval($row['statut']));

                $militaireStatut->setCommentaire($row['commentaire']);

                $militaireStatut->setDateDebut(new \DateTime($date));

                $em->persist($militaireStatut);
                $em->flush();

            }
        }

        return new JsonResponse(1,200);

    }
}
