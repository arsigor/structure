<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseCategoryController extends Controller
{
    public function indexAction()
    {
        $category = $this->getDoctrine()->getRepository('BlogBundle:Posts')->findBy(
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
	if($this->getUser() != null)
	{
        $levels_arr = [];
        $level_to_view_user_arr = [];

        $levels = $this->getUser()->getLevels();
        foreach ($levels as $level){
            array_push($levels_arr, $level->getId());
        }
        $level_to_view_user = $this->getDoctrine()->getRepository('BlogBundle:CategoriesTranslation')
            ->findOneBySlug($slug)
            ->getTranslatable()
            ->getLevels();
        foreach ($level_to_view_user as $lu){
            array_push($level_to_view_user_arr, $lu->getId());
        }
        if(empty(array_intersect($level_to_view_user_arr, $levels_arr))){
            $error = 'Insufficient permissions to view this content';
            $post = null;
        }else{
            $post = $this->getDoctrine()->getRepository('BlogBundle:CategoriesTranslation')->findOneBySlug($slug);
            $error = '';
        }
	}else{
	    $error = 'Insufficient permissions to view this content';
            $post = null;
	}
        return $this->render('AppBundle:Base:category/view_one.html.twig',
            [
                'error'=> $error,
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
