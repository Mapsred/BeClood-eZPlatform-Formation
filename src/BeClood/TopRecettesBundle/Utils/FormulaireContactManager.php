<?php
/**
 * Created by PhpStorm.
 * User: francois
 * Date: 08/03/17
 * Time: 10:06
 */

namespace BeClood\TopRecettesBundle\Utils;


use BeClood\TopRecettesBundle\Entity\FormulaireContact;
use BeClood\TopRecettesBundle\Repository\FormulaireContactRepository;
use Doctrine\ORM\EntityManager;

class FormulaireContactManager
{
    /** @var EntityManager $em */
    private $em;

    /**
     * FormulaireContactManager constructor.
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->em = $manager;
    }

    /**
     * @return EntityManager
     */
    public function getManager()
    {
        return $this->em;
    }

    /**
     * @param $entity
     */
    protected function persistAndFlush($entity)
    {
        $this->getManager()->persist($entity);
        $this->getManager()->flush();
    }

    /**
     * @param $id
     * @return FormulaireContact|null|object
     */
    public function loadFormulaireContact($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @param FormulaireContact $formulaireContact
     */
    public function saveFormulaireContact(FormulaireContact $formulaireContact)
    {
        $this->persistAndFlush($formulaireContact);
    }

    /**
     * @return FormulaireContactRepository
     */
    public function getRepository()
    {
        return $this->getManager()->getRepository("BeCloodTopRecettesBundle:FormulaireContact");
    }
}