<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 
class MainpageController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:Mainpage:index.html.twig'); 
    }
}

