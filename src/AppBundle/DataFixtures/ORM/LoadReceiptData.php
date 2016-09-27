<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Receipt;

class LoadReceiptData extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        $receipt = new Receipt();
        $receipt->setQuantity(50);
        $receipt->setMaterial($this->getReference('material1'));
        $receipt->setPrice(10);
        $receipt->setDate(new \DateTime(2016 - 04 - 10));
        $receipt->setDescription('Поступило 70 шайб');
        $receipt->setSupplier('ТМ "Шайба"');
        $manager->persist($receipt);

        $receipt2 = new Receipt();
        $receipt2->setQuantity(70);
        $receipt2->setMaterial($this->getReference('material2'));
        $receipt2->setPrice(5);
        $receipt2->setDate(new \DateTime(2016 - 04 - 05));
        $receipt2->setDescription('Поступило 70 болтов');
        $receipt2->setSupplier('ТМ "БОЛТ"');
        $manager->persist($receipt2);

        $receipt3 = new Receipt();
        $receipt3->setQuantity(20);
        $receipt3->setMaterial($this->getReference('material3'));
        $receipt3->setPrice(100);
        $receipt3->setDate(new \DateTime(2016 - 04 - 01));
        $receipt3->setDescription('Поступило 20 крюков');
        $receipt3->setSupplier('ТМ "Крюк"');
        $manager->persist($receipt3);

        $manager->flush();
    }

    public function getOrder() {
        return 4; // the order in which fixtures will be loaded
    }

}
