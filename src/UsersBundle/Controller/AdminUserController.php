<?php

namespace UsersBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use UsersBundle\Form\Type\UserType;
use UsersBundle\Form\Type\SearchType;

class AdminUserController extends Controller
{
    public function indexAction(Request $request, $page, $perpage)
    {
        $form = $this->createForm(SearchType::class, NULL);
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST') {
            if ($form->isValid()) {
                $word = $form['search']->getData();
                $query = $this->getDoctrine()->getRepository('UsersBundle:Users')->findUsers($word);
                $paginator = $this->get('knp_paginator');
                $users = $paginator->paginate(
                    $query,
                    $page,
                    $request->query->getInt('limit', $perpage));
            }
        } else {
            $query = $this->getDoctrine()->getRepository('UsersBundle:Users')->findAll();
            $paginator = $this->get('knp_paginator');
            $users = $paginator->paginate(
                $query,
                $page,
                $request->query->getInt('limit', $perpage));
        }

        return $this->render('UsersBundle:Admin:user_index.html.twig',
            [
                'users' => $users,
                'page' => $page,
                'perpage' => $perpage,
                'form' => $form->createView()
            ]
        );
    }

    public function infoAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
        } else {
            $user = null;
        }
        return $this->render('UsersBundle:Admin:user_admin_info.html.twig', array('user' => $user));
    }

    public function editAction(Request $request,$id)
    {
        $user = $this->getDoctrine()->getRepository('UsersBundle:Users')->find($id);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $data = $form->getData();
                $password = $form['new_password']->getData();
                if($password){
                    $encoder = $this->container->get('security.password_encoder');
                    $encoded = $encoder->encodePassword($user, $password);
                    $data->setPassword($encoded);
                }
                $data->setUpdatedAt(new \DateTime("now"));
                $data->setRoles(array($data->getRole()));

                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();

                $user_id = $data->getId();
                if(!is_dir("data/users")){mkdir("data/users", 0755);}
                if(!is_dir("data/users/".$data->getId())){mkdir("data/users/".$user_id, 0755);}

                return $this->redirect($this->generateUrl('admin_users_view_all'));
            }
        }


        return $this->render('UsersBundle:Admin:user_edit.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user
            ]
        );
    }

    public function deletePhotoAction($id)
    {
        if($id == 0){$id = $this->get('security.token_storage')->getToken()->getUser()->getId();}

        $user = $this->getDoctrine()->getRepository('UsersBundle:Users')->find($id);
        $file = $user->getPath();
        $user->setPath(NULL);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        if(is_file(__DIR__.'/../../../web/data/users/'.$id.'/'.$file)){
            unlink (__DIR__.'/../../../web/data/users/'.$id.'/'.$file);
        }

        return $this->redirect($this->generateUrl('admin_user_edit', array('id'=>$id)));

    }

    public function deleteAction($id)
    {
        $user = $this->getDoctrine()->getRepository('UsersBundle:Users')->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $directory =  __DIR__.'/../../../web/data/users/'.$id;
        if(is_dir("$directory")){
            array_map('unlink', glob("$directory/*.*"));
            rmdir($directory);
        }

        return $this->redirect($this->generateUrl('admin_users_view_all'));
    }

}
