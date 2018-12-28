<?php

namespace SitemapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $xml = simplexml_load_file('sitemap.xml');
        $content = [];
        foreach ($xml as $x) {
            $item = [];
            foreach ($x as $xx) {
                $item[] .= $xx;
            }
            array_push($content, $item);
        }

        return $this->render('SitemapBundle:Default:index.html.twig',
            ['content'=>$content]
        );
    }

    public function createAction()
    {
        $urls = [];
        $locales = $this->getParameter('locales');
        $this->getDoctrine()->getManager()->getFilters()->disable('oneLocale');
        $hostname = $_SERVER["HTTP_HOST"];
        $posts = $this->getDoctrine()->getRepository('BlogBundle:Posts')->findAll();
        $photos = $this->getDoctrine()->getRepository('GalleryBundle:Gallery')->findAll();
        $videos = $this->getDoctrine()->getRepository('GalleryBundle:GalleryVideos')->findAll();
        foreach ($locales as $l) {
            $urls[] = [
                'loc' => $this->get('router')->generate('homepage', ['_locale' => $l]),
                'lastmod' => new DateTime(),
                'changefreq' => 'monthly',
                'priority' => '1.0'
            ];
        }
        foreach ($posts as $p) {
            $urls[] = [
                'loc' => $this->get('router')->generate('news_view_one', ['slug' => $p->getSlug(), '_locale' => $p->getLocale()]),
                'lastmod'=> $p->getTranslatable()->getCreation(),
                'changefreq'=>'monthly',
                'priority'=> '0.5'
            ];
        }
        foreach ($photos as $p) {
            $urls[] = [
                'loc' => $this->get('router')->generate('galleries_pictures_view_one', ['slug' => $p->getSlug(), '_locale' => $p->getLocale()]),
                'lastmod'=> $p->getTranslatable()->getCreation(),
                'changefreq'=>'monthly',
                'priority'=> '0.5'
            ];
        }
        foreach ($videos as $p) {
            $urls[] = [
                'loc' => $this->get('router')->generate('galleries_video_view_one', ['slug' => $p->getSlug(), '_locale' => $p->getLocale()]),
                'lastmod'=> $p->getTranslatable()->getCreation(),
                'changefreq'=>'monthly',
                'priority'=> '0.5'
            ];
        }
//        create file sitemap.xml into web folder
        $fileLocation = getenv("DOCUMENT_ROOT") . "/sitemap.xml";
        $file = fopen($fileLocation,"w");
        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset
            xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        foreach ($urls as $url){
            $content .= '<url>';
            $content .= '<loc>http://'.$hostname.$url['loc'].'</loc>';
            $content .= '<lastmod>'.$url['lastmod']->format('Y-m-d\\TH:i:sP').'</lastmod>';
            $content .= '<changefreq>'.$url['changefreq'].'</changefreq>';
            $content .= '<priority>'.$url['priority'].'</priority>';
            $content .= '</url>';
        }

        $content .= '</urlset>';
        fwrite($file,$content);
        fclose($file);
//        end created file sitemap.xml
        $this->getDoctrine()->getManager()->getFilters()->enable('oneLocale');

        return $this->redirectToRoute('admin_sitemap_index');

    }
}
