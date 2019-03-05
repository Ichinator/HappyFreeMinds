<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Videos;
use AdminBundle\Entity\VideosThemes;
use AdminBundle\Form\VideosThemesType;
use AdminBundle\Form\VideosType;
use PlanningBundle\Entity\Ateliers;
use PlanningBundle\Entity\Conferences;
use PlanningBundle\Form\AteliersType;
use PlanningBundle\Form\ConferencesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function createAteliersAction(Request $request)
    {
        $ateliers = new Ateliers();
        $form = $this->createForm(AteliersType::class, $ateliers);

        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($ateliers);
            $em->flush();
            return $this->redirectToRoute('admin_homepage');
        }

        $formView = $form->createView();
        return $this->render('AdminBundle:Default:ateliers.html.twig', array('form'=>$formView));
    }

    public function indexAction(){
        return $this->render('AdminBundle:Default:index.html.twig');
    }

    public function allAteliersAction(){
        $ateliers = $this->getDoctrine()->getRepository(Ateliers::class)->findAll();
        return $this->render('AdminBundle:Default:allAteliers.html.twig', array('ateliers'=>$ateliers));
    }

    public function removeAteliersAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository(Ateliers::class)->remove($id);
        return $this->redirectToRoute('allAteliers');
    }

    public function modifyAteliersAction(Request $request, $id)
    {
        $ateliers = $this->getDoctrine()->getRepository(Ateliers::class)->find($id);
        $form = $this->createForm(AteliersType::class, $ateliers);

        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($ateliers);
            $em->flush();
            return $this->redirectToRoute('allAteliers');
        }

        $formView = $form->createView();
        return $this->render('AdminBundle:Default:modifyAteliers.html.twig', array('form'=>$formView));
    }






    public function createConferencesAction(Request $request)
    {
        $conferences = new Conferences();
        $form = $this->createForm(ConferencesType::class, $conferences);

        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($conferences);
            $em->flush();
            return $this->redirectToRoute('admin_homepage');
        }

        $formView = $form->createView();
        return $this->render('AdminBundle:Default:ateliers.html.twig', array('form'=>$formView));
    }


    public function allConferencesAction(){
        $conferences = $this->getDoctrine()->getRepository(Conferences::class)->findAll();
        return $this->render('AdminBundle:Default:allConferences.html.twig', array('conferences'=>$conferences));
    }


    public function removeConferencesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository(Conferences::class)->remove($id);
        return $this->redirectToRoute('allConferences');
    }

    public function modifyConferencesAction(Request $request, $id)
    {
        $conferences = $this->getDoctrine()->getRepository(Conferences::class)->find($id);
        $form = $this->createForm(ConferencesType::class, $conferences);

        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($conferences);
            $em->flush();
            return $this->redirectToRoute('allConferences');
        }

        $formView = $form->createView();
        return $this->render('AdminBundle:Default:modifyConferences.html.twig', array('form'=>$formView));
    }

    public function videosAction(Request $request){

        // Création du formulaire de création de thèmes
        $theme = new VideosThemes();
        $formTheme = $this->createForm(VideosThemesType::class, $theme);

        $formTheme->handleRequest($request);



        $formViewTheme = $formTheme->createView();

        // Création du formulaire de création de vidéos
        $video = new Videos();
        $formVideo = $this->createForm(VideosType::class, $video);

        $formVideo->handleRequest($request);


        $formViewVideo = $formVideo->createView();

        // Traitement des formulaires
        if($formTheme->isSubmitted()&&$formTheme->isValid()){
            //$video->setTheme($formVideo->get('theme')->getData());

            $em = $this->getDoctrine()->getManager();

            $em->persist($theme);
            $em->flush();
            return $this->redirectToRoute('videos');
        }

        if($formVideo->isSubmitted()&&$formVideo->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($video);
            $em->flush();
            return $this->redirectToRoute('videos');
        }

        //Récupération des vidéos
        $videos = $this->getDoctrine()->getRepository(Videos::class)->findAll();


        return $this->render('AdminBundle:Default:videos.html.twig', array('formTheme'=>$formViewTheme, 'formVideo'=>$formViewVideo, 'videos'=>$videos));
    }
}
