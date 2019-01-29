<?php

namespace AdminBundle\Controller;

use PlanningBundle\Entity\Ateliers;
use PlanningBundle\Form\AteliersType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
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
        return $this->render('AdminBundle:Default:index.html.twig', array('form'=>$formView));
    }
}
