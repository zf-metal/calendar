<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;
use ZfMetal\Restful\Transformation;

/**
 * Service
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_service")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\ServiceRepository")
 */
class Service
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
     * @Annotation\Options({"label":"Cliente","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\Client", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=true)
     */
    public $client = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"branchOffice","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\BranchOffice", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\BranchOffice")
     * @ORM\JoinColumn(name="branch_office_id", referencedColumnName="id",
     * nullable=true)
     */
    public $branchOffice = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Nombre", "description":"", "addon":""})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="name")
     */
    public $name = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function getBranchOffice()
    {
        return $this->branchOffice;
    }

    public function setBranchOffice($branchOffice)
    {
        $this->branchOffice = $branchOffice;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return (string) $this->name;
    }


}

