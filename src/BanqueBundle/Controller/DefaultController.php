<?php

namespace BanqueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('general');
    }

    /**
     * @Route("/general", name="general")
     */
    public function generalAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('homepage');
        }
        $em = $this->getDoctrine()->getManager();
        $compteCourant = $em->getRepository('BanqueBundle:CompteCourant')->findOneBy(array("user"=> $this->getUser()));
 
        $transferts = $em->getRepository('BanqueBundle:Transfert')->findTransferts($compteCourant);
        
        $nbfactureWait = $em->getRepository('BanqueBundle:Facture')->getNbFactureWaiting($compteCourant);
        
        $factures = $em->getRepository('BanqueBundle:Facture')->allFacturesAcheteur($compteCourant);

        $stats = $em->getRepository('BanqueBundle:StatSolde')->findBy(array(), array("id" => 'ASC'), 20);
        
        $tabstat = array();
        foreach ($stats as $stat){
            $tabstat[] = $stat->getSolde();
        }
        
        return $this->render('default/index.html.twig', array(
            'transferts'=> $transferts,
            'stats' => json_encode($tabstat),
            'comptecourant' => $compteCourant,
            'nbFactureWait' => $nbfactureWait,
            'factures' => $factures
        ));
    }


}
