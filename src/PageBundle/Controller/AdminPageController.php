<?php

namespace PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine;
use PageBundle\Entity\Pages;
use PageBundle\Form\Type\PageType;
use MenuBundle\Entity\Routes;

class AdminPageController extends Controller
{

    public function indexAction(Request $request, $page, $perpage)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT p FROM PageBundle:Pages p ORDER BY p.creation ASC");
        $paginator  = $this->get('knp_paginator');
        $pages = $paginator->paginate(
            $query,
            $page,
            $request->query->getInt('limit', $perpage)
        );

        return $this->render('PageBundle:Admin:page_index.html.twig',
            [
                'pages' => $pages,
                'page' => $page,
                'perpage' => $perpage
            ]);
    }

    public function createAction(Request $request)
    {
        $page = new Pages();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $data = $form->getData();
                $data->setCreation(new \DateTime("now"));

                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();

                // SET ROUTE FOR MAIN MENU
                $route_param_slug = array();
                foreach($data->getTranslations() as $item){
                    $route_param_slug[$item->getLocale()] = $item->getSlug();
                }
                $route = new Routes();
                $route->setModule('page');
                $route->setRoute('page_view_one');
                $route->setParamId($data->getId());
                $route->setParamSlug(json_encode($route_param_slug));
                $em = $this->getDoctrine()->getManager();
                $em->persist($route);
                $em->flush();
                // END ROUTE

                return $this->redirect($this->generateUrl('admin_page_index'));
            }
        }
        return $this->render('PageBundle:Admin:page_create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
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
