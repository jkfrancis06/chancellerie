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


#[Route('/ch')]
class GradeCategorieController extends AbstractController
{
    /**
     * @Route("/grade/categorie/{id}", name="grade_categorie")
     */
    public function index(Request $request, PaginatorInterface $paginator,$id = null): Response
    {
        $user = $this->getUser();
        $db_grade = null;

        if ($id == null){
            $grade = new Grade();
        }else{
            $db_grade = $this->getDoctrine()->getManager()->getRepository(Grade::class)->find($id);
            if ($db_grade == null){
                $grade = new Grade();
            }else{
                $grade = $db_grade;
            }
        }
        $gradeCategories = new GradeCategorie();

        $gradeForm = $this->createForm(GradeType::class,$grade);
        $gradeCategoriesForm = $this->createForm(CategorieType::class,$gradeCategories);

        $gradeForm->handleRequest($request);
        $gradeCategoriesForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($gradeForm->isSubmitted() && $gradeForm->isValid()) { // traitement du formulaire
            if ($db_grade != null){
                $em->flush();
                $request->getSession()->getFlashBag()->add('grade_add', 'Le grade a été modifie avec succès');

            }else{
                $em->persist($grade);
                $em->flush();
                $request->getSession()->getFlashBag()->add('grade_add', 'Le grade a été crée avec succès');

            }
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



        return $this->render('grade_categorie/index.html.twig', [
            'controller_name' => 'GradeCategorieController',
            'active' => 'grade_categorie',
            'user' => $user,
            'grades' => $grades,
            'gradesCategories' => $gradesCategories,
            'gradeForm' => $gradeForm->createView(),
            'gradeCategoriesForm' => $gradeCategoriesForm->createView(),
        ]);
    }
}
