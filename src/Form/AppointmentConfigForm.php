<?php

namespace ZfMetal\Calendar\Form;

use Doctrine\Common\Persistence\ObjectManager;
use ZfMetal\Calendar\Entity\AppointmentConfig;
use ZfMetal\Calendar\Entity\PredefinedEvents;

class AppointmentConfigForm extends \Zend\Form\Fieldset implements \DoctrineModule\Persistence\ObjectManagerAwareInterface
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
        parent::__construct('AppointmentConfig');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");
        $this->setAttribute('autocomplete', "off");
    }

    public function init()
    {

        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getObjectManager(),false);
        $this->setHydrator($hydrator)->setObject(new AppointmentConfig());

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            )
        ));

        $this->add(array(
            'name' => 'duration',
            'attributes' => array(
                'type' => 'number',
                'placeholder' => 'Tiempo de turno',
                'class' => 'form-control ',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Tiempo de turno',
                'description' => 'Configuración, en minutos, de la duración por defecto de cada turno.'
            )
        ));


        $this->add(array(
            'name' => 'break',
            'attributes' => array(
                'type' => 'number',
                'placeholder' => 'Tiempo libre entre turnos',
                'class' => 'form-control ',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Tiempo libre entre turnos',
                'description' => 'Configuración, en minutos, del espacio de tiempo entre turno y turno'
            )
        ));


        $this->add(array(
            'name' => 'maxTimeInDays',
            'attributes' => array(
                'type' => 'number',
                'placeholder' => 'Dias máximos para Turnos',
                'class' => 'form-control ',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Dias máximos para Turnos',
                'description' => 'Configuración de la cantidad de dias hacia adelante en la que se permite agendar un turno'
            )
        ));

        $this->add(array(
            'name' => 'minTimeInMinutes',
            'attributes' => array(
                'type' => 'number',
                'placeholder' => 'Tiempo minimo para turno',
                'class' => 'form-control ',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Tiempo minimo para turno',
                'description' => 'Configuración del tiempo minimo de anticipación para sacar un turno'
            )
        ));

        $this->add(array(
            'name' => 'cancelTimeInHours',
            'attributes' => array(
                'type' => 'number',
                'placeholder' => 'Tiempo minimo para cancelar',
                'class' => 'form-control ',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Tiempo minimo para cancelar',
                'description' => 'Configuración del tiempo minimo para cancelar'
            )
        ));
    }


}
