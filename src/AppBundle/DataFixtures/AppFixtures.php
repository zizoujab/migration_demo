<?php
/**
 * Created by PhpStorm.
 * User: zjaballah
 * Date: 23/01/18
 * Time: 16:38
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        for($i=0 ; $i < 200 ; $i++){
            $user = new User();
            $user->setUsername('Username '. $i);
            $user->setEmail('Email '. $i);
            $user->setPassword('Password '. $i);
            $user->setContact([
                'phone' => 'phone '. $i ,
                'street' => 'street ' . $i ,
                'zip_code' => 'zip ' . $i
            ]);
            $manager->persist($user);
        }
        $manager->flush();


    }

}