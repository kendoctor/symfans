<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/28 0028
 * Time: 5:26
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $subject = new Subject();
            $subject->setTitle("learn php". $i);
            $subject->setBrief("learn php brief". $i);
            $subject->setBody("learn php body". $i);
            $subject->setPrice(10.11);
            $subject->setCreatedBy($this->getReference("kendoctor"));
            $manager->persist($subject);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }


}