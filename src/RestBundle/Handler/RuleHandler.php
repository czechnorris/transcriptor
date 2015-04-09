<?php
/**
 * This file is part of the transcriptor project.
 */

namespace RestBundle\Handler;
use RestBundle\Entity\Rule;
use Doctrine\Common\Persistence\ObjectManager;


/**
 * Class RuleHandler
 
 * @package RestBundle\Handler
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class RuleHandler {

    public static $allowedSearchParams = [
        'id',
        'sourceLanguage',
        'targetLanguage',
        'pattern',
        'replacement'
    ];

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
     * Get rules by the given parameters
     *
     * @param array $parameters Search parameters
     * @return Rule[]
     */
    public function search($parameters = []) {
        return $this->repository->findBy($parameters);
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

    /**
     * Update or create the given rule
     * Returns the persisted object
     *
     * @param Rule $rule Rule
     *
     * @return Rule
     */
    public function update(Rule $rule) {
        if (!$rule->getId()) {
            $this->om->persist($rule);
        } else {
            $this->om->merge($rule);
        }
        $this->om->flush();

        return $rule;
    }

    /**
     * Delete rule with the given id
     * No operation is done if the rule does not exist
     *
     * @param $id
     * @return void
     */
    public function remove($id) {
        $rule = $this->repository->find($id);
        if ($rule) {
            $this->om->remove($rule);
            $this->om->flush();
        }
    }

}