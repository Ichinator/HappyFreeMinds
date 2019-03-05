<?php

namespace PlanningBundle\Controller;

use PlanningBundle\Entity\Ateliers;
use PlanningBundle\Entity\Conferences;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PlanningBundle:Default:index.html.twig');
    }

    public function showAteliersAction(){
        $em = $this->getDoctrine()->getRepository(Ateliers::class);
        $ateliers = $em->findAll();


        return $this->render('PlanningBundle:Default:showAteliers.html.twig', array('ateliers' => $ateliers));
    }

    public function showConferencesAction(){
        $em = $this->getDoctrine()->getRepository(Conferences::class);
        $conferences = $em->findAll();


        return $this->render('PlanningBundle:Default:showConferences.html.twig', array('conferences' => $conferences));
    }
}
