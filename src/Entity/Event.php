<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;
use ZfMetal\Restful\Transformation;

/**
 * Event
 * 
 * 
 * 
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_events")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\EventRepository")
 */
class Event
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
     * @Transformation\Policy\Custom(transform= "\ZfMetal\Calendar\PolicyHandler\EntityId::transform")
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"calendar","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\Calendar", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\Calendar")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id", nullable=false)
     */
    public $calendar = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Ticket", "description":"", "addon":""})
     * @ORM\Column(type="integer", length=11, unique=false, nullable=true,
     * name="ticket")
     */
    public $ticket = null;

    /**
     * @Transformation\Policy\FormatDateTime(format="Y-m-d H:i")
     * @Annotation\Type("Zend\Form\Element\DateTimeLocal")
     * @Annotation\Attributes({"type":"datetime"})
     * @Annotation\Options({"label":"start", "description":"", "addon":"", "format" : "Y-m-d H:i"})
     * @Annotation\Validator({"name":"Date", "options": {"format":"Y-m-d H:i",
     * "messages": {"dateInvalidDate": "Fecha no válida. Formato: Año-Mes-Dia Hora:Minuto (Ej: 1985-12-31 23:59)",
     * "dateFalseFormat":"Fecha no válida. Formato: Año-Mes-Dia Hora:Minuto (Ej: 1985-12-31 23:59)"}}})
     * @ORM\Column(type="datetime", unique=false, nullable=false, name="start")
     */
    public $start = null;

    /**
     * @Transformation\Policy\FormatDateTime(format="Y-m-d H:i")
     * @Annotation\Type("Zend\Form\Element\DateTimeLocal")
     * @Annotation\Attributes({"type":"datetime"})
     * @Annotation\Options({"label":"end", "description":"", "addon":"", "format" : "Y-m-d H:i"})
     * @Annotation\Validator({"name":"Date", "options": {"format":"Y-m-d H:i",
     * "messages": {"dateInvalidDate": "Fecha no válida. Formato: Año-Mes-Dia Hora:Minuto (Ej: 1985-12-31 23:59)",
     * "dateFalseFormat":"Fecha no válida. Formato: Año-Mes-Dia Hora:Minuto (Ej: 1985-12-31 23:59)"}}})
     * @ORM\Column(type="datetime", unique=false, nullable=false, name="end")
     */
    public $end = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"title", "description":"", "addon":""})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true,
     * name="title")
     */
    public $title = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Ubicación", "description":"", "addon":""})
     * @ORM\Column(type="string", length=120, unique=false, nullable=true,
     * name="location")
     */
    public $location = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Attributes({"type":"textarea"})
     * @Annotation\Options({"label":"description", "description":""})
     * @ORM\Column(type="string", length=500, unique=false, nullable=true,
     * name="description")
     */
    public $description = null;



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

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function setEnd($end)
    {
        $this->end = $end;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
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



    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getTicket()
    {
        return $this->ticket;
    }

    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
    }


    public function __toString()
    {
        return (string) $this->title;
    }


}

