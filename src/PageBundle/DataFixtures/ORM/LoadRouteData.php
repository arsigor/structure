<?php

namespace PageBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MenuBundle\Entity\Routes;

class LoadRouteData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $route = new Routes();
        $route->setModule('page');
        $route->setRoute('page');

        $manager->persist($route);
        $manager->flush();
    }
}