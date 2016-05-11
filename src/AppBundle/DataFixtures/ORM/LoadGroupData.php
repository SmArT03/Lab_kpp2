<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Group;


class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface {
    
    
    
    public function load(ObjectManager $manager)
    {
        $group = new Group();
        $group->setName('станок 1');
        $this->addReference('group1', $group);
        $manager->persist($group);
        
        $group2 = new Group();
        $group2->setName('станок 2');
        $this->addReference('group2', $group2);
        $manager->persist($group2);
        
        
        
        $manager->flush();
    }
    
    
    public function getOrder() {
        return 3; // the order in which fixtures will be loaded
    }
    
}
