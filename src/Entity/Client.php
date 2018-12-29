<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Client
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_client")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\ClientRepository")
 */
class Client
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
     * @Annotation\Options({"label":"Nombre Legal", "description":"", "addon":""})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="name")
     */
    public $name = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Nombre Comercial", "description":"", "addon":""})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true,
     * name="tradename")
     */
    public $tradename = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Dirección de Facturación", "description":"",
     * "addon":""})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true,
     * name="billing_address")
     */
    public $billingAddress = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Nombre Contacto", "description":"", "addon":""})
     * @ORM\Column(type="string", length=50, unique=false, nullable=true,
     * name="contact_name")
     */
    public $contactName = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Email Contacto", "description":"", "addon":""})
     * @ORM\Column(type="string", length=50, unique=false, nullable=true,
     * name="contact_email")
     */
    public $contactEmail = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Teléfono Contacto", "description":"",
     * "addon":""})
     * @ORM\Column(type="string", length=15, unique=false, nullable=true,
     * name="contact_tel")
     */
    public $contactTel = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"CUIT", "description":"", "addon":""})
     * @ORM\Column(type="string", length=30, unique=false, nullable=true, name="cuit")
     */
    public $cuit = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Web", "description":"", "addon":""})
     * @ORM\Column(type="string", length=30, unique=false, nullable=true, name="web")
     */
    public $web = null;

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

    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    public function getContactName()
    {
        return $this->contactName;
    }

    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    }

    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }

    public function getContactTel()
    {
        return $this->contactTel;
    }

    public function setContactTel($contactTel)
    {
        $this->contactTel = $contactTel;
    }

    public function getCuit()
    {
        return $this->cuit;
    }

    public function setCuit($cuit)
    {
        $this->cuit = $cuit;
    }

    public function getWeb()
    {
        return $this->web;
    }

    public function setWeb($web)
    {
        $this->web = $web;
    }

    public function __toString()
    {
        return (string) $this->name;
    }


}

