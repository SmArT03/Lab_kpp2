<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Code;

class LoadCodeData extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        $code = new Code();
        $code->setName('вал');
        $this->addReference('code1', $code);
        $manager->persist($code);

        $code2 = new Code();
        $code2->setName('резцы');
        $this->addReference('code2', $code2);
        $manager->persist($code2);

        $code3 = new Code();
        $code3->setName('двигатель');
        $this->addReference('code3', $code3);
        $manager->persist($code3);

        $manager->flush();
    }

    public function getOrder() {
        return 1; // the order in which fixtures will be loaded
    }

}
