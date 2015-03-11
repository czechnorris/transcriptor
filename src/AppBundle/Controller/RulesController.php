<?php
/**
 * This file is part of the transcriptor project.
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Rule;
use AppBundle\Handler\RuleHandler;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;


/**
 * RulesController
 
 * @package AppBundle\Controller
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class RulesController extends FOSRestController {

    /**
     * @ApiDoc(
     *  resource = true,
     *  description = "Gets a Rule for a given id",
     *  output = "\AppBundle\Entity\Rule",
     *  statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the rule is not found"
     *  }
     * )
     * @Rest\View
     *
     * @param $id
     *
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
     * Get the RuleHandler
     *
     * @return RuleHandler
     */
    private function getRuleHandler() {
        return $this->container->get('api.rule.handler');
    }

}