<?php

namespace UsersBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UsersBundle\Entity\Users;
use MenuBundle\Entity\Routes;

class UsersFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $user = new Users();
        $user->setUsername('admin');
        $user->setEmail('admin@mail.com');
        $user->setPhone('+380111111111');
        $user->setEnabled(true);
        $user->setPassword('$2y$13$c/qO1tppoUrRHoDuWJFVEeJgmnLVyV1D9eQImIBsVZKoKNlkGqlXW');
        $user->setRoles(array("ROLE_ADMIN"));
        $user->setFirstname('ad');
        $user->setLastname('min');
        $user->setCreatedAt(new \DateTime("now"));
        $user->setUpdatedAt(new \DateTime("now"));

        $manager->persist($user);
        $manager->flush();

        //home page
        $route = new Routes();
        $route->setModule('app');
        $route->setRoute('homepage');
        $manager->persist($route);
        $manager->flush();

        //news page
        $route = new Routes();
        $route->setModule('news');
        $route->setRoute('news_view_all');
        $manager->persist($route);
        $manager->flush();

        // gallery page
        $route = new Routes();
        $route->setModule('galleries');
        $route->setRoute('galleries_index');
        $manager->persist($route);
        $manager->flush();
    }
}


