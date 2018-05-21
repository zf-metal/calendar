<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;
use ZfMetal\Restful\Transformation;

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
class Ticket implements TicketInterface {

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
     * @Transformation\Policy\FormatDateTime(format="Y-m-d H:i:s")
     * @Annotation\Exclude()
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="created_at")
     */
    public $createdAt = null;

    /**
     * @Transformation\Policy\FormatDateTime(format="Y-m-d H:i:s")
     * @Annotation\Exclude()
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="updated_at")
     */
    public $updatedAt = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectMultiCheckbox")
     * @Annotation\Options({"label":"Evento","target_class":"\ZfMetal\Calendar\Entity\Event",
     * "description":""})
     * @ORM\OneToOne(targetEntity="\ZfMetal\Calendar\Entity\Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    public $event = null;

    /**
     * @Transformation\Policy\Custom(transform= "\ZfMetal\Calendar\PolicyHandler\EntityIdName::transform")
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

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Ubicación", "description":"", "addon":""})
     * @ORM\Column(type="string", length=120, unique=false, nullable=true,
     * name="location")
     */
    public $location = null;


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

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }



    public function __toString()
    {
        return (string) $this->id." ".  $this->subject;
    }


}

