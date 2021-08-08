<?php

namespace App\Controller;

use App\Application\Category\MenuMaker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    /**
     * @Route(name="index")
     */
    public function index(Request $request, MenuMaker $menuMaker): Response
    {
        $menu = $menuMaker();

        return $this->render('Default/index.html.twig', [
            'categories_menu' => $menu,
        ]);
    }
}
