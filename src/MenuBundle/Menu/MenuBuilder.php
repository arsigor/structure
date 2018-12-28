<?php

namespace MenuBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

use Doctrine\ORM\EntityManager;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function createFirstMenu(FactoryInterface $factory, array $options)
    {

        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $em = $this->container->get('doctrine')->getManager();
        $items = $em->getRepository('MenuBundle:Items')->findBy(['menu' => 1, 'pid' => NULL],['number' => 'ASC']);
        $menu = $this->getTreeMenu($menu, null, $items);
        return $menu;
    }
    public function createSecondMenu(FactoryInterface $factory, array $options)
    {

        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $em = $this->container->get('doctrine')->getManager();
        $items = $em->getRepository('MenuBundle:Items')->findBy(['menu' => 2, 'pid' => NULL],['number' => 'ASC']);
        $menu = $this->getTreeMenu($menu, null, $items);
        return $menu;
    }

    public function getTreeMenu($menu, $childItem, $items){
        foreach($items as $item){
            $locale = $item->getLocale();
            $title = $item->getTitle();
            if($item->getRoute()){
                $route = $item->getRoute()->getRoute();
                $uri = $item->getRoute()->getUri();
                $attributes_tag = $item->getRoute()->getAttributesTag();
                $paramId = $item->getRoute()->getParamId();
                $paramSlug = $item->getRoute()->getParamSlug();
            } else {
                $route = NULL;
                $paramId = NULL;
                $paramSlug = NULL;
            }
            $childrens = $item->getChildrens();
            if($childItem == null) {
                if (count($childrens) == 0) {
                    if ($paramSlug != '') {
                        $slug = json_decode($paramSlug, true)[$locale];
                        if($route != '') {
                            $menu->addChild($title, array(
                                'route' => $route,
                                'routeParameters' => array('slug' => $slug)
                            ));
                        } elseif($uri != ''){
                            $menu->addChild($title, array(
                                'uri' => $uri,
                                'linkAttributes' => ['id' => $attributes_tag],
                                'routeParameters' => array('slug' => $slug)
                            ));
                        }
                    } elseif ($paramId != '') {
                        if($route != '') {
                            $menu->addChild($title, array(
                                'route' => $route,
                                'routeParameters' => array('id' => $paramId)
                            ));
                        } elseif($uri != ''){
                            $menu->addChild($title, array(
                                'uri' => $uri,
                                'linkAttributes' => ['id' => $attributes_tag],
                                'routeParameters' => array('id' => $paramId)
                            ));
                        }
                    } else {
                        if($route != '') {
                            $menu->addChild($title, array(
                                'route' => $route,
                            ));
                        } elseif($uri != ''){
                            $menu->addChild($title, array(
                                'uri' => $uri,
                                'linkAttributes' => ['id' => $attributes_tag],
                            ));
                        }
                    }
                } else {
                    $menu->addChild($title)->setAttribute('dropdown', true);
                    $menu = $this->getTreeMenu($menu, $menu[$title],$childrens);
                }
            } else {
                if (count($childrens) == 0) {
                    if ($paramSlug != '') {
                        $slug = json_decode($paramSlug, true)[$locale];
                        $childItem->addChild($title, array(
                            'route' => $route,
                            'routeParameters' => array('slug' => $slug)
                        ));
                    } elseif ($paramId != '') {
                        $childItem->addChild($title, array(
                            'route' => $route,
                            'routeParameters' => array('id' => $paramId)
                        ));
                    } else {
                        $childItem->addChild($title, array(
                            'route' => $route
                        ));
                    }
                } else {
                    $childItem->addChild($title)->setAttribute('dropdown', true);
                    $menu = $this->getTreeMenu($menu, $childItem[$title],$childrens);
                }
            }
        }
        return $menu;
    }

//    public function getTreeMenu($menu, $childItem, $items){
//        dump($menu);
//        foreach($items as $item){
//            $locale = $item->getLocale();
//            $title = $item->getTitle();
//            if($item->getRoute()){
//                $route = $item->getRoute()->getRoute();
//                $uri = $item->getRoute()->getUri();
//                $rel = $item->getRoute()->getRel();
//                $target = $item->getRoute()->getTarget();
//                $paramId = $item->getRoute()->getParamId();
//                $paramSlug = $item->getRoute()->getParamSlug();
//            } else {
//                $route = NULL;
//                $paramId = NULL;
//                $paramSlug = NULL;
//            }
//            $childrens = $item->getChildrens();
//            if($childItem == null) {
//                if (count($childrens) == 0) {
//                    if ($paramSlug != '') {
//                        $slug = json_decode($paramSlug, true)[$locale];
//                        $menu->addChild($title, array(
//                            'route' => $route,
//                            'routeParameters' => array('slug' => $slug)
//                        ));
//                    } elseif ($paramId != '') {
//                        $menu->addChild($title, array(
//                            'route' => $route,
//                            'routeParameters' => array('id' => $paramId)
//                        ));
//                    } else {
//                        $menu->addChild($title, array(
//                            'route' => $route
//                        ));
//                    }
//                } else {
//                    $menu->addChild($title)->setAttribute('dropdown', true);
//                    $menu = $this->getTreeMenu($menu, $menu[$title],$childrens);
//                }
//            } else {
//                if (count($childrens) == 0) {
//                    if ($paramSlug != '') {
//                        $slug = json_decode($paramSlug, true)[$locale];
//                        $childItem->addChild($title, array(
//                            'route' => $route,
//                            'routeParameters' => array('slug' => $slug)
//                        ));
//                    } elseif ($paramId != '') {
//                        $childItem->addChild($title, array(
//                            'route' => $route,
//                            'routeParameters' => array('id' => $paramId)
//                        ));
//                    } else {
//                        $childItem->addChild($title, array(
//                            'route' => $route
//                        ));
//                    }
//                } else {
//                    $childItem->addChild($title)->setAttribute('dropdown', true);
//                    $menu = $this->getTreeMenu($menu, $childItem[$title],$childrens);
//                }
//            }
//        }
//        return $menu;
//    }
}