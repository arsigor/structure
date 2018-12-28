<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseNewsController extends Controller
{
    public function indexAction()
    {
        $news = $this->getDoctrine()->getRepository('BlogBundle:Posts')->findBy(
            ['category_id' => 2],
            [ 'begin_date'=>'DESC'],
            4
        );

        return $this->render('AppBundle:Base:news/index.html.twig',
            [
                'news' => $news
            ]
        );
    }

    public function viewAllAction(Request $request, $page, $perpage)
    {
        $query = $this->getDoctrine()->getRepository('BlogBundle:Posts')->findBy(
            ['category_id' => 2],
            [ 'begin_date'=>'DESC']
        );
        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $query,
            $page,
            $request->query->getInt('limit', $perpage)
        );

        return $this->render('AppBundle:Base:news/view_all.html.twig',
            [
                'posts' => $posts,
                'page' => $page,
                'perpage' => $perpage
            ]
        );
    }

    public function viewOneAction($slug)
    {
        $post = $this->getDoctrine()->getRepository('BlogBundle:PostsTranslation')->findOneBySlug($slug);

        return $this->render('AppBundle:Base:news/view_one.html.twig',
            [
                'post' => $post
            ]
        );
    }

    public function readAlsoAction($id)
    {
        $news = $this->getDoctrine()->getRepository('BlogBundle:Posts')->getReadAlso($id);

        return $this->render('AppBundle:Base:news/read_also.html.twig',
            [
                'news' => $news
            ]
        );
    }

}
