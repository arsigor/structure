<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine;
use BlogBundle\Entity\Levels;
use BlogBundle\Form\Type\LevelType;

class AdminLevelController extends Controller
{
    public function indexAction(Request $request, $page, $perpage)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT c FROM BlogBundle:Levels c ORDER BY c.id ASC");
        $paginator  = $this->get('knp_paginator');
        $pages = $paginator->paginate(
            $query,
            $page,
            $request->query->getInt('limit', $perpage)
        );

        return $this->render('BlogBundle:Admin:level_view.html.twig',
            [
                'pages' => $pages,
                'page' => $page,
                'perpage' => $perpage
            ]
        );
    }

    public function createAction(Request $request)
    {
        $form = $this->createForm(LevelType::class, new Levels());
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $data = $form->getData();
                $data->setCreation(new \DateTime("now"));
                $data->setModify(new \DateTime("now"));
                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();

                return $this->redirect($this->generateUrl('admin_level_index'));
            }
        }
        return $this->render('BlogBundle:Admin:level_create.html.twig',
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
        $level = $this->getDoctrine()->getRepository('BlogBundle:Levels')->find($id);
        $form = $this->createForm(LevelType::class, $level);
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

                return $this->redirect($this->generateUrl('admin_level_index'));
            }
        }
        return $this->render('BlogBundle:Admin:level_create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function deleteAction($id)
    {
        $level = $this->getDoctrine()->getRepository('BlogBundle:Levels')->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($level);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_level_index'));
    }

    public function searchLevelsAction(Request $request)
    {
        $search = $request->get('q');
        $levels = $this->getDoctrine()->getRepository('BlogBundle:Levels')->getLevels($search);
        $result = array();
        foreach ($levels as $level) {
            $result[] = [
                'id'   => $level->getTranslatable()->getId(),
                'text' => $level->getTitle()
            ];
        }
        return new Response(json_encode($result));
    }

}
