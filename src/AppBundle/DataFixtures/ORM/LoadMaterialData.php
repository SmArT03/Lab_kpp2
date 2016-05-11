<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Material;


class LoadUserData  implements FixtureInterface {
    
    
    
    public function load(ObjectManager $manager)
    {
        $material = new Material();
        $material->setName('Шайба nitra');
        $material->setCode('резцы');        

        $manager->persist($material);
        
        $material1 = new Material();
        $material1->setName('Шайба nitra1');
        $material1->setCode('вал');        

        $manager->persist($material1);
        
        $manager->flush();
    }
    
    
    public function getOrder() {
        return 1; // the order in which fixtures will be loaded
    }
    
}
