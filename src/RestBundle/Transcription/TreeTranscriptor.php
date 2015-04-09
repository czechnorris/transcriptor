<?php
/**
 * This file is part of the transcriptor project.
 */

namespace RestBundle\Transcription;
use RestBundle\Handler\RuleHandler;
use RestBundle\Transcription\TreeTranscriptor\Tree;

/**
 * Class TreeTranscriptor

 * @package RestBundle\Transcription
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class TreeTranscriptor extends TokenizingTranscriptor {

    /** @var RuleHandler */
    private $ruleHandler;

    /** @var  array */
    private $trees = [];

    /**
     * The constructor.
     *
     * @param \RestBundle\Handler\RuleHandler $ruleHandler
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
        $tree = $this->getTree($sourceLanguage, $targetLanguage);
        $result = '';
        foreach ($this->tokenize($text) as $token) {
            $result .= $tree->transcript($token);
        }
        return [$result];
    }

    /**
     * Get tree for the given languages
     *
     * @param string $sourceLanguage Source language
     * @param string $targetLanguage Target language
     *
     * @return Tree
     */
    private function getTree($sourceLanguage, $targetLanguage) {
        if (!isset($this->trees[$sourceLanguage][$targetLanguage])) {
            $this->trees[$sourceLanguage][$targetLanguage] = $this->buildTree($sourceLanguage, $targetLanguage);
        }
        return $this->trees[$sourceLanguage][$targetLanguage];
    }

    /**
     * Build transcription tree for the given languages
     *
     * @param string $sourceLanguage Source language
     * @param string $targetLanguage Target language
     * @return Tree
     */
    private function buildTree($sourceLanguage, $targetLanguage) {
        $rules = $this->ruleHandler->search([
            'sourceLanguage' => $sourceLanguage,
            'targetLanguage' => $targetLanguage
        ]);
        $tree = new Tree();
        foreach ($rules as $rule) {
            $tree->processRule($rule->getPattern(), $rule->getReplacement());
        }
        return $tree;
    }

}
