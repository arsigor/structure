<?php

namespace PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine;

use PageBundle\Entity\Pages;
use PageBundle\Form\Type\PageType;

use MenuBundle\Entity\Routes;

class DefaultController extends Controller
{
    public function pagesAction(Request $request, $page, $perpage)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT p FROM PageBundle:Pages p ORDER BY p.creation ASC");
        $paginator  = $this->get('knp_paginator');
        $pages = $paginator->paginate(
            $query,
            $page,
            $request->query->getInt('limit', $perpage)
        );

        return $this->render('PageBundle:Default:page_view.html.twig',
            [
                'pages' => $pages,
                'page' => $page,
                'perpage' => $perpage
            ]);
    }

    public function pageCreateAction(Request $request)
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

                return $this->redirect($this->generateUrl('page'));
            }
        }
        return $this->render('PageBundle:Default:page_create.html.twig', array('form' => $form->createView()));
    }

    public function pageViewOneAction($slug)
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
        return $this->render('PageBundle:Default:view_one.html.twig', array('page' => $page));
    }

    /**
     * Edit object
     *
     * @I18nDoctrine
     */
    public function pageEditAction(Request $request, $id)
    {
        $page = $this->getDoctrine()->getRepository('PageBundle:Pages')->find($id);
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
                $route = $this->getDoctrine()->getRepository('MenuBundle:Routes')->findBy(
                    [
                        'module' => 'page',
                        'param_id' => $id
                    ])[0];
                $route->setParamSlug(json_encode($route_param_slug));
                $em = $this->getDoctrine()->getManager();
                $em->persist($route);
                $em->flush();
                // END ROUTE

                return $this->redirect($this->generateUrl('page'));
            }
        }
        return $this->render('PageBundle:Default:page_create.html.twig', array('form' => $form->createView()));
    }

    public function pageRemoveAction($id)
    {
        $page = $this->getDoctrine()->getRepository('PageBundle:Pages')->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($page);
        $em->flush();

        // REMOVE ROUTE FOR MAIN MENU
        $route = $this->getDoctrine()->getRepository('MenuBundle:Routes')->findBy(
            [
                'module' => 'page',
                'param_id' => $id
            ])[0];
        $em = $this->getDoctrine()->getManager();
        $em->remove($route);
        $em->flush();
        // END ROUTE

        return $this->redirect($this->generateUrl('page'));
    }
}
