<?php
/**
 * This file is part of the transcriptor project.
 */

namespace RestBundle\Handler;
use RestBundle\Entity\Change;
use RestBundle\Entity\Rule;
use Doctrine\Common\Persistence\ObjectManager;
use RestBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


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

    /** @var \Doctrine\ORM\EntityRepository */
    private $repository;

    /** @var  TokenStorage */
    private $tokenStorage;

    /**
     * The constructor
     *
     * @param ObjectManager $om          Object manager
     * @param string        $entityClass Entity class
     */
    public function __construct(ObjectManager $om, $entityClass, $tokenStorage) {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->tokenStorage = $tokenStorage;
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
     * @param Rule   $rule    Rule
     * @param string $comment Change comment
     *
     * @return Rule
     */
    public function update(Rule $rule, $comment) {
        $this->createChangeLog($rule->getId(), $rule, $comment);
        if (!$rule->getId()) {
            $this->om->persist($rule);
        } else {
            $this->om->merge($rule);
            $this->om->persist($rule);
        }
        $this->om->flush();

        return $rule;
    }

    /**
     * Delete rule with the given id
     * No operation is done if the rule does not exist
     *
     * @param int    $id      Identifier of the rule to remove
     * @param string $comment Change comment
     */
    public function remove($id, $comment) {
        $rule = $this->repository->find($id);
        if ($rule) {
            $this->om->remove($rule);
            $this->createChangeLog($id, null, $comment);
            $this->om->flush();
        }
    }

    /**
     * Get all possible languages
     *
     * @return array
     */
    public function getLanguages() {
        $query = $this->repository->createQueryBuilder('rule')->select('rule.sourceLanguage')->distinct(true)->getQuery();
        $languages = $query->execute();
        return array_map(function($row) {
            return $row['sourceLanguage'];
        }, $languages);
    }

    /**
     * Create change log for the update
     *
     * @param int    $oldId   Id of the old rule or null for creation
     * @param Rule   $rule    Updated rule or null for deletion
     * @param string $comment Change comment
     */
    private function createChangeLog($oldId, Rule $rule = null, $comment) {
        $this->om->detach($rule);
        $oldRule = $oldId ? $this->get($oldId) : null;
        $change = new Change();
        $change->setComment($comment);
        $change->setCreatedOn(new \DateTime());
        $change->setOriginalPattern($oldRule ? $oldRule->getPattern() : null);
        $change->setOriginalReplacement($oldRule ? $oldRule->getReplacement() : null);
        $change->setNewPattern($rule ? $rule->getPattern() : null);
        $change->setNewReplacement($rule ? $rule->getReplacement() : null);
        $change->setRule($rule ? $rule : $oldRule);
        $change->setUser($this->getUser());
        $this->om->persist($change);
    }

    /**
     * Get the current user
     *
     * @return User
     */
    private function getUser() {
        $user = $this->tokenStorage->getToken()->getUser();
        $this->om->refresh($user);
        return $user;
    }

}