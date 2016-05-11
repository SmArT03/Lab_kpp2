<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Consumption;


class LoadUserData  implements FixtureInterface {
    
    
    
    public function load(ObjectManager $manager)
    {
        $consumption = new Consumption();
        $consumption->setMaterial('Болт 12/18');
        $consumption->setGroup('станок 1');
        $consumption->setQuantity('40');
        $consumption->setDate('2016-05-01');
        $consumption->setDescription('Продали 50 болтов 12/18 ');
        

        $manager->persist($consumption);
        $manager->flush();
    }
    
    
    public function getOrder() {
        return 3; // the order in which fixtures will be loaded
    }
    
}
