<?php

namespace App\Controller;

use App\Application\Category\CategoryCreator;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categoria")
 */
class CategoriaController extends AbstractController
{
    /**
     * @Route("/", name="categoria")
     */
    public function index(): Response
    {
        return $this->render('categoria/index.html.twig', [
            'controller_name' => 'CategoriaController',
        ]);
    }

    /**
     * @Route("/new", name="categoria_new", methods={"GET","POST"})
     */
    public function new(Request $request, CategoryCreator $categoryCreator): Response
    {
        $category = $request->request->get('category');

        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $categoryCreator(
                $category['name'],
                $category['description'],
                !empty($category['parent']) ? $category['parent'] : null
            );

            return $this->redirectToRoute('categoria', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categoria/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
