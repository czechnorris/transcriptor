<?php
/**
 * This file is part of the transcriptor project.
 */

namespace AppBundle\Handler;
use AppBundle\Entity\Rule;
use Doctrine\Common\Persistence\ObjectManager;


/**
 * Class RuleHandler
 
 * @package AppBundle\Handler
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class RuleHandler {

    /**
     * The constructor
     *
     * @param ObjectManager $om          Object manager
     * @param string        $entityClass Entity class
     */
    public function __construct(ObjectManager $om, $entityClass) {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
    }

    /**
     * Get rule with the given id
     *
     * @param int $id Rule identifier
     *
     * @return Rule
     */
    public function get($id) {
        return $this->repository->find($id);
    }

}