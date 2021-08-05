<?php

namespace App\Controller;

use App\Application\Category\AllCategoriesFinder;
use App\Application\Category\CategoryCreator;
use App\Application\Category\CategoryFinder;
use App\Application\Category\CategoryRemover;
use App\Application\Category\CategoryUpdater;
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
    public function index(AllCategoriesFinder $allCategoriesFinder): Response
    {
        $categories = $allCategoriesFinder();

        return $this->render('categoria/index.html.twig', [
            'categories' => $categories,
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

    /**
     * @Route("/{id}/edit", name="categoria_edit", methods={"GET","POST"})
     */
    public function edit(
        Request         $request,
        CategoryFinder  $categoryFinder,
        CategoryUpdater $categoryUpdater,
        int             $id
    ): Response
    {
        $category = $categoryFinder($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $request->request->get('category');

            $name = $category['name'];
            $description = $category['description'] ?? null;
            $parent = !empty($category['parent']) ? $category['parent'] : null;

            $categoryUpdater($id, $name, $description, $parent);

            return $this->redirectToRoute('categoria', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categoria/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categoria_delete", methods={"POST"})
     */
    public function delete(Request $request, CategoryRemover $categoryRemover, int $id): Response
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $categoryRemover($id);
        }

        return $this->redirectToRoute('categoria', [], Response::HTTP_SEE_OTHER);
    }
}
