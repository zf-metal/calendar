<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Account
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_account")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\AccountRepository")
 */
class Account
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
     * @Annotation\Options({"label":"Nombre", "description":"Nombre legal de la
     * cuenta", "addon":""})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="name")
     */
    public $name = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Nombre Comercial", "description":"Nombre comercial
     * de la cuenta", "addon":""})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true,
     * name="tradename")
     */
    public $tradename = null;

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

    public function getTradename()
    {
        return $this->tradename;
    }

    public function setTradename($tradename)
    {
        $this->tradename = $tradename;
    }

    public function __toString()
    {
        return (string) $this->name;
    }


}

