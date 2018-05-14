<?php

namespace ZfMetal\Calendar\Form;

use Doctrine\Common\Persistence\ObjectManager;
use ZfMetal\Calendar\Entity\Schedule;


class ScheduleForm extends \Zend\Form\Fieldset implements \DoctrineModule\Persistence\ObjectManagerAwareInterface
{

    /**
     * @var ObjectManager
     */
    public $objectManager = null;

    /**
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * @param ObjectManager $objectManager
     */
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }


    public function __construct()
    {
        parent::__construct("schedule");
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");
        $this->setAttribute('autocomplete', "off");
    }

    public function init(){
        $this->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getObjectManager()))->setObject(new Schedule());

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            )
        ));

        $this->add(array(
            'name' => 'day',
            'attributes' => array(
                'type' => 'hidden'
            )
        ));

        $this->add(array(
            'name' => 'start',
            'attributes' => array(
                'type' => 'time',
                'class' => 'form-control ',
                'autocomplete' => "off",
            )
        ));

        $this->add(array(
            'name' => 'end',
            'attributes' => array(
                'type' => 'time',
                'class' => 'form-control ',
                'autocomplete' => "off",
            )
        ));


        $this->add(array(
            'name' => 'startBreak',
            'attributes' => array(
                'type' => 'time',
                'class' => 'form-control ',
                'autocomplete' => "off",
            )
        ));

        $this->add(array(
            'name' => 'endBreak',
            'attributes' => array(
                'type' => 'time',
                'class' => 'form-control ',
                'autocomplete' => "off",
            )
        ));

    }

}