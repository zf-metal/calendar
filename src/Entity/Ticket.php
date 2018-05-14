<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Ticket
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_ticket")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\TicketRepository")
 */
class Ticket
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
     * @Annotation\Exclude()
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="created_at")
     */
    public $createdAt = null;

    /**
     * @Annotation\Exclude()
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="updated_at")
     */
    public $updatedAt = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectMultiCheckbox")
     * @Annotation\Options({"label":"Evento","target_class":"\ZfMetal\Calendar\Entity\Event",
     * "description":""})
     * @ORM\OneToMany(targetEntity="\ZfMetal\Calendar\Entity\Event", mappedBy="ticket")
     */
    public $event = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"Estado","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\TicketState", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\TicketState")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id", nullable=false)
     */
    public $state = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Asunto", "description":"", "addon":""})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true,
     * name="subject")
     */
    public $subject = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
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

    public function __toString()
    {
        return (string) $this->id." ".  $this->subject;
    }


}

