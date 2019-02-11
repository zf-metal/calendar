<?php

namespace ZfMetal\Calendar\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Form\Element\ObjectSelect;
use ZfMetal\Calendar\Entity\Schedule;


class AppointmentForm extends \Zend\Form\Form implements \DoctrineModule\Persistence\ObjectManagerAwareInterface
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
        parent::__construct("AppointmentForm");
        $this->setAttribute('method', 'post');
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
            'name' => 'user',
            'attributes' => array(
                'type' => 'hidden',
            )
        ));

        $this->add(array(
            'name' => 'calendar',
            'attributes' => array(
                'type' => 'hidden',
            )
        ));

       /* $this->add([
            'type' => ObjectSelect::class,
            'name' => 'calendar',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => [
                'label' => 'Agenda',
                'object_manager' => $this->getObjectManager(),
                'target_class' => '\ZfMetal\Calendar\Entity\Calendar',
                'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => 'Agenda',
            ],
        ]);

        $this->add([
            'type' => ObjectSelect::class,
            'name' => 'user',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => [
                'label' => 'Usuario',
                'object_manager' => $this->getObjectManager(),
                'target_class' => '\ZfMetal\Security\Entity\User',
                'property' => 'username',
                'display_empty_item' => true,
                'empty_item_label' => 'Usuario',
            ],
        ]);*/

        $this->add(array(
            'name' => 'start',
            'attributes' => array(
                'type' => 'time',
                'class' => 'form-control ',
                'autocomplete' => "off",
            )
        ));

        $this->add(array(
            'name' => 'duration',
            'attributes' => array(
                'type' => 'text',
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

    }

}