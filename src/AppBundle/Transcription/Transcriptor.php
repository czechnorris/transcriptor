<?php
/**
 * This file is part of the transcriptor project.
 */

namespace AppBundle\Transcription;

/**
 * Transcriptor interface

 * @package AppBundle\Transcription
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
interface Transcriptor {

    /**
     * Transcript the given text from source to target language.
     *
     * @param string $text           Text to transcript
     * @param string $sourceLanguage Source language
     * @param string $targetLanguage Target language
     * @return string
     */
    public function transcript($text, $sourceLanguage, $targetLanguage);

}