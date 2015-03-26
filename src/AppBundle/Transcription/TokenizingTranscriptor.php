<?php
/**
 * This file is part of the transcriptor project.
 */

namespace AppBundle\Transcription;


/**
 * Class TokenizingTranscriptor
 
 * @package AppBundle\Transcription
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
abstract class TokenizingTranscriptor implements Transcriptor {

    const TOKEN_PATTERN = '/[\s]*[^\s]+/';

    /**
     * Transcript the given text from source to target language.
     * Returns an array of possible transcriptions.
     *
     * @param string $text           Text to transcript
     * @param string $sourceLanguage Source language
     * @param string $targetLanguage Target language
     * @return array
     */
    public function transcript($text, $sourceLanguage, $targetLanguage) {
        if ($sourceLanguage == 'ipa' || $targetLanguage == 'ipa') {
            return $this->doTranscript($text, $sourceLanguage, $targetLanguage);
        } else {
            $results = [];
            $ipaTranslations = $this->doTranscript($text, $sourceLanguage, 'ipa');
            foreach ($ipaTranslations as $ipaTranslation) {
                $results[] =$this->doTranscript($ipaTranslation, 'ipa', $targetLanguage);
            }
            return $results;
        }
    }

    /**
     * Transcript the given text from source to target language.
     * Returns an array of possible transcriptions.
     * Either source or target language MUST be 'ipa'.
     *
     * @param string $text           Text to transcript
     * @param string $sourceLanguage Source language
     * @param string $targetLanguage Target language
     * @return array
     */
    abstract protected function doTranscript($text, $sourceLanguage, $targetLanguage);

    /**
     * Tokenize the string
     *
     * @param string $text Text to tokenize
     * @return array
     */
    protected function tokenize($text) {
        preg_match_all(self::TOKEN_PATTERN, $text, $tokens);
        return $tokens[0];
    }

}