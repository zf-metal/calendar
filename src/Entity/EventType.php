<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * EventType
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_event_type")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\EventTypeRepository")
 */
class EventType
{

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"ID", "description":"", "addon":""})
     * @ORM\Id
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
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Icono", "description":"", "addon":""})
     * @ORM\Column(type="string", length=20, unique=false, nullable=true, name="icon")
     */
    public $icon = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Color", "description":"", "addon":""})
     * @ORM\Column(type="string", length=7, unique=false, nullable=true, name="color")
     */
    public $color = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Color de Fondo", "description":"", "addon":""})
     * @ORM\Column(type="string", length=7, unique=false, nullable=true,
     * name="bg_color")
     */
    public $bgColor = null;

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

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getBgColor()
    {
        return $this->bgColor;
    }

    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;
    }

    public function __toString()
    {
        return (string) $this->name;
    }


}

