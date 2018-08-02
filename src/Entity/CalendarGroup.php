<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CalendarGroup
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_calendar_group")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\CalendarGroupRepository")
 */
class CalendarGroup
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
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Nombre", "description":"", "addon":""})
     * @ORM\Column(type="string", length=30, unique=false, nullable=true, name="name")
     */
    public $name = null;

    /**
     * @ORM\ManyToMany(targetEntity="\ZfMetal\Calendar\Entity\Calendar", inversedBy="groups", cascade={"persist", "remove"})
     * @ORM\JoinTable(
     *     name="calendar_calendargroup",
     *     joinColumns={@ORM\JoinColumn(name="calendar_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="calendargroup_id", referencedColumnName="id", nullable=false)}
     * )
     * @Annotation\Attributes({"multiple":true, "required":false})
     * @Annotation\Required(false)
     * @Annotation\AllowEmpty
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectMultiCheckbox")
     * @Annotation\Options({"label":"calendars","target_class":"\ZfMetal\Calendar\Entity\Calendar", "property": "name", "required":"false"})
     */
    public $calendars = null;

    /**
     * CalendarGroup constructor.
     */
    public function __construct()
    {
        $this->calendars = new \Doctrine\Common\Collections\ArrayCollection();

    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCalendars()
    {
        return $this->calendars;
    }

    public function setCalendars($calendars)
    {
        $this->calendars = $calendars;
    }

    public function __toString()
    {
        return (string)$this->name;
    }



    public function addCalendars(\Doctrine\Common\Collections\ArrayCollection $calendars)
    {
        foreach ($calendars as $calendar) {
            $this->addCalendar($calendar);
        }
    }

    public function removeCalendars(\Doctrine\Common\Collections\ArrayCollection $calendars)
    {
        foreach ($calendars as $calendar) {
            $this->removeCalendar($calendar);
        }
    }

    public function addCalendar(Calendar $calendar)
    {
        if ($this->calendars->contains($calendar)) {
            return;
        }
        $this->calendars->add($calendar);
        $calendar->addGroup($this);

    }

    public function removeCalendar(Calendar $calendar)
    {
        if (!$this->calendars->contains($calendar)) {
            return;
        }
        $this->calendars->removeElement($calendar);
        $calendar->removeGroup($this);
    }


}

