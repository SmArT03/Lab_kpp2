<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Group;


class LoadUserData  implements FixtureInterface {
    
    
    
    public function load(ObjectManager $manager)
    {
        $group = new Group();
        $group->setName('станок 3');

        $manager->persist($group);
        $manager->flush();
    }
    
    
    public function getOrder() {
        return 4; // the order in which fixtures will be loaded
    }
    
}
