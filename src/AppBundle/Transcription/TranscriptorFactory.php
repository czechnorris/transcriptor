<?php
/**
 * This file is part of the transcriptor project.
 */

namespace AppBundle\Transcription;


/**
 * Class TranscriptorFactory
 
 * @package AppBundle\Transcription
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class TranscriptorFactory {

    const SIMPLE = 'simple';

    /**
     * Get transcriptor instance of the given type
     *
     * @param string $type Transcriptor type
     * @return Transcriptor
     */
    public static function getInstance($type = self::SIMPLE) {
        switch ($type) {
            case self::SIMPLE:
            default:
                return new SimpleTranscriptor();
        }
    }

}