<?php
/**
 * This file is part of the transcriptor project.
 */

namespace RestBundle\Controller;
use RestBundle\Entity\Rule;
use RestBundle\Form\RuleType;
use RestBundle\Handler\RuleHandler;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;


/**
 * RulesController
 
 * @package RestBundle\Controller
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class RulesController extends FOSRestController {

    /**
     * Get rules matching the given parameters
     *
     * @Rest\View()
     *
     * @param Request $request Request
     * @return array
     */
    public function getRulesAction(Request $request) {
        $searchParams = $this->getSearchParameters($request);
        $rules = $this->getRuleHandler()->search($searchParams);
        return ['rules' => $rules];
    }

    /**
     * Get rule with the given id
     *
     * @Rest\View
     *
     * @param $id
     * @return array
     *
     * @throws NotFoundHttpException when rule does not exist
     */
    public function getRuleAction($id) {
        $rule = $this->getRuleHandler()->get($id);
        if (!$rule instanceof Rule) {
            throw new NotFoundHttpException();
        }
        return ['rule' => $rule];
    }

    /**
     * Create new rule
     *
     * @Rest\View
     *
     * @param Request $request Request
     * @return View|Response
     */
    public function postRuleAction(Request $request) {
        return $this->processForm(new Rule(), $request);
    }

    /**
     * Update rule with the given id
     *
     * @Rest\View
     *
     * @param Request $request Request
     * @param int     $id      Rule id
     * @return View|Response
     */
    public function putRuleAction(Request $request, $id) {
        $rule = $this->getRuleHandler()->get($id);
        return $this->processForm($rule, $request);
    }

    /**
     * Delete rule with the given id
     *
     * @Rest\View(statusCode = 204)
     *
     * @param $id
     * @return View
     */
    public function deleteRuleAction($id) {
        $this->getRuleHandler()->remove($id);
    }

    /**
     * Get the RuleHandler
     *
     * @return RuleHandler
     */
    private function getRuleHandler() {
        return $this->container->get('api.rule.handler');
    }

    /**
     * Validate and persist entity using form
     *
     * @param Rule    $rule    Rule object
     * @param Request $request Request
     * @return View|Response
     */
    private function processForm(Rule $rule, Request $request) {
        $statusCode = $rule->getId() ? 204 : 201;

        $form = $this->createForm(new RuleType(), $rule);
        $form->submit($request->get('rule'));
        if ($form->isValid()) {
            $rule = $this->getRuleHandler()->update($form->getData());

            $response = new Response();
            $response->setStatusCode($statusCode);
            if ($statusCode == 201) {
                $response->headers->set('Location',
                    $this->generateUrl('api_1_get_rule', ['id' => $rule->getId()], true)
                );
            }

            return $response;
        }

        return View::create($form, 400);
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
            array_flip(RuleHandler::$allowedSearchParams)
        );
    }

}