<?php
/**
 * This file is part of the transcriptor project.
 */

namespace AppBundle\Transcription\TreeTranscriptor;

/**
 * Transcription tree

 * @package AppBundle\Transcription\TreeTranscriptor
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class Tree
{
    /** @var  Tree[] */
    private $map;
    private $replacement;

    /**
     * Get transcription of the given string
     *
     * @param string $string String to transcript
     * @return string
     */
    public function transcript($string) {
        $transcription = '';
        $rest = $string;
        do {
            $result = $this->getReplacement($transcription, $rest);
            if ($result === false) {
                $transcription .= $this->shiftString($rest);
            } else {
                $transcription .= $result[0];
                $rest = $result[1];
            }
        } while (!empty($rest));
        return $transcription;
    }

    /**
     * Get replacement for the string that is still left
     * Returns array of successfully transcribed and left part of the string
     * or false if nothing could be transcribed
     *
     * @param string $currentString String part that lead to this node
     * @param string $leftString String yet to be tried to transcript
     * @return array|bool
     */
    private function getReplacement($currentString, $leftString) {
        $char = $this->shiftString($leftString);
        if (isset($this->map[$char])) {
            $result = $this->map[$char]->getReplacement($currentString . $char, $leftString);
            if ($result !== false) {
                return $result;
            } else {
                if (isset($this->replacement)) {
                    return [$this->replacement, $char . $leftString];
                } else {
                    return false;
                }
            }
        } else {
            if (isset($this->replacement)) {
                return [$this->replacement, $char . $leftString];
            } else {
                return false;
            }
        }
    }

    /**
     * Add new node for the given character
     *
     * @param string $char Character
     * @param Tree $tree Tree node
     */
    public function addRule($char, Tree $tree) {
        $this->map[$char] = $tree;
    }

    /**
     * Update the tree with the given rule
     *
     * @param string $pattern Rule pattern
     * @param string $replacement Rule replacement
     * @return $this
     */
    public function processRule($pattern, $replacement) {
        if (empty($pattern)) {
            $this->replacement = $replacement;
            return $this;
        }
        $char = $this->shiftString($pattern);
        if (isset($this->map[$char])) {
            $this->map[$char]->processRule($pattern, $replacement);
        } else {
            $tree = new Tree();
            $this->map[$char] = $tree->processRule($pattern, $replacement);
        }
        return $this;
    }

    /**
     * Shifts the string by one character and returns the character.
     * Multi-byte safe
     *
     * @param string $string String to shift
     * @return string
     */
    private function shiftString(&$string) {
        $first = mb_substr($string, 0, 1);
        $string = mb_substr($string, 1);
        return $first;
    }

}
