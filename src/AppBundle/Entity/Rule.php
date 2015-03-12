<?php
/**
 * This file is part of the transcriptor project.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rule entity
 *
 * @package AppBundle\Entity
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 *
 * @ORM\Entity
 * @ORM\Table(name="rule")
 */
class Rule {

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=5)
     * @Assert\Length(min="2", max="5")
     */
    private $sourceLanguage;

    /**
     * @var string
     * @ORM\Column(type="string", length=5)
     * @Assert\Length(min="2", max="5")
     */
    private $targetLanguage;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="1", max="255")
     */
    private $pattern;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max="255")
     */
    private $replacement;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSourceLanguage()
    {
        return $this->sourceLanguage;
    }

    /**
     * @param string $sourceLanguage
     */
    public function setSourceLanguage($sourceLanguage)
    {
        $this->sourceLanguage = $sourceLanguage;
    }

    /**
     * @return string
     */
    public function getTargetLanguage()
    {
        return $this->targetLanguage;
    }

    /**
     * @param string $targetLanguage
     */
    public function setTargetLanguage($targetLanguage)
    {
        $this->targetLanguage = $targetLanguage;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * @return string
     */
    public function getReplacement()
    {
        return $this->replacement;
    }

    /**
     * @param string $replacement
     */
    public function setReplacement($replacement)
    {
        $this->replacement = $replacement;
    }

}