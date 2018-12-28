<?php

namespace MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine;

use MenuBundle\Entity\Items;
use MenuBundle\Form\Type\ItemType;
use MenuBundle\Form\Type\RouteType;

class DefaultController extends Controller
{
    public function menuItemsAction(Request $request, $page, $perpage)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT i FROM MenuBundle:Items i WHERE i.pid IS NULL ORDER BY i.number ASC");
        $paginator  = $this->get('knp_paginator');
        $items = $paginator->paginate(
            $query,
            $page,
            $request->query->getInt('limit', $perpage)
        );

        return $this->render('MenuBundle:Default:item_view.html.twig',
            [
                'items' => $items,
                'page' => $page,
                'perpage' => $perpage
            ]);
    }

    public function menuItemRouteAction(Request $request, $page, $perpage)
    {
        $module = NULL;
        $form = $this->createForm(RouteType::class, NULL);
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST') {
            if ($form->isValid()) {
                $module = $form['module']->getData();
            }
        }

        $em = $this->getDoctrine()->getManager();
        if($module == NULL) {
            $query = $em->createQuery("SELECT r FROM MenuBundle:Routes r LEFT JOIN r.item i WHERE i.route IS NULL");
        } else {
            $query = $em->createQuery("SELECT r FROM MenuBundle:Routes r LEFT JOIN r.item i WHERE r.module='$module' AND i.route IS NULL");
        }
        $paginator  = $this->get('knp_paginator');
        $routes = $paginator->paginate(
            $query,
            $page,
            $request->query->getInt('limit', $perpage)
        );

        return $this->render('MenuBundle:Default:route_view.html.twig',
            [
                'form' => $form->createView(),
                'routes' => $routes,
                'page' => $page,
                'perpage' => $perpage
            ]);
    }

    public function menuItemCreateAction(Request $request, $id)
    {
        $item = new Items();
        if($id != NULL) {
            $item->setRoute($this->getDoctrine()->getRepository('MenuBundle:Routes')->find($id));
        }
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $data = $form->getData();
                if($data->getPid() != NULL) {
                    $data->setParent($this->getDoctrine()->getRepository('MenuBundle:Items')->find($data->getPid()));
                }
                $data->setCreation(new \DateTime("now"));

                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();

                return $this->redirect($this->generateUrl('menu'));
            }
        }
        return $this->render('MenuBundle:Default:item_create.html.twig', array('form' => $form->createView()));
    }

    /**
     * Edit object
     *
     * @I18nDoctrine
     */
    public function menuItemEditAction(Request $request, $id)
    {
        $item = $this->getDoctrine()->getRepository('MenuBundle:Items')->find($id);
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $data = $form->getData();
                if($data->getPid() != NULL) {
                    $data->setParent($this->getDoctrine()->getRepository('MenuBundle:Items')->find($data->getPid()));
                }
                $data->setCreation(new \DateTime("now"));

                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();

                return $this->redirect($this->generateUrl('menu'));
            }
        }
        return $this->render('MenuBundle:Default:item_create.html.twig', array('form' => $form->createView()));
    }

    public function menuItemRemoveAction($id)
    {
        $item = $this->getDoctrine()->getRepository('MenuBundle:Items')->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();
        return $this->redirect($this->generateUrl('menu'));
    }
}
