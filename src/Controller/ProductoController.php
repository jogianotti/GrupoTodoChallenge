<?php

namespace App\Controller;

use App\Application\Product\AllProductsFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductoController extends AbstractController
{
    /**
     * @Route("/producto", name="producto")
     */
    public function index(AllProductsFinder $allProductsFinder): Response
    {
        $products = $allProductsFinder();

        return $this->render('producto/index.html.twig', [
            'products' => $products,
        ]);
    }
}
