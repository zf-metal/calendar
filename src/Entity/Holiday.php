<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Holiday
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_holiday")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\HolidayRepository")
 */
class Holiday
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
     * @Annotation\Type("Zend\Form\Element\Date")
     * @Annotation\Attributes({"type":"date"})
     * @Annotation\Options({"label":"Fecha", "description":"", "addon":""})
     * @ORM\Column(type="date", unique=false, nullable=false, name="date")
     */
    public $date = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Titulo", "description":"", "addon":""})
     * @ORM\Column(type="string", length=30, unique=false, nullable=true, name="title")
     */
    public $title = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function __toString()
    {
        return (string) $this->date." ".  $this->title;
    }


}

