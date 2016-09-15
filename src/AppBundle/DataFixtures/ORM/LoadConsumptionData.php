<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Consumption;

class LoadConsumptionData extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        $consumption = new Consumption();
        $consumption->setMaterial($this->getReference('material1'));
        $consumption->setGroup($this->getReference('group2'));
        $consumption->setQuantity(30);
        $consumption->setDate(new \DateTime(2016 - 05 - 03));
        $consumption->setDescription('Продали 30 шайб ');
        $manager->persist($consumption);

        $consumption2 = new Consumption();
        $consumption2->setMaterial($this->getReference('material2'));
        $consumption2->setGroup($this->getReference('group1'));
        $consumption2->setQuantity(50);
        $consumption2->setDate(new \DateTime(2016 - 05 - 05));
        $consumption2->setDescription('Продали 50 болтов ');
        $manager->persist($consumption2);

        $consumption3 = new Consumption();
        $consumption3->setMaterial($this->getReference('material3'));
        $consumption3->setGroup($this->getReference('group1'));
        $consumption3->setQuantity(10);
        $consumption3->setDate(new \DateTime(2016 - 05 - 07));
        $consumption3->setDescription('Продали 10 кюрков ');
        $manager->persist($consumption3);

        $manager->flush();
    }

    public function getOrder() {
        return 5; // the order in which fixtures will be loaded
    }

}
