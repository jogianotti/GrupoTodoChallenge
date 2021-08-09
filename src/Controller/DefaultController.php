<?php

namespace App\Controller;

use App\Application\Category\MenuMaker;
use App\Application\Product\AllProductsFinder;
use App\Application\Product\ProductFinder;
use App\Application\Product\ProductsByCategoryFinder;
use App\Repository\ProductCategoryRepositoryInterface;
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

    /**
     * @Route("/producto/{id}", name="producto_show", methods={"GET"})
     */
    public function show(
        int                                $id,
        ProductFinder                      $productFinder,
        ProductCategoryRepositoryInterface $productCategoryRepository
    ): Response
    {
        $product = $productFinder($id);
        $productCategory = $productCategoryRepository->oneByProduct($product);
        $category = $productCategory->getCategory();

        return $this->render('producto/show.html.twig', [
            'product' => $product,
            'path' => $category->getPath()
        ]);
    }
}
