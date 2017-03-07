<?php

namespace BeClood\TopRecettesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class OperationsMathematiquesController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @param $first
     * @param $second
     * @return Response
     */
    public function additionAction($first, $second)
    {
        $params = ["first" => $first, "second" => $second, "result" => $first + $second];

        return $this->render("BeCloodTopRecettesBundle:Default:addition.html.twig", $params);
    }

    /**
     * @param $first
     * @param $second
     * @return Response
     */
    public function multiplicationAction($first, $second)
    {
        $params = ["first" => $first, "second" => $second, "result" => $first * $second];

        return $this->render("BeCloodTopRecettesBundle:Default:addition.html.twig", $params);
    }
}
