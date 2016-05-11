<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Inventory;


class LoadInventoryData  extends AbstractFixture implements OrderedFixtureInterface {
    
    
    
    public function load(ObjectManager $manager)
    {
        $inventory = new Inventory();
        $inventory->setMaterial($this->getReference('material1')); 
        $inventory->setDate(new \DateTime(2016-05-11));
        $inventory->setBeforeInventory(50);
        $inventory->setAfterInventory(20);        
        $manager->persist($inventory);
        
        $inventory2 = new Inventory();
        $inventory2->setMaterial($this->getReference('material2')); 
        $inventory2->setDate(new \DateTime(2016-05-11));
        $inventory2->setBeforeInventory(70);
        $inventory2->setAfterInventory(20);        
        $manager->persist($inventory2);
        
        $inventory3 = new Inventory();
        $inventory3->setMaterial($this->getReference('material3')); 
        $inventory3->setDate(new \DateTime(2016-05-11));
        $inventory3->setBeforeInventory(20);
        $inventory3->setAfterInventory(10);        
        $manager->persist($inventory3);
        
        $manager->flush();
    }
    
    
    public function getOrder() {
        return 6; // the order in which fixtures will be loaded
    }
    
}
