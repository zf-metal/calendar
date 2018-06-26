<?php

namespace ZfMetal\Calendar\DataFixture;

/**
 * Created by PhpStorm.
 * User: crist
 * Date: 1/6/2018
 * Time: 12:21
 */
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use ZfMetal\Calendar\Entity\EventState;

class EventStateLoader implements FixtureInterface
{


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {


        $obj = new EventState();
        $obj->setId('1');
        $obj->setName('Nuevo');
        $obj->setBgColor('#1c5c87');
        $obj->setColor('#FFFFFF');
        $manager->persist($obj);

        $obj = new EventState();
        $obj->setId('2');
        $obj->setName('Progreso');
        $obj->setBgColor('#016070');
        $obj->setColor('#FFFFFF');
        $manager->persist($obj);

        $obj = new EventState();
        $obj->setId('3');
        $obj->setName('Cancelado');
        $obj->setBgColor('#b81717');
        $obj->setColor('#FFFFFF');
        $manager->persist($obj);

        $obj = new EventState();
        $obj->setId('4');
        $obj->setName('Reprogramar');
        $obj->setBgColor('#e73617');
        $obj->setColor('#FFFFFF');
        $manager->persist($obj);

        $obj = new EventState();
        $obj->setId('5');
        $obj->setName('Resuelto');
        $obj->setBgColor('#86bd46');
        $obj->setColor('#FFFFFF');
        $manager->persist($obj);

        $obj = new EventState();
        $obj->setId('6');
        $obj->setName('Cerrado');
        $obj->setBgColor('#000000');
        $obj->setColor('#FFFFFF');
        $manager->persist($obj);

        $manager->flush();
    }
}