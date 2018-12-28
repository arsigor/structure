<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseGalleriesController extends Controller
{
    //Index
    public function indexAction()
    {
        $galleries = $this->getDoctrine()->getRepository('GalleryBundle:Gallery')->findBy(['show_gallery' => 0],['creation'=>'ASC'],20);
//        $videos = $this->getDoctrine()->getRepository('GalleryBundle:GalleryVideos')->findBy([],['creation'=>'ASC'],4);
//        foreach ($videos as $video){
//            $url = $video->getTranslatable()->getUri();
//            $parsed_url = parse_url($url);
//            parse_str($parsed_url['query'], $parsed_query);
//            $iframe = $parsed_query['v'];
//            $video->iframe = $iframe;
//        }

        return $this->render('AppBundle:Base:galleries/index.html.twig',
            [
                'galleries' => $galleries,
//                'videos' => $videos
            ]
        );
    }

    //Video
    public function viewAllVideoAction(Request $request, $page, $perpage)
    {
        $query = $this->getDoctrine()->getRepository('GalleryBundle:GalleryVideos')->findAll();
        foreach ($query as $video){
            $url = $video->getTranslatable()->getUri();
            $parsed_url = parse_url($url);
            parse_str($parsed_url['query'], $parsed_query);
            $iframe = $parsed_query['v'];
            $video->iframe = $iframe;
        }
        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $query,
            $page,
            $request->query->getInt('limit', $perpage)
        );

        return $this->render('AppBundle:Base:galleries/video/view_all.html.twig',
            [
                'posts' => $posts,
                'page' => $page,
                'perpage' => $perpage
            ]
        );
    }

    public function viewOneVideoAction($slug)
    {
        $video = $this->getDoctrine()->getRepository('GalleryBundle:GalleryVideosTranslation')->findOneBySlug($slug);
        $url = $video->getTranslatable()->getUri();
        $parsed_url = parse_url($url);
        parse_str($parsed_url['query'], $parsed_query);
        $iframe = $parsed_query['v'];

        return $this->render('AppBundle:Base:galleries/video/view_one.html.twig',
            [
                'video' => $video,
                'iframe' => $iframe

            ]
        );
    }

    //Pictures
    public function viewAllPictureAction(Request $request, $page, $perpage)
    {
        $query = $this->getDoctrine()->getRepository('GalleryBundle:Gallery')->findBy(['show_gallery' => 0],['creation'=>'ASC']);
        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $query,
            $page,
            $request->query->getInt('limit', $perpage)
        );

        return $this->render('AppBundle:Base:galleries/picture/view_all.html.twig',
            [
                'posts' => $posts,
                'page' => $page,
                'perpage' => $perpage
            ]
        );
    }

    public function viewOnePictureAction($slug)
    {
        $gallery = $this->getDoctrine()->getRepository('GalleryBundle:GalleryTranslation')->findOneBySlug($slug);

        return $this->render('AppBundle:Base:galleries/picture/view_one.html.twig',
            [
                'gallery' => $gallery
            ]
        );
    }

}
