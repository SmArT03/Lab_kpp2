<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Inventory;


class LoadUserData  implements FixtureInterface {
    
    
    
    public function load(ObjectManager $manager)
    {
        $inventory = new Inventory();
        $inventory->setMaterial('Болт 12\18');
        $inventory->setDate('2016-05-11');
        $inventory->setBefore('50');
        $inventory->setAfter('15');

        

        $manager->persist($inventory);
        $manager->flush();
    }
    
    
    public function getOrder() {
        return 5; // the order in which fixtures will be loaded
    }
    
}
