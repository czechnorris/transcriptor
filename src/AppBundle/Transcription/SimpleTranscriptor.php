<?php
/**
 * This file is part of the transcriptor project.
 */

namespace AppBundle\Transcription;


/**
 * Class SimpleTranscriptor
 
 * @package AppBundle\Transcription
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class SimpleTranscriptor implements Transcriptor {

    /**
     * Transcript the given text from source to target language.
     *
     * @param string $text Text to transcript
     * @param string $sourceLanguage Source language
     * @param string $targetLanguage Target language
     * @return string
     */
    public function transcript($text, $sourceLanguage, $targetLanguage)
    {
        return "ahoj";
    }
}