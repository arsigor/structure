<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine;

use BlogBundle\Entity\Posts;
use BlogBundle\Form\Type\PostType;
use MenuBundle\Entity\Routes;

class AdminPostController extends Controller
{

    public function postsAction(Request $request, $category_id, $page, $perpage)
    {
        $em = $this->getDoctrine()->getManager();
        if($category_id != null){
            if($category_id == 4) {
                $categories = $this->getDoctrine()->getRepository('BlogBundle:Categories')->findBy(['pid' => $category_id]);
                $categories_id = [];
                foreach ($categories as $category) {
                    $categories_id[].= $category->getId();
                }
                $category_id = implode(",", $categories_id);
            }
            $query = $em->createQuery("SELECT p FROM BlogBundle:Posts p WHERE p.category IN ($category_id) ORDER BY p.creation DESC");
        }else{
            $query = $em->createQuery("SELECT p FROM BlogBundle:Posts p ORDER BY p.creation DESC");
        }
        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $query,
            $page,
            $request->query->getInt('limit', $perpage)
        );

        return $this->render('BlogBundle:Admin:post_view.html.twig',
            [
                'posts' => $posts,
                'page' => $page,
                'perpage' => $perpage
            ]);
    }

    public function postCreateAction(Request $request)
    {
        $module = null;
        $form = $this->createForm(PostType::class, new Posts());
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $data = $form->getData();
                $data->setCreation(new \DateTime("now"));
                $data->setCategory($this->getDoctrine()->getRepository('BlogBundle:Categories')->find($data->getCategoryId()));
                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();

                $post_id = $data->getId();
                if($data->getPath1() != null or $data->getPath2() != null){
                    if(!is_dir("data/news")){mkdir("data/news", 0755);}
                    if(!is_dir("data/news/".$data->getId())){mkdir("data/news/".$post_id, 0755);}
                }

//                // SET ROUTE FOR MAIN MENU
//                if($data->getCategoryId() == 3){
//                    $route_param_slug = array();
//                    foreach($data->getTranslations() as $item){
//                        $route_param_slug[$item->getLocale()] = $item->getSlug();
//                    }
//                    $route = new Routes();
//                    $route->setModule('services');
//                    $route->setRoute('services_view_one');
//                    $route->setParamId($data->getId());
//                    $route->setParamSlug(json_encode($route_param_slug));
//                    $em = $this->getDoctrine()->getManager();
//                    $em->persist($route);
//                    $em->flush();
//                }
//                // END ROUTE


                return $this->redirect($this->generateUrl('admin_blog_posts'));
            }
        }
        return $this->render('BlogBundle:Admin:post_create.html.twig', array('form' => $form->createView()));
    }

    /**
     * Edit object
     *
     * @I18nDoctrine
     */
    public function postEditAction($id, Request $request)
    {
        $post = $this->getDoctrine()->getRepository('BlogBundle:Posts')->find($id);

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $data = $form->getData();
                $data->setCategory($this->getDoctrine()->getRepository('BlogBundle:Categories')->find($data->getCategoryId()));
                $data->setCreation(new \DateTime("now"));
                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();

//                // SET ROUTE FOR MAIN MENU
//                if($data->getCategoryId() == 3){
//                    $route_param_slug = array();
//                    foreach($data->getTranslations() as $item){
//                        $route_param_slug[$item->getLocale()] = $item->getSlug();
//                    }
//                    $route = $this->getDoctrine()->getRepository('MenuBundle:Routes')->findBy(
//                        [
//                            'module' => 'services',
//                            'param_id' => $id
//                        ])[0];
//                    $route->setParamSlug(json_encode($route_param_slug));
//                    $em = $this->getDoctrine()->getManager();
//                    $em->persist($route);
//                    $em->flush();
//                }

                return $this->redirect($this->generateUrl('admin_blog_posts'));
            }
        }
        return $this->render('BlogBundle:Admin:post_create.html.twig', array(
            'form' => $form->createView(),
            'post_id' => $id
        ));
    }

    public function postRemoveAction($id)
    {

        $post = $this->getDoctrine()->getRepository('BlogBundle:Posts')->find($id);
//        // REMOVE ROUTE FOR MAIN MENU
//        if($post->getCategoryId() == 3) {
//            $route = $this->getDoctrine()->getRepository('MenuBundle:Routes')->findOneBy(
//            [
//                'module' => 'services',
//                'param_id' => $id,
//                'route' => 'services_view_one'
//            ]);
//            if($route != null){
//                $em = $this->getDoctrine()->getManager();
//                $em->remove($route);
//                $em->flush();
//            }
//        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $directory =  __DIR__.'/../../../web/data/news/'.$id;

        if(is_dir("$directory")){
            array_map('unlink', glob("$directory/*.*"));
            rmdir($directory);
        }

        return $this->redirect($this->generateUrl('admin_blog_posts'));
    }
}
