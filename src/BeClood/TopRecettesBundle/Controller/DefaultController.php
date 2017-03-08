<?php

namespace BeClood\TopRecettesBundle\Controller;

use BeClood\TopRecettesBundle\Entity\FormulaireContact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $manager = $this->get('beclood_top_recettes.formulairecontact_manager');
        $formContact = new FormulaireContact();
        $formContact
            ->setDateNaissance((new \DateTime())->sub(new \DateInterval("P20Y")))
            ->setEmail($request->query->get("email", "francois.mathieu@beclood.com"))
            ->setNom($request->query->get("nom", "Mathieu"))
            ->setPrenom($request->query->get("prenom", "François"))
            ->setMessage($request->query->get("message", "Bienvenue"));

        $manager->saveFormulaireContact($formContact);
        $contacts = array_reverse($manager->getRepository()->findAll());

        return $this->render('BeCloodTopRecettesBundle:Default:index.html.twig', ['contacts' => $contacts]);
    }
}
