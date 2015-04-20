<?php
/**
 * This file is part of the transcriptor project.
 */

namespace RestBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RestBundle\Entity\User;
use RestBundle\Form\UserType;
use RestBundle\Handler\UserHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;


/**
 * Class UsersController
 
 * @package RestBundle\Controller
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class UsersController extends FOSRestController {

    /**
     * Get users matching the given parameters
     *
     * @Rest\View()
     * @Security("is_authenticated()")
     *
     * @param Request $request Request
     * @return array
     */
    public function getUsersAction(Request $request) {
        $searchParams = $this->getSearchParameters($request);
        $users = $this->getUserHandler()->search($searchParams);
        return ['users' => $users];
    }

    /**
     * Get user with the given id
     *
     * @Rest\View
     * @Security("is_authenticated")
     *
     * @param $id
     * @return array
     *
     * @throws NotFoundHttpException when rule does not exist
     */
    public function getUserAction($id) {
        $user = $this->getUserHandler()->get($id);
        if (!$user instanceof User) {
            throw new NotFoundHttpException();
        }
        return ['user' => $user];
    }

    /**
     * Create new user
     *
     * @Rest\View
     *
     * @param Request $request Request
     * @return View|Response
     */
    public function postUserAction(Request $request) {
        return $this->processForm(new User(), $request);
    }

    /**
     * Update user with the given id
     *
     * @Rest\View
     * @Security("is_authenticated() && request.get('id') == user.getId()")
     *
     * @param Request $request Request
     * @param int     $id      Rule id
     * @return View|Response
     */
    public function putUserAction(Request $request, $id) {
        $user = $this->getUserHandler()->get($id);
        return $this->processForm($user, $request);
    }

    /**
     * Validate and persist entity using form
     *
     * @param User    $user    Rule object
     * @param Request $request Request
     * @return View|Response
     */
    private function processForm(User $user, Request $request) {
        $statusCode = $user->getId() ? 204 : 201;

        $form = $this->createForm(new UserType(), $user);
        $form->submit($request->get('user'));
        if ($form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            /** @var UserPasswordEncoder $encoder */
            $encoder = $this->container->get('security.password_encoder');
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $user = $this->getUserHandler()->update($user);

            $response = new Response();
            $response->setStatusCode($statusCode);
            if ($statusCode == 201) {
                $response->headers->set('Location',
                    $this->generateUrl('api_1_get_user', ['id' => $user->getId()], true)
                );
            }

            return $response;
        }

        return View::create($form, 400);
    }

    /**
     * Get the UserHandler
     *
     * @return UserHandler
     */
    private function getUserHandler() {
        return $this->container->get('api.user.handler');
    }

    /**
     * Get search parameters from the request
     *
     * @param Request $request Request
     * @return array
     */
    private function getSearchParameters(Request $request) {
        return array_intersect_key(
            $request->query->all(),
            array_flip(UserHandler::$allowedSearchParams)
        );
    }

}