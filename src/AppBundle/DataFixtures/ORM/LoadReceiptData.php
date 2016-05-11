<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Receipt;


class LoadUserData  implements FixtureInterface {
    
    
    
    public function load(ObjectManager $manager)
    {
        $receipt = new Receipt();
        $receipt->setQuantity('70');
        $receipt->setMaterial('Болт 12\18');
        $receipt->setPrice('10');
        $receipt->setDate('2016-04-29');
        $receipt->setDescription('Поступило 70 болтов');
        $receipt->setSupplier('ТМ "БОЛТ"');

        $manager->persist($receipt);
        $manager->flush();
    }
    
    
    public function getOrder() {
        return 6; // the order in which fixtures will be loaded
    }
    
}
