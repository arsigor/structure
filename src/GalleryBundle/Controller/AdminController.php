<?php

namespace GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use GalleryBundle\Entity\Gallery;
use GalleryBundle\Entity\GalleryImages;
use GalleryBundle\Form\Type\GalleryType;
use GalleryBundle\Form\Type\GalleryImagesType;
use GalleryBundle\Form\Type\ImageType;
use GalleryBundle\Entity\GalleryVideos;
use GalleryBundle\Form\Type\GalleryVideosType;
use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine;


class AdminController extends Controller
{
    // PHOTO

    public function indexAction($page, $perpage, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT g FROM GalleryBundle:Gallery g ORDER BY g.creation DESC");
        $paginator  = $this->get('knp_paginator');
        $gallery = $paginator->paginate(
            $query,
            $page,
            $request->query->getInt('limit', $perpage)
        );

        return $this->render("GalleryBundle:Admin:index.html.twig", array('gallery'=>$gallery, 'page' => $page, 'perpage' => $perpage));
    }

    public function createAction(Request $request)
    {
        $form = $this->createForm(GalleryType::class, new Gallery());
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

                return $this->redirect($this->generateUrl('admin_gallery'));
            }
        }
        return $this->render("GalleryBundle:Admin:gallery_create.html.twig", array('form' => $form->createView()));
    }

    public function editAction($id, Request $request)
    {
        $gallery = $this->getDoctrine()->getRepository('GalleryBundle:Gallery')->find($id);
        $form = $this->createForm(GalleryType::class, $gallery);
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

                return $this->redirect($this->generateUrl('admin_gallery'));
            }
        }
        return $this->render("GalleryBundle:Admin:gallery_create.html.twig", array('form' => $form->createView()));
    }

    public function removeAction($id)
    {
        $gallery = $this->getDoctrine()->getRepository('GalleryBundle:Gallery')->find($id);
        $images = $gallery->getImages();
        foreach($images as $img){
            $path = $img->getPath();
            unlink(__DIR__.'/../../../web/data/images/gallery/'.$path);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($gallery);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_gallery'));
    }


    # GALLERY IMAGE
    public function createGalleryImageAction(Request $request)
    {

        $form = $this->createForm(GalleryType::class, new Gallery());
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $data = $form->getData();
                foreach($data->getFiles() as $file) {
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move(__DIR__.'/../../../web/data/images/gallery/',$fileName);

                    $image = new GalleryImages();
                    $image->setTitle($file->getClientOriginalName());
                    $image->setPath($fileName);
                    $image->setCreation(new \DateTime("now"));

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($image);
                    $em->flush();

                }
                return $this->redirect($this->generateUrl('gallery'));
            }
        }
        return $this->render("GalleryBundle:Admin:gallery_create.html.twig", array('form' => $form->createView()));
    }



    public function indexImagesAction($id, $page, $perpage, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $gallery = $this->getDoctrine()->getRepository('GalleryBundle:Gallery')->find($id);
        $query = $em->createQuery("SELECT g FROM GalleryBundle:GalleryImages g WHERE g.gallery_id=$id ORDER BY g.id ASC");
        $paginator  = $this->get('knp_paginator');
        $images = $paginator->paginate(
            $query,
            $page,
            $request->query->getInt('limit', $perpage)
        );

        $form = $this->createForm(GalleryImagesType::class, new GalleryImages());
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $data = $form->getData();
                foreach($data->getFiles() as $file) {
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move(__DIR__.'/../../../web/data/images/gallery/',$fileName);

                    $image = new GalleryImages();
                    $image->setGallery($gallery);
                    $image->setTitle($file->getClientOriginalName());
                    $image->setPath($fileName);
                    $image->setCreation(new \DateTime("now"));

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($image);
                    $em->flush();

                }
                return $this->redirect($this->generateUrl('admin_gallery_images', ['id' => $id, 'page' => $page, 'perpage' => $perpage]));
            }
        }
        return $this->render("GalleryBundle:Admin:index_images.html.twig", array('form' => $form->createView(), 'images'=>$images, 'page' => $page, 'perpage' => $perpage));
    }

    public function editImageAction($id, $page, $perpage, Request $request)
    {
        $image = $this->getDoctrine()->getRepository('GalleryBundle:GalleryImages')->find($id);
        $gallery_id = $image->getGalleryId();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $data = $form->getData();
                $file = $data->getFile();
                if($file != NULL){
                    $path = $data->getPath();
                    if(is_file(__DIR__.'/../../../web/data/images/gallery/'.$path)){
                        unlink (__DIR__.'/../../../web/data/images/gallery/'.$path);
                    }
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move(__DIR__.'/../../../web/data/images/gallery/',$fileName);
                    $image->setPath($fileName);
                    if($data->getTitle() == NULL){
                        $image->setTitle($file->getClientOriginalName());
                    }
                }
                $image->setCreation(new \DateTime("now"));

                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->flush();

                return $this->redirect($this->generateUrl('admin_gallery_images', ['id' => $gallery_id, 'page' => $page, 'perpage' => $perpage]));
            }

        }
        return $this->render("GalleryBundle:Admin:gallery_image_edit.html.twig", array('form' => $form->createView()));
    }

    public function removeImageAction($id, $page, $perpage)
    {
        $image = $this->getDoctrine()->getRepository('GalleryBundle:GalleryImages')->find($id);
        $gallery_id = $image->getGalleryId();
        $path = $image->getPath();
        if(is_file(__DIR__.'/../../../web/data/images/gallery/'.$path)){
            unlink (__DIR__.'/../../../web/data/images/gallery/'.$path);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_gallery_images', ['id' => $gallery_id, 'page' => $page, 'perpage' => $perpage]));
    }

    // VIDEO

    public function videoAction(Request $request, $page, $perpage)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT v FROM GalleryBundle:GalleryVideos v ORDER BY v.creation DESC");
        $paginator  = $this->get('knp_paginator');
        $videos = $paginator->paginate(
            $query,
            $page,
            $request->query->getInt('limit', $perpage)
        );

        return $this->render('GalleryBundle:Admin:gallery_video_view.html.twig',
            [
                'videos' => $videos,
                'page' => $page,
                'perpage' => $perpage
            ]);
    }

    public function videoCreateAction(Request $request)
    {
        $video = new GalleryVideos();
        $form = $this->createForm(GalleryVideosType::class, $video);
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

                return $this->redirect($this->generateUrl('admin_gallery_video_view'));
            }
        }
        return $this->render('GalleryBundle:Admin:gallery_video_create.html.twig', array('form' => $form->createView()));
    }

    public function videoViewOneAction($id)
    {
        $video = $this->getDoctrine()->getRepository('GalleryBundle:GalleryVideos')->find($id);
        $url = $video->getUri();
        $parsed_url = parse_url($url);
        parse_str($parsed_url['query'], $parsed_query);
        $iframe = $parsed_query['v'];

        return $this->render('GalleryBundle:Admin:gallery_video_view_one.html.twig',
            [
                'video' => $video,
                'iframe' => $iframe

            ]
        );
    }

    /**
     * Edit object
     *
     * @I18nDoctrine
     */
    public function videoEditAction(Request $request, $id)
    {
        $video = $this->getDoctrine()->getRepository('GalleryBundle:GalleryVideos')->find($id);
        $form = $this->createForm(GalleryVideosType::class, $video);
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

                return $this->redirect($this->generateUrl('admin_gallery_video_view'));
            }
        }
        return $this->render('GalleryBundle:Admin:gallery_video_create.html.twig', array('form' => $form->createView()));
    }

    public function videoRemoveAction($id)
    {
        $video = $this->getDoctrine()->getRepository('GalleryBundle:GalleryVideos')->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($video);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_gallery_video_view'));
    }
}
