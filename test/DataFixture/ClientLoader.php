<?php
/**
 * Created by PhpStorm.
 * User: crist
 * Date: 11/12/2018
 * Time: 00:14
 */

namespace Test\DataFixture;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\ORM\EntityManager;
use ZfMetal\Calendar\Entity\Client;

class ClientLoader  extends AbstractFixture implements FixtureInterface
{

    const ENTITY = Client::class;



    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ArrayCollection
     */
    protected $clients;

    /**
     * @return mixed
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @return ArrayCollection
     */
    public function getClients()
    {
        if (!$this->clients) {
            $this->clients = new ArrayCollection();
        }
        return $this->clients;
    }


    protected function findByName($name)
    {
        return $this->getEm()->getRepository($this::ENTITY)->findOneByName($name);
    }


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $this->em = $manager;

        $this->createClient(1, "MANOLO CHAPS", "MANO");

        $manager->flush();


    }


    /**
     * @param $id
     * @param $name
     * @param $tradename
     */
    public function createClient($id, $name,$tradename)
    {

        $client = $this->findByName($name);
        if (!$client) {
            $client = new Client();
            $client->setId($id);
            $client->setName($name);
            $client->setTradename($tradename);
        }


        $this->getEm()->persist($client);

        //Add reference for relations
        $this->addReference($name, $client);

        $this->getClients()->add($client);
    }

}