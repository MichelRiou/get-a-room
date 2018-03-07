<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Form\CustomerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('index.html.twig', [
            'essai' => 'Page de depart'
        ]);
    }

    /**
     * @Route("/login",name="customer_login_route")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function customerLoginAction(){
        //Récupération des erreurs éventuelles
        $securityUtils = $this->get('security.authentication_utils');
        return $this->render("login_customer.html.twig",
            ["action" => $this->generateUrl("customer_check_route"),
                "error" => $securityUtils->getLastAuthenticationError(),
                "userName" => $securityUtils->getLastUsername()]
        );

    }
    /**
     * @Route("/inscription-client/", name="register_customer")
     */
    public function registerCustomerAction(Request $request)
        // L'objet de type Resquest récupère la saisie
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        // Hydratation de l'entité à partir de l'objet Resquest
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $customer->setPassword(password_hash($customer->getPlainPassword(), PASSWORD_BCRYPT));
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
            // Message Flash
            $this->addFlash('info', 'Vous êtes inscrit');
            // Authentification de l'utilisateur qui vient de s'inscrire

            // Création d'un token à partir des données de l'auteur
            $token = new UsernamePasswordToken($customer, null, 'main', $customer->getRoles());
            // Stockage du token en session
            $this->get('security.token_storage')->setToken($token);
            return $this->redirectToRoute("homepage");
        }
        return $this->render('create_customer.html.twig', [
            "form" => $form->createView()
        ]);


    }

    /**
     * @Route("disponibilités/{d1,d2,nb}",name="search_room")
     * @param $start_date
     * @param $end_date
     * @param $nbOfPersons
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchRoomsAction($start_date,$end_date,$nbOfPersons)
    {
        $roomsrepository = $this->getDoctrine()->getRepository("AppBundle:Room");
        $rooms = $roomsrepository->getRoomsDispo($start_date,$end_date,$nbOfPersons)->getResult();
        if(count($rooms)<1){
            $msg='Aucunes chambres disponibles';
        }else{
            $msg='Sélections des chambres disponibles';
        }
        return $this->render("default/posts_by_author.html.twig", [

            "message" => $msg,
            "roomsList" => $rooms
        ]);

    }
}
