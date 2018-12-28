<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{

    public function indexAction()
    {
        return $this->render('AppBundle:Base:index.html.twig');
    }

    public function carouselAction()
    {
        $carousels = $this->getDoctrine()->getRepository('InfoBundle:Carousels')->findAll();
        return $this->render('AppBundle:Base:carousel.html.twig',
            [
                'carousels' => $carousels
            ]
        );
    }

    public function reviewsAction()
    {
        $reviews = $this->getDoctrine()->getRepository('InfoBundle:Reviews')->findAll();

        return $this->render('AppBundle:Base:reviews.html.twig',
            [
                'reviews' => $reviews
            ]
        );
    }

    public function aboutAction()
    {
        $about = $this->getDoctrine()->getRepository('InfoBundle:Abouts')->findOneBy(['status' => true]);
        if($about){
            $seoPage = $this->container->get('sonata.seo.page');
            $seoPage
                ->setTitle($about->getSeoTitle())
                ->addMeta('name', 'keywords', $about->getSeoKeyword())
                ->addMeta('name', 'description', $about->getSeoDescription())
                ->addMeta('property', 'og:title', $about->getSeoTitle())
                ->addMeta('property', 'og:type', 'about')
                ->addMeta('property', 'og:description', $about->getSeoDescription())
            ;
        }
        return $this->render('AppBundle:Base:other_partials/about.html.twig',
            [
                'about' => $about
            ]
        );
    }

}
