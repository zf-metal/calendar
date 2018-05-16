<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * EventHistory
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_event_history")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\EventHistoryRepository")
 */
class EventHistory
{

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"ID", "description":"", "addon":""})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", length=11, unique=false, nullable=false, name="id")
     */
    public $id = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"event","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\Event", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=true)
     */
    public $event = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"state","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\EventState", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\EventState")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id", nullable=true)
     */
    public $state = null;

    /**
     * @Annotation\Type("Zend\Form\Element\DateTime")
     * @Annotation\Attributes({"type":"datetime"})
     * @Annotation\Options({"label":"createdAt", "description":"", "addon":""})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="created_at")
     */
    public $createdAt = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Attributes({"type":"textarea"})
     * @Annotation\Options({"label":"comment", "description":""})
     * @ORM\Column(type="string", length=200, unique=false, nullable=true,
     * name="comment")
     */
    public $comment = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function setEvent($event)
    {
        $this->event = $event;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function __toString()
    {
        return (string)  $this->id;
    }


}

