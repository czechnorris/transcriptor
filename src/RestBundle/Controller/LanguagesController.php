<?php
/**
 * This file is part of the transcriptor project.
 */

namespace RestBundle\Controller;
use RestBundle\Handler\RuleHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class LanguagesController
 
 * @package RestBundle\Controller
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class LanguagesController extends FOSRestController {

    /**
     * Get languages for text
     *
     * @Rest\View
     *
     * @return array
     */
    public function getLanguagesAction() {
        $languages = $this->getRuleHandler()->getLanguages();
        return ['languages' => array_map(function($language) {
            return [
                'code' => $language,
                'name' => mb_strtolower(\Locale::getDisplayLanguage($language, $language))
            ];
        }, $languages)];
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