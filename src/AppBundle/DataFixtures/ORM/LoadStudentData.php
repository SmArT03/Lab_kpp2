<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Student;

class LoadStudentData extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        $student = new Student();
        $student->setName('Иванов Иван Иванович');
        $student->setSubject('кпп');
        $student->setMark(80);
        $student->setDate(new \DateTime(2017 - 03 - 23));
        $student->setDescription('хороший студент ');
        $manager->persist($student);

        $student2 = new Student();
        $student2->setName('Иванова Валентина Петровна');
        $student2->setSubject('кпп');
        $student2->setMark(75);
        $student2->setDate(new \DateTime(2017 - 03 - 25));
        $student2->setDescription('хорошая студентка ');
        $manager->persist($student2);

        $manager->flush();
    }

    public function getOrder() {
        return 1; // the order in which fixtures will be loaded
    }

}
