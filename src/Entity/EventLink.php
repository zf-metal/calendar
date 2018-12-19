<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;
use ZfMetal\Restful\Transformation;

/**
 * EventLink
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_event_link")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\EventLinkRepository")
 */
class EventLink
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
     * @Transformation\Policy\Skip()
     * @Annotation\Exclude()
     * @ORM\OneToMany(targetEntity="\ZfMetal\Calendar\Entity\Event",
     *     mappedBy="link",
     *     fetch="LAZY",
     *     cascade={"remove"},
     *     orphanRemoval=true)
     */
    public $events = null;


    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return (string) $this->id ;
    }

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }



}

