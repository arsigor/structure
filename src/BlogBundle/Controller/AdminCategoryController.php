<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine;

use BlogBundle\Entity\Categories;
use BlogBundle\Form\Type\CategoryType;

use MenuBundle\Entity\Routes;

class AdminCategoryController extends Controller
{
    public function indexAction(Request $request, $page, $perpage)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT c FROM BlogBundle:Categories c ORDER BY c.id ASC");
        $paginator  = $this->get('knp_paginator');
        $pages = $paginator->paginate(
            $query,
            $page,
            $request->query->getInt('limit', $perpage)
        );

        return $this->render('BlogBundle:Admin:category_view.html.twig',
            [
                'pages' => $pages,
                'page' => $page,
                'perpage' => $perpage
            ]
        );
    }

    public function createAction(Request $request)
    {
        $form = $this->createForm(CategoryType::class, new Categories());
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $data = $form->getData();
                if($data->getPid() != NULL) {
                    $data->setParent($this->getDoctrine()->getRepository('BlogBundle:Categories')->find($data->getPid()));
                }
                $data->setCreation(new \DateTime("now"));
                $data->setModify(new \DateTime("now"));
                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();

                // SET ROUTE FOR MAIN MENU
                $route_param_slug = array();
                foreach($data->getTranslations() as $item){
                    $route_param_slug[$item->getLocale()] = $item->getSlug();
                }
                $route = new Routes();
                $route->setModule('category');
                $route->setRoute('category_view_one');
                $route->setParamId($data->getId());
                $route->setParamSlug(json_encode($route_param_slug));
                $em = $this->getDoctrine()->getManager();
                $em->persist($route);
                $em->flush();
                // END ROUTE

                return $this->redirect($this->generateUrl('admin_category_index'));
            }
        }
        return $this->render('BlogBundle:Admin:category_create.html.twig',
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
    public function editAction($id, Request $request)
    {
        $category = $this->getDoctrine()->getRepository('BlogBundle:Categories')->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $data = $form->getData();
                $data->setCreation($data->getCreation());
                $data->setModify(new \DateTime("now"));
                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();

                // SET ROUTE FOR MAIN MENU
                $route_param_slug = array();
                foreach($data->getTranslations() as $item){
                    $route_param_slug[$item->getLocale()] = $item->getSlug();
                }
                $route = $this->getDoctrine()->getRepository('MenuBundle:Routes')->findOneBy(
                    [
                        'module' => 'category',
                        'param_id' => $id,
                        'route' => 'category_view_one'
                    ]);
                $route->setParamSlug(json_encode($route_param_slug));
                $em = $this->getDoctrine()->getManager();
                $em->persist($route);
                $em->flush();
                // END ROUTE

                return $this->redirect($this->generateUrl('admin_category_index'));
            }
        }
        return $this->render('BlogBundle:Admin:category_create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function deleteAction($id)
    {
        $category = $this->getDoctrine()->getRepository('BlogBundle:Categories')->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        // REMOVE ROUTE FOR MAIN MENU
        $route = $this->getDoctrine()->getRepository('MenuBundle:Routes')->findOneBy(
            [
                'module' => 'category',
                'param_id' => $id,
                'route' => 'category_view_one'
            ]);
        if($route != null){
            $em = $this->getDoctrine()->getManager();
            $em->remove($route);
            $em->flush();
        }
        // END ROUTE

        return $this->redirect($this->generateUrl('admin_category_index'));
    }

}
