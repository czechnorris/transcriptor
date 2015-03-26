<?php
/**
 * This file is part of the transcriptor project.
 */

namespace AppBundle\Transcription;
use AppBundle\Handler\RuleHandler;


/**
 * Class SimpleTranscriptor
 
 * @package AppBundle\Transcription
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class SimpleTranscriptor extends TokenizingTranscriptor {

    /** @var RuleHandler */
    private $ruleHandler;

    /**
     * The constructor.
     *
     * @param \AppBundle\Handler\RuleHandler $ruleHandler
     */
    public function __construct(RuleHandler $ruleHandler) {
        $this->ruleHandler = $ruleHandler;
    }

    /**
     * Transcript the given text from source to target language.
     * Returns an array of possible transcriptions.
     *
     * @param string $text Text to transcript
     * @param string $sourceLanguage Source language
     * @param string $targetLanguage Target language
     * @return array
     */
    public function doTranscript($text, $sourceLanguage, $targetLanguage) {
        $rulesToIpa = $this->ruleHandler->search([
            'sourceLanguage' => $sourceLanguage,
            'targetLanguage' => 'ipa'
        ]);
        $result = '';
        foreach ($this->tokenize($text) as $token) {
            foreach ($rulesToIpa as $rule) {
                $token = $rule->apply($token);
            }
            $result .= $token;
        }
        return [$result];
    }

}