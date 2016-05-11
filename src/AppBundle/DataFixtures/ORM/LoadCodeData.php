<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Code;


class LoadUserData  implements FixtureInterface {
    
    
    
    public function load(ObjectManager $manager)
    {
        $code = new Code();
        $code->setName('вал_new');

        $manager->persist($code);
        $manager->flush();
    }
    
    
    public function getOrder() {
        return 2; // the order in which fixtures will be loaded
    }
    
}
