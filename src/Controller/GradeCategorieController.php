<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Grade;
use App\Entity\GradeCategorie;
use App\Form\CategorieType;
use App\Form\GradeType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GradeCategorieController extends AbstractController
{
    /**
     * @Route("/grade/categorie", name="grade_categorie")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $user = $this->getUser();

        $grade = new Grade();
        $gradeCategories = new GradeCategorie();

        $gradeForm = $this->createForm(GradeType::class,$grade);
        $gradeCategoriesForm = $this->createForm(CategorieType::class,$gradeCategories);

        $gradeForm->handleRequest($request);
        $gradeCategoriesForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($gradeForm->isSubmitted() && $gradeForm->isValid()) { // traitement du formulaire
            $em->persist($grade);
            $em->flush();
            $request->getSession()->getFlashBag()->add('grade_add', 'Le grade a été crée avec succès');
            return $this->redirectToRoute('grade_categorie');
        }

        if ($gradeCategoriesForm->isSubmitted() && $gradeCategoriesForm->isValid()) { // traitement du formulaire
            $em->persist($gradeCategories);
            $em->flush();
            $request->getSession()->getFlashBag()->add('categorie_add', 'La categorie a été crée avec succès');
            return $this->redirectToRoute('grade_categorie');

        }

        $grades = $this->getDoctrine()->getManager()->getRepository(Grade::class)->findAll();
        $gradesCategories = $this->getDoctrine()->getManager()->getRepository(GradeCategorie::class)->findAll();

        $db_grade_page = $paginator->paginate(
            $grades,
            $request->query->getInt('page_com_db_grade', 1)/*page number*/,
            10/*limit per page*/,
            ['pageParameterName' => 'page_com_db_grade']
        );

        return $this->render('grade_categorie/index.html.twig', [
            'controller_name' => 'GradeCategorieController',
            'active' => 'grade_categorie',
            'user' => $user,
            'grades' => $db_grade_page,
            'gradesCategories' => $gradesCategories,
            'gradeForm' => $gradeForm->createView(),
            'gradeCategoriesForm' => $gradeCategoriesForm->createView(),
        ]);
    }
}
