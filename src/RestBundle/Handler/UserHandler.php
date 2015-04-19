<?php
/**
 * This file is part of the transcriptor project.
 */

namespace RestBundle\Handler;
use RestBundle\Entity\Rule;
use Doctrine\Common\Persistence\ObjectManager;
use RestBundle\Entity\User;


/**
 * Class UserHandler
 
 * @package RestBundle\Handler
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class UserHandler {

    public static $allowedSearchParams = [
        'username',
        'email',
    ];

    /** @var \Doctrine\ORM\EntityRepository */
    private $repository;

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
     * Get users by the given parameters
     *
     * @param array $parameters Search parameters
     * @return User[]
     */
    public function search($parameters = []) {
        return $this->repository->findBy($parameters);
    }

    /**
     * Get user with the given id
     *
     * @param int $id User identifier
     *
     * @return User
     */
    public function get($id) {
        return $this->repository->find($id);
    }

    /**
     * Update or create the given user
     * Returns the persisted object
     *
     * @param User $user Rule
     *
     * @return User
     */
    public function update(User $user) {
        if (!$user->getId()) {
            $this->om->persist($user);
        } else {
            $this->om->merge($user);
        }
        $this->om->flush();

        return $user;
    }

    /**
     * Delete user with the given id
     * No operation is done if the user does not exist
     *
     * @param $id
     * @return void
     */
    public function remove($id) {
        $user = $this->repository->find($id);
        if ($user) {
            $this->om->remove($user);
            $this->om->flush();
        }
    }

}