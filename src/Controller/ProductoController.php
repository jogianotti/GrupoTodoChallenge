<?php

namespace App\Controller;

use App\Application\Product\AllProductsFinder;
use App\Application\Product\ProductCreator;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/producto")
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
}
