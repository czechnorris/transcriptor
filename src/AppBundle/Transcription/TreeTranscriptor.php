<?php
/**
 * This file is part of the transcriptor project.
 */

namespace AppBundle\Transcription;
use AppBundle\Handler\RuleHandler;
use AppBundle\Transcription\TreeTranscriptor\Tree;

/**
 * Class TreeTranscriptor

 * @package AppBundle\Transcription
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class TreeTranscriptor implements Transcriptor {

    const TOKEN_PATTERN = '/[\s]*[^\s]+/';

    /** @var RuleHandler */
    private $ruleHandler;

    /** @var  array */
    private $trees = [];

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
    public function transcript($text, $sourceLanguage, $targetLanguage) {
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

    /**
     * Tokenize the string
     *
     * @param string $text Text to tokenize
     * @return array
     */
    private function tokenize($text) {
        preg_match_all(self::TOKEN_PATTERN, $text, $tokens);
        return $tokens[0];
    }

}
