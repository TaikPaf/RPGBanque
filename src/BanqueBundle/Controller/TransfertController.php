<?php

namespace BanqueBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BanqueBundle\Entity\Transfert;
use BanqueBundle\Form\TransfertType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Transfert controller.
 *
 * @Route("/transfert")
 */
class TransfertController extends Controller
{
    /**
     * Lists all Transfert entities.
     *
     * @Route("/", name="transfert_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $em = $this->getDoctrine()->getManager();

            $transferts = $em->getRepository('BanqueBundle:Transfert')->findBy(array(),array('id','DESC'),50);

            return $this->render('transfert/index.html.twig', array(
                'transferts' => $transferts,
            ));
        }
        return $this->render('BanqueBundle:default:index.html.twig');
    }
    /**
    * @Route("/historique", name="transfert_histo")
    * @Method("GET")
    */
    public function historiqueAction(){

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $em = $this->getDoctrine()->getManager();

            $compte = $em->getRepository('BanqueBundle:CompteCourant')->findbyuser($this->getUser());
            $transferts = $em->getRepository('BanqueBundle:Transfert')->findTransferts($compte);



            return $this->render('transfert/index.html.twig', array(
                'transferts' => $transferts
            ));
        }
        return $this->render('BanqueBundle:Default:index.html.twig');
    }
    /**
     * Creates a new Transfert entity.
     *
     * @Route("/new", name="transfert_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $transfert = new Transfert();
            $form = $this->createForm('BanqueBundle\Form\TransfertType', $transfert);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                //Gestion du transfert d'argent
                $compteCurrentUser = $em->getRepository('BanqueBundle:CompteCourant')->findbyuser($this->getUser());
                $transfert->setDebiteur($compteCurrentUser);
                $transfert->setDate(new \DateTime("now"));

                if ($compteCurrentUser->getSolde() >= $transfert->getSomme()) {

                    $transfert->getCrediteur()->setSolde($transfert->getCrediteur()->getSolde() + $transfert->getSomme());

                    $compteCurrentUser->setSolde($compteCurrentUser->getSolde() - $transfert->getSomme());
                    $em->persist($compteCurrentUser);
                    $em->persist($transfert);
                    $em->flush();
                }


                return $this->redirectToRoute('general');
            }

            return $this->render('transfert/new.html.twig', array(
                'transfert' => $transfert,
                'form' => $form->createView(),
            ));
        }
        return $this->render('BanqueBundle:Default:index.html.twig');
    }

    /**
     * Finds and displays a Transfert entity.
     *
     * @Route("/{id}", name="transfert_show")
     * @Method("GET")
     */
    public function showAction(Transfert $transfert)
    {
        $deleteForm = $this->createDeleteForm($transfert);

        return $this->render('transfert/show.html.twig', array(
            'transfert' => $transfert,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Transfert entity.
     *
     * @Route("/{id}/edit", name="transfert_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Transfert $transfert)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')){
            return $this->redirectToRoute('homepage');
        }
        $deleteForm = $this->createDeleteForm($transfert);
        $editForm = $this->createForm('BanqueBundle\Form\TransfertType', $transfert);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transfert);
            $em->flush();

            return $this->redirectToRoute('transfert_edit', array('id' => $transfert->getId()));
        }

        return $this->render('transfert/edit.html.twig', array(
            'transfert' => $transfert,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Transfert entity.
     *
     * @Route("/{id}", name="transfert_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Transfert $transfert)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')){
            return $this->redirectToRoute('homepage');
        }
        $form = $this->createDeleteForm($transfert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($transfert);
            $em->flush();
        }

        return $this->redirectToRoute('transfert_index');
    }

    /**
     * Creates a form to delete a Transfert entity.
     *
     * @param Transfert $transfert The Transfert entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Transfert $transfert)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('transfert_delete', array('id' => $transfert->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
