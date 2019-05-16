<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class RootController extends AbstractController
{
    /**
     * @Route ("/", name = "home", methods = {"GET"})
     */
    public function getHome (Request $request){
        return $this->render('home/home.html.twig');
    }
}