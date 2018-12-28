<?php

namespace MenuBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MenuBundle\Entity\Routes;

class LoadRouteData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
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