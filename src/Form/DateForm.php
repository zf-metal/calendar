<?php

namespace ZfMetal\Calendar\Form;


class DateForm extends \Zend\Form\Form
{


    public function __construct()
    {
        parent::__construct('date');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");
        $this->setAttribute('autocomplete', "off");
    }

    public function init()
    {



        $this->add(array(
            'name' => 'date',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control ',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Fecha',
                'description' => 'Configuración, en minutos, de la duración por defecto de cada evento.'
            )
        ));


    }


}
