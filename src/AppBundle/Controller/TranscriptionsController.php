<?php
/**
 * This file is part of the transcriptor project.
 */

namespace AppBundle\Controller;
use AppBundle\Transcription\TranscriptorFactory;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use JMS\Serializer\Exception\ValidationFailedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Class TranscriptionsController
 
 * @package AppBundle\Controller
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class TranscriptionsController extends FOSRestController {

    private static $mandatoryParameters = [
        'sourceLanguage',
        'targetLanguage',
        'text'
    ];

    /**
     * Get transcription for text
     *
     * @Rest\View
     *
     * @param Request $request
     * @return array
     */
    public function getTranscriptionAction(Request $request) {
        try {
            list($sourceLanguage, $targetLanguage, $text) = $this->getParameters($request);
            $transcriptor = $this->getTranscriptorFactory()->getInstance($request->get('method', null));
            $transcriptions = $transcriptor->transcript($text, $sourceLanguage, $targetLanguage);
            return ['transcriptions' => $transcriptions];
        } catch (ValidationFailedException $e) {
            return View::create(['errors' => $e->getConstraintViolationList()], 400);
        }
    }

    /**
     * Get parameters from the request
     *
     * @param Request $request
     * @return array
     * @throws ValidationFailedException
     */
    private function getParameters(Request $request) {
        $this->validateRequest($request);
        return [
            $request->query->get('sourceLanguage'),
            $request->query->get('targetLanguage'),
            $request->query->get('text')
        ];
    }

    /**
     * Validate the transcription request
     *
     * @param Request $request
     * @throws ValidationFailedException
     */
    private function validateRequest(Request $request) {
        $violations = [];
        foreach (self::$mandatoryParameters as $parameterName) {
            if (!$request->query->get($parameterName, false)) {
                $message = 'Missing mandatory parameter "' . $parameterName . '"';
                $violations[] = new ConstraintViolation($message, $message, [], '', $parameterName, null);
            }
        }
        if (!empty($violations)) {
            throw new ValidationFailedException(new ConstraintViolationList($violations));
        }
    }

    /**
     * Get the transcriptor factory
     *
     * @return TranscriptorFactory
     */
    private function getTranscriptorFactory() {
        return $this->container->get('api.transcription.factory');
    }

}