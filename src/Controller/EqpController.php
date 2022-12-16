<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Equipement;

class EqpController extends Controller
{
    /**
     * @Route("/eqp", name="app_eqp")
     */
    public function index(): Response
    {

        $equipement = $this->getDoctrine()->getRepository(Equipement::class)->findAll();

        return $this->render('eqp/index.html.twig', [
            'equipement' => $equipement
        ]);
    }

    /**
     * @Route("/frml/new", name="frml_create")
     */
    public function create(Request $request) : Response {
        $equipement = new Equipement();

        $form = $this->createFormBuilder($equipement)
                     ->add('nom', TextType::class )
                     ->add('marque', TextType::class )
                     ->add('prix',TextType::class )
                     ->add('description',TextType::class)
                     ->add('quantite', TextType::class )
                     ->add('save', SubmitType::class, [
                        'label' => 'Enregistrer'
                     ] )
                     ->getForm();

        
        $form->handleRequest($request);


        if($form->isSubmitted()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($equipement);
            $em->flush();

           // return new Response("Equipement ajoué");
           return $this->redirectToRoute('app_eqp', ['id' => $equipement->getId()]);
        }
        return $this->render('eqp/create.html.twig', [
            'formEquipement' => $form->createView()
        ]);
    }

  
    /**
     * @Route("/frml", name="app_frml")
     */
    public function frml(): Response
    {
        $equipement = $this->getDoctrine()->getRepository(Equipement::class)->findAll();

        return $this->render('eqp/frml.html.twig', [
            'equipement' => $equipement
        ]);
    }

     
    
    
}
