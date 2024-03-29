<?php

namespace ZfMetal\Calendar\Form;

use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\Fieldset;

class CalendarForm extends \Zend\Form\Form implements \DoctrineModule\Persistence\ObjectManagerAwareInterface
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
        parent::__construct('calendar');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");
        $this->setAttribute('autocomplete', "off");
    }

    public function init()
    {

        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getObjectManager(),false);
        $this->setHydrator($hydrator);

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            )
        ));

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Nombre',
                'class' => 'form-control ',
                'required' => 'required',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Nombre del Calendario',
            )
        ));

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
        ]);

        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Descripción',
                'class' => 'form-control ',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Descripción',
            )
        ));

        $this->add(array(
            'name' => 'priority',
            'attributes' => array(
                'type' => 'number',
                'placeholder' => 'Prioridad',
                'class' => 'form-control ',
                'required' => 'required',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Prioridad para orden en programación',
            )
        ));


        $this->add([
            'type' => Collection::class,
            'name' => 'schedules',
            'options' => [
                'label' => 'Configurar Schedule',
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => [
                    'type' => ScheduleForm::class,
                ],
            ],
        ]);

        $this->add([
            'type' => AppointmentConfigForm::class,
            'name' => 'appointmentConfig',
        ]);


        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => "Guardar",
                'class' => 'btn btn-primary',
            ),
            'options' => array(
                'label' => 'Guardar',
            )
        ));

    }


}
