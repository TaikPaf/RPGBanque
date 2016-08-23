<?php

namespace BanqueBundle\Controller;

use BanqueBundle\Entity\Transfert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BanqueBundle\Entity\Facture;
use BanqueBundle\Entity\CompteCourant;
use BanqueBundle\Form\FactureType;

/**
 * Facture controller.
 *
 * @Route("/facture")
 */
class FactureController extends Controller
{
    /**
     * Lists all Facture entities.
     *
     * @Route("/", name="facture_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')){
            return $this->redirectToRoute('homepage');
        }
        $em = $this->getDoctrine()->getManager();

        $factures = $em->getRepository('BanqueBundle:Facture')->findAll();

        return $this->render('facture/index.html.twig', array(
            'factures' => $factures,
        ));
    }

    /**
     * Creates a new Facture entity only if he is a commerce account
     *
     * @Route("/new", name="facture_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') && $this->getUser()->getRank() == "commerce"){
            return $this->redirectToRoute('homepage');
        }
        $facture = new Facture();
        $form = $this->createForm('BanqueBundle\Form\FactureType', $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $compteCurrentUser = $em->getRepository('BanqueBundle:CompteCourant')->findOneBy(array('user'=>$this->getUser()));

            //$transfert->setDebiteur($data['']);

            $facture->setDateachat(new \Datetime("now"));
            $facture->getTransfert()->setDate(new \Datetime("now"));
            $facture->getTransfert()->setCrediteur($compteCurrentUser);

            $em->persist($facture);

            $em->flush();

            return $this->redirectToRoute('facture_show', array('id' => $facture->getId()));
        }

        return $this->render('facture/new.html.twig', array(
            'facture' => $facture,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Facture entity.
     *
     * @Route("/show", name="facture_show")
     * @Method("GET")
     */
    public function showAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('homepage');
        }
        $em = $this->getDoctrine()->getManager();
        
        $compte = $em->getRepository('BanqueBundle:CompteCourant')->findBy(array('user'=>$this->getUser()));
        $factureWait = $em->getRepository('BanqueBundle:Facture')->factureWaiting($compte);

        return $this->render('facture/show.html.twig', array(
            'factureWait' => $factureWait
            
        ));
    }


    /**
     * Historique des factures d'un compte
     *
     * @Route("/historique", name="facture_histo")
     * @Method("GET")
     */
    public function histoAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('homepage');
        }
        $em = $this->getDoctrine()->getManager();

        $compte = $em->getRepository('BanqueBundle:CompteCourant')->findBy(array('user'=>$this->getUser()));
        $facture = $em->getRepository('BanqueBundle:Facture')->facturePayer($compte);

        return $this->render('facture/histo.html.twig', array(
            'factureWait' => $facture

        ));
    }

    /**
     * Validation Factures
     *
     * @Route("/{id}", name="facture_validation")
     * @Method({"GET", "POST"})
     */
    public function validateAction(Facture $facture)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('homepage');
        }
        $em = $this->getDoctrine()->getManager();

        $compte = $em->getRepository('BanqueBundle:CompteCourant')->findOneBy(array('user' => $this->getUser()));

        if ($facture->getTransfert()->getDebiteur()->getId() == $compte->getId()){

            $facture->setIsValide(true);
            //var_dump($facture->getIsValide());die();

            $deb = $em->getRepository('BanqueBundle:CompteCourant')->find($facture->getTransfert()->getDebiteur()->getId());
            $cred = $em->getRepository('BanqueBundle:CompteCourant')->find($facture->getTransfert()->getCrediteur()->getId());;

            $deb->setSolde($deb->getSolde() - $facture->getTransfert()->getSomme());
            $cred->setSolde($cred->getSolde() + $facture->getTransfert()->getSomme());

            $this->getDoctrine()->getManager()->persist($facture);
            $this->getDoctrine()->getManager()->persist($deb);
            $this->getDoctrine()->getManager()->persist($cred);

            $this->getDoctrine()->getManager()->flush();

        }
            return $this->redirectToRoute('general');

    }

    /**
     * Edition d'une facture
     *
     * @Route("/{id}/edit", name="facture_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Facture $facture)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')){
            return $this->redirectToRoute('homepage');
        }
        $deleteForm = $this->createDeleteForm($facture);
        $editForm = $this->createForm('BanqueBundle\Form\FactureType', $facture);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($facture);
            $em->flush();

            return $this->redirectToRoute('facture_edit', array('id' => $facture->getId()));
        }

        return $this->render('facture/edit.html.twig', array(
            'facture' => $facture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Facture entity.
     *
     * @Route("/{id}", name="facture_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Facture $facture)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')){
            return $this->redirectToRoute('homepage');
        }
        $form = $this->createDeleteForm($facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($facture);
            $em->flush();
        }

        return $this->redirectToRoute('facture_index');
    }

    /**
     * Creates a form to delete a Facture entity.
     *
     * @param Facture $facture The Facture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Facture $facture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facture_delete', array('id' => $facture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
