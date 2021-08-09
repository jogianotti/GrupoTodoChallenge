<?php

namespace App\Controller;

use App\Application\Product\AllProductsFinder;
use App\Application\Product\ProductCreator;
use App\Application\Product\ProductFinder;
use App\Application\Product\ProductRemover;
use App\Application\Product\ProductUpdater;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/producto")
 */
class ProductoController extends AbstractController
{
    /**
     * @Route("/", name="producto")
     */
    public function index(AllProductsFinder $allProductsFinder): Response
    {
        $products = $allProductsFinder();

        return $this->render('producto/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/new", name="producto_new", methods={"GET","POST"})
     */
    public function new(Request $request, ProductCreator $productCreator): Response
    {
        $product = $request->request->get('product');

        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productCreator(
                $product['name'],
                $product['description'] ?? null,
                $product['category']
            );

            return $this->redirectToRoute('producto', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('producto/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="producto_edit", methods={"GET","POST"})
     */
    public function edit(
        Request        $request,
        ProductFinder  $productFinder,
        ProductUpdater $productUpdater,
        int            $id
    ): Response
    {
        $product = $productFinder($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $request->request->get('product');

            $name = $product['name'];
            $description = $product['description'] ?? null;
            $category = $product['category'];

            $productUpdater($id, $name, $description, $category);

            return $this->redirectToRoute('producto', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('producto/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="producto_delete", methods={"POST"})
     */
    public function delete(Request $request, ProductRemover $productRemover, int $id): Response
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $productRemover($id);
        }

        return $this->redirectToRoute('producto', [], Response::HTTP_SEE_OTHER);
    }
}
