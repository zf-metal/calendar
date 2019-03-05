<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * AppointmentConfig
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_appointment_config")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\AppointmentConfigRepository")
 */
class AppointmentConfig
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
     * @ORM\OneToOne(targetEntity="\ZfMetal\Calendar\Entity\Calendar")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id", nullable=false)
     */
    public $calendar = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Duracion", "description":"Duración del evento en
     * minutos.", "addon":""})
     * @ORM\Column(type="integer", length=6, unique=false, nullable=true,
     * name="duration")
     */
    public $duration = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"break", "description":"", "addon":""})
     * @ORM\Column(type="integer", length=6, unique=false, nullable=true, name="break")
     */
    public $break = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Tiempo Minimo", "description":"Tiempo minimo para
     * solicitar un turno", "addon":""})
     * @ORM\Column(type="integer", length=11, unique=false, nullable=true,
     * name="min_time_in_hours")
     */
    public $minTimeInHours = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Tiempo Máximo en Días", "description":"",
     * "addon":""})
     * @ORM\Column(type="integer", length=5, unique=false, nullable=true,
     * name="max_time_in_days")
     */
    public $maxTimeInDays = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Tiempo para Cancelar", "description":"Tiempo para
     * poder cancelar", "addon":""})
     * @ORM\Column(type="integer", length=11, unique=false, nullable=true,
     * name="cancel_time_in_hours")
     */
    public $cancelTimeInHours = null;

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

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getBreak()
    {
        return $this->break;
    }

    public function setBreak($break)
    {
        $this->break = $break;
    }


    public function getMaxTimeInDays()
    {
        return $this->maxTimeInDays;
    }

    public function setMaxTimeInDays($maxTimeInDays)
    {
        $this->maxTimeInDays = $maxTimeInDays;
    }

    /**
     * @return mixed
     */
    public function getCancelTimeInHours()
    {
        return $this->cancelTimeInHours;
    }

    /**
     * @param mixed $cancelTimeInHours
     */
    public function setCancelTimeInHours($cancelTimeInHours)
    {
        $this->cancelTimeInHours = $cancelTimeInHours;
    }

    /**
     * @return mixed
     */
    public function getMinTimeInHours()
    {
        return $this->minTimeInHours;
    }

    /**
     * @param mixed $minTimeInHours
     */
    public function setMinTimeInHours($minTimeInHours)
    {
        $this->minTimeInHours = $minTimeInHours;
    }




    public function __toString()
    {
        return (string) $this->duration;
    }


}

