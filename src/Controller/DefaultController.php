<?php

namespace App\Controller;

use App\Application\Category\MenuMaker;
use App\Application\Product\AllProductsFinder;
use App\Application\Product\ProductsByCategoryFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    /**
     * @Route(name="index")
     */
    public function index(
        Request                  $request,
        MenuMaker                $menuMaker,
        ProductsByCategoryFinder $productsByCategoryFinder,
        AllProductsFinder        $allProductsFinder
    ): Response
    {

        $menu = $menuMaker();

        $id = $request->query->get('id');
        $products = ($id) ? $productsByCategoryFinder($id) : $allProductsFinder();

        return $this->render('Default/index.html.twig', [
            'categories_menu' => $menu,
            'products' => $products
        ]);
    }
}
