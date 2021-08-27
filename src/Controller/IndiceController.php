<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Entity\GradeCategorie;
use App\Entity\Indice;
use App\Form\IndiceType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class IndiceController extends AbstractController
{
    /**
     * @Route("/indices", name="indices")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {

        $indice  = new Indice();

        $indiceForm = $this->createForm(IndiceType::class, $indice);

        $indiceForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($indiceForm->isSubmitted() && $indiceForm->isValid()){

            $em->persist($indice);
            $em->flush();
            $request->getSession()->getFlashBag()->add('indice_add', 'L\'indice a été crée avec succès');

        }



        $categories = $this->getDoctrine()->getManager()->getRepository(GradeCategorie::class)->findAll();

        $categories_array = [];

        if ($categories != null){
            foreach ($categories as $category){
                $item = [];
                $item["categorie"] = $category;
                $item["indices"] = [];
                $grades = $this->getDoctrine()->getManager()->getRepository(Grade::class)->findBy([
                    'gradeCategorie' => $category
                ]);

                $indices = $this->getDoctrine()->getManager()->getRepository(Indice::class)->findAll();

                if ($indices != null){
                    $item["indices"] = $indices;
                }
            }
        }

        $db_indices_page = $paginator->paginate(
            $indices,
            $request->query->getInt('page_com_db_indice', 1)/*page number*/,
            10/*limit per page*/,
            ['pageParameterName' => 'page_com_db_indice']
        );


        return $this->render('indice/index.html.twig', [
            'controller_name' => 'IndiceController',
            'active' => 'indices',
            'indices' => $db_indices_page,
            'indiceForm' => $indiceForm->createView(),
        ]);
    }


    /**
     * @Route("/indice-edit/{id}", name="editIndice")
     */
    public function edit($id,Request $request): Response
    {

        $indice  = $this->getDoctrine()->getManager()->getRepository(Indice::class)->find($id);

        if ($indice == null){
            throw new NotFoundHttpException('non trouve');
        }

        $indiceForm = $this->createForm(IndiceType::class, $indice);

        $indiceForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($indiceForm->isSubmitted() && $indiceForm->isValid()){
            $em->flush();
            $request->getSession()->getFlashBag()->add('indice_add', 'L\'indice a été modifie avec succès');
            return $this->redirectToRoute('indices');
        }

        return $this->render('indice/edit.html.twig', [
            'controller_name' => 'IndiceController',
            'active' => 'indices',
            'indiceForm' => $indiceForm->createView(),
        ]);

    }


    /**
     * @Route("/indice-remove/{id}", name="removeIndice")
     */
    public function remove($id,Request $request): Response
    {

        $indice  = $this->getDoctrine()->getManager()->getRepository(Indice::class)->find($id);

        if ($indice == null){
            throw new NotFoundHttpException('non trouve');
        }


        $em = $this->getDoctrine()->getManager();

        $em->remove($indice);
        $em->flush();

        $request->getSession()->getFlashBag()->add('indice_add', 'L\'indice a été supprime avec succès');

        return $this->redirectToRoute('indices');


    }
}
