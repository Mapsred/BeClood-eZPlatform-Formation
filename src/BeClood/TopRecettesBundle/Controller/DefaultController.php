<?php

namespace BeClood\TopRecettesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BeCloodTopRecettesBundle:Default:index.html.twig');
    }
}
