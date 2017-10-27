<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/28 0028
 * Time: 4:51
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("kendoctor");
        $user->setEmail("aywhenamolly@gmail.com");
        $user->setPlainPassword("123456");
        $user->setEnabled(true);
        $user->setSuperAdmin(true);

        $user_manager = $this->container->get('fos_user.user_manager');
        $user_manager->updateUser($user);


    }
}