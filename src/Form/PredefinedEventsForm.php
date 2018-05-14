<?php

namespace ZfMetal\Calendar\Form;

use Doctrine\Common\Persistence\ObjectManager;
use ZfMetal\Calendar\Entity\PredefinedEvents;

class PredefinedEventsForm extends \Zend\Form\Fieldset implements \DoctrineModule\Persistence\ObjectManagerAwareInterface
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
        parent::__construct('predefinedevents');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");
        $this->setAttribute('autocomplete', "off");
    }

    public function init()
    {

        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getObjectManager(),false);
        $this->setHydrator($hydrator)->setObject(new PredefinedEvents());

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
                'placeholder' => 'Intervalo',
                'class' => 'form-control ',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Tiempo de evento',
                'description' => 'Configuración, en minutos, de la duración por defecto de cada evento.'
            )
        ));


        $this->add(array(
            'name' => 'break',
            'attributes' => array(
                'type' => 'number',
                'placeholder' => 'Intervalo',
                'class' => 'form-control ',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Tiempo entre eventos',
                'description' => 'Configuración, en minutos, del espacio de tiempo entre evento y evento'
            )
        ));

    }


}
