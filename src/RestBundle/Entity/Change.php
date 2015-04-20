<?php
/**
 * This file is part of the transcriptor project.
 */

namespace RestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Class Change
 
 * @package RestBundle\Entity
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 *
 * @ORM\Entity(repositoryClass="ChangeRepository")
 * @ORM\Table("change")
 */
class Change {

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Rule")
     * @ORM\JoinColumn(name="rule_id", referencedColumnName="id")
     */
    private $ruleId;

    /**
     * @var string
     * @ORM\Column(name="original_pattern", type="string", length=255, nullable=true)
     * @Assert\Length(min="1", max="255")
     *
     */
    private $originalPattern;

    /**
     * @var string
     * @ORM\Column(name="new_pattern", type="string", length=255)
     * @Assert\Length(min="1", max="255")
     */
    private $newPattern;

    /**
     * @var string
     * @ORM\Column(name="original_replacement", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $originalReplacement;

    /**
     * @var string
     * @ORM\Column(name="new_replacement", type="string", length=255)
     * @Assert\Length(max="255")
     */
    private $newReplacement;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_on", type="datetime")
     */
    private $createdOn;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getRuleId()
    {
        return $this->ruleId;
    }

    /**
     * @param int $ruleId
     */
    public function setRuleId($ruleId)
    {
        $this->ruleId = $ruleId;
    }

    /**
     * @return string
     */
    public function getOriginalPattern()
    {
        return $this->originalPattern;
    }

    /**
     * @param string $originalPattern
     */
    public function setOriginalPattern($originalPattern)
    {
        $this->originalPattern = $originalPattern;
    }

    /**
     * @return string
     */
    public function getNewPattern()
    {
        return $this->newPattern;
    }

    /**
     * @param string $newPattern
     */
    public function setNewPattern($newPattern)
    {
        $this->newPattern = $newPattern;
    }

    /**
     * @return string
     */
    public function getOriginalReplacement()
    {
        return $this->originalReplacement;
    }

    /**
     * @param string $originalReplacement
     */
    public function setOriginalReplacement($originalReplacement)
    {
        $this->originalReplacement = $originalReplacement;
    }

    /**
     * @return string
     */
    public function getNewReplacement()
    {
        return $this->newReplacement;
    }

    /**
     * @param string $newReplacement
     */
    public function setNewReplacement($newReplacement)
    {
        $this->newReplacement = $newReplacement;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param \DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

}