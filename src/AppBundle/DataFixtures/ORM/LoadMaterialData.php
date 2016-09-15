<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Material;
use AppBundle\DataFixtures\ORM\LoadCodeData;

class LoadMaterialData extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        $material = new Material();
        $material->setName('Шайба 23-14');
        $material->setCode($this->getReference('code2'));
        $this->addReference('material1', $material);
        $manager->persist($material);

        $material2 = new Material();
        $material2->setName('Болт 12/18');
        $material2->setCode($this->getReference('code3'));
        $this->addReference('material2', $material2);
        $manager->persist($material2);

        $material3 = new Material();
        $material3->setName('Крюк 6677/2');
        $material3->setCode($this->getReference('code1'));
        $this->addReference('material3', $material3);
        $manager->persist($material3);

        $manager->flush();
    }

    public function getOrder() {
        return 2; // the order in which fixtures will be loaded
    }

}
