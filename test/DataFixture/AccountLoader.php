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
use ZfMetal\Calendar\Entity\Account;

class AccountLoader  extends AbstractFixture implements FixtureInterface
{

    const ENTITY = Account::class;



    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ArrayCollection
     */
    protected $accounts;

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
    public function getAccounts()
    {
        if (!$this->accounts) {
            $this->accounts = new ArrayCollection();
        }
        return $this->accounts;
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

        $this->createAccount(1, "MANOLO CHAPS");

        $manager->flush();


    }


    /**
     * @param $id
     * @param $name
     */
    public function createAccount($id, $name,$tradename)
    {

        $account = $this->findByName($name);
        if (!$account) {
            $account = new Account();
            $account->setId($id);
            $account->setName($name);
            $account->setTradename($tradename);
        }


        $this->getEm()->persist($account);

        //Add reference for relations
        $this->addReference($name, $account);

        $this->getAccounts()->add($account);
    }

}