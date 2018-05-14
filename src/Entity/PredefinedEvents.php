<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PredefinedEvents
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_predefined_events")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\PredefinedEventsRepository")
 */
class PredefinedEvents
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
     * @Annotation\Options({"label":"calendar","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\Calendar", "description":""})
     * @ORM\OneToOne(targetEntity="\ZfMetal\Calendar\Entity\Calendar", inversedBy="predefinedEvents")
     */
    public $calendar = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Number")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Duracion", "description":"Duración del evento en
     * minutos.", "addon":""})
     * @ORM\Column(type="integer", length=6, unique=false, nullable=true,
     * name="duration")
     */
    public $duration = 0;

    /**
     * @Annotation\Type("Zend\Form\Element\Number")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"break", "description":"", "addon":""})
     * @ORM\Column(type="integer", length=6, unique=false, nullable=true, name="break")
     */
    public $break = 0;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCalendar()
    {
        return $this->calendar;
    }

    public function setCalendar($calendar)
    {
        $this->calendar = $calendar;
    }

    public function getBreak()
    {
        return $this->break;
    }

    public function setBreak($break)
    {
        if(!$break || $break == '')
        {
            $this->break = 0;
        }else {
            $this->break = $break;
        }
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        if(!$duration || $duration == '')
        {
            $this->duration = 0;
        }else {
            $this->duration = $duration;
        }
    }

    public function __toString()
    {
        return (string) $this->duration;
    }


}

