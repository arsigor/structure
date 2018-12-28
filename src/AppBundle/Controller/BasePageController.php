<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BasePageController extends Controller
{

    public function indexAction($slug)
    {
        $page = $this->getDoctrine()->getRepository('PageBundle:PagesTranslation')->findOneBySlug($slug);

        if($page){
            $seoPage = $this->container->get('sonata.seo.page');
            $seoPage
                ->setTitle($page->getSeoTitle())
                ->addMeta('name', 'keywords', $page->getSeoKeyword())
                ->addMeta('name', 'description', $page->getSeoDescription())
                ->addMeta('property', 'og:title', $page->getSeoTitle())
                ->addMeta('property', 'og:type', 'page')
                ->addMeta('property', 'og:url',  $this->generateUrl('page_view_one', array('slug' => $page->getSlug()),true))
                ->addMeta('property', 'og:description', $page->getSeoDescription())
            ;
        }
        return $this->render('AppBundle:Base:other_partials/view_one_page.html.twig',
            ['page' => $page]
        );
    }

}
