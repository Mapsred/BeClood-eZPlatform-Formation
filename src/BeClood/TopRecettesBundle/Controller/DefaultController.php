<?php

namespace BeClood\TopRecettesBundle\Controller;

use BeClood\TopRecettesBundle\Entity\FormulaireContact;
use BeClood\TopRecettesBundle\Form\FormulaireContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        if ($request->query->has('save') && $request->query->get('save') == "true") {
            $formContact = new FormulaireContact();
            $formContact
                ->setDateNaissance((new \DateTime())->sub(new \DateInterval("P20Y")))
                ->setEmail($request->query->get("email", "francois.mathieu@beclood.com"))
                ->setNom($request->query->get("nom", "Mathieu"))
                ->setPrenom($request->query->get("prenom", "François"))
                ->setMessage($request->query->get("message", "Bienvenue"));

                $manager->saveFormulaireContact($formContact);
        }
        $contacts = $manager->getRepository()->findBy([], ['createdAt' => 'DESC']);

        return $this->render('BeCloodTopRecettesBundle:Default:index.html.twig', ['contacts' => $contacts]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function contactAction(Request $request)
    {
        $formContact = new FormulaireContact();
        $form = $this->createForm(FormulaireContactType::class, $formContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->get('beclood_top_recettes.formulairecontact_manager');
            $manager->saveFormulaireContact($formContact);

            $this->addFlash("success", sprintf("Hello %s", $formContact->getPrenom()));

            return $this->redirectToRoute('beclood_top_recettes_homepage');
        }

        return $this->render('BeCloodTopRecettesBundle:Default:contact.html.twig', ['form' => $form->createView()]);
    }

    public function alertAction()
    {
        return $this->render("BeCloodTopRecettesBundle:Default:alert.html.twig");
    }
}
