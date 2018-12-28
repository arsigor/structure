<?php

namespace BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use BlogBundle\Entity\Categories;
use BlogBundle\Entity\CategoriesTranslation;

class CategoryFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
//        $category = new Categories();
//        $category->setPid(null);
//        $category->setModify(new \DateTime("now"));
//        $category->setCreation(new \DateTime("now"));
//
//        $trans = new CategoriesTranslation();
//        $trans->setTitle('Публікації');
//        $trans->setSlug('publikatsiyi');
//        $trans->setLocale('uk');
//        $category->addTranslation($trans);
//
//        $manager->persist($category);
//        $manager->flush();
    }

}