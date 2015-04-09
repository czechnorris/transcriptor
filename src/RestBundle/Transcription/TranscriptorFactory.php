<?php
/**
 * This file is part of the transcriptor project.
 */

namespace RestBundle\Transcription;
use Symfony\Component\DependencyInjection\Container;


/**
 * Class TranscriptorFactory
 
 * @package RestBundle\Transcription
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class TranscriptorFactory {

    const SIMPLE = 'simple';

    /** @var  Container */
    private $container;

    /**
     * The constructor
     *
     * @param \Symfony\Component\DependencyInjection\Container $container
     */
    public function __construct(Container $container) {
        $this->container = $container;
    }

    /**
     * Get transcriptor instance of the given type
     *
     * @param string $type Transcriptor type
     * @return Transcriptor
     */
    public function getInstance($type = self::SIMPLE) {
        $instance = $this->container->get('api.transcription.transcriptor.' . $type, Container::NULL_ON_INVALID_REFERENCE);
        if (!$instance instanceof Transcriptor) {
            $instance = $this->container->get('api.transcription.transcriptor.' . self::SIMPLE);
        }
        return $instance;
    }

}