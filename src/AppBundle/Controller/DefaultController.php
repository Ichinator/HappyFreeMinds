<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\Videos;
use AdminBundle\Entity\VideosThemes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/entreprise", name="entreprise")
     */
    public function entrepriseAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/entreprise.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/video", name="video")
     */
    public function viedoAction(Request $request)
    {
        $videos = $this->getDoctrine()->getRepository(Videos::class)->findAll();
        $themes = $this->getDoctrine()->getRepository(VideosThemes::class)->findAll();
        return $this->render('default/video.html.twig', array('videos'=>$videos, 'themes'=>$themes));
    }
}
