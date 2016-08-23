<?php

namespace BanqueBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BanqueBundle\Entity\CompteCourant;
use BanqueBundle\Form\CompteCourantType;

/**
 * CompteCourant controller.
 *
 * @Route("/comptecourant")
 */
class CompteCourantController extends Controller
{
    /**
     * Lists all CompteCourant entities.
     *
     * @Route("/", name="comptecourant_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('homepage');
        }
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            $compteCourants = $em->getRepository('BanqueBundle:CompteCourant')->findBy(array("user"=> $user));

            return $this->render('comptecourant/index.html.twig', array(
                'compteCourants' => $compteCourants,
            ));
    }


    /**
     * Creates a new CompteCourant entity.
     *
     * @Route("/new", name="comptecourant_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $compteCourant = new CompteCourant();
            $form = $this->createForm('BanqueBundle\Form\CompteCourantType', $compteCourant);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($compteCourant);
                $em->flush();

                return $this->redirectToRoute('comptecourant_show', array('id' => $compteCourant->getId()));
            }

            return $this->render('comptecourant/new.html.twig', array(
                'compteCourant' => $compteCourant,
                'form' => $form->createView(),
            ));
        }
        return $this->render('BanqueBundle:Default:index.html.twig');
    }

    /**
     * Finds and displays a CompteCourant entity.
     *
     * @Route("/{id}", name="comptecourant_show")
     * @Method("GET")
     */
    public function showAction(CompteCourant $compteCourant)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $deleteForm = $this->createDeleteForm($compteCourant);

            return $this->render('comptecourant/show.html.twig', array(
                'compteCourant' => $compteCourant,
                'delete_form' => $deleteForm->createView(),
            ));
        }
        return $this->render('BanqueBundle:Default:index.html.twig');
    }

    /**
     * Displays a form to edit an existing CompteCourant entity.
     *
     * @Route("/{id}/edit", name="comptecourant_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CompteCourant $compteCourant)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $deleteForm = $this->createDeleteForm($compteCourant);
            $editForm = $this->createForm('BanqueBundle\Form\CompteCourantType', $compteCourant);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($compteCourant);
                $em->flush();

                return $this->redirectToRoute('comptecourant_edit', array('id' => $compteCourant->getId()));
            }

            return $this->render('comptecourant/edit.html.twig', array(
                'compteCourant' => $compteCourant,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }
        return $this->render('BanqueBundle:Default:index.html.twig');
    }

    /**
     * Deletes a CompteCourant entity.
     *
     * @Route("/{id}", name="comptecourant_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CompteCourant $compteCourant)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $form = $this->createDeleteForm($compteCourant);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($compteCourant);
                $em->flush();
            }

            return $this->redirectToRoute('comptecourant_index');
        }
        return $this->render('BanqueBundle:Default:index.html.twig');
    }

    /**
     * Creates a form to delete a CompteCourant entity.
     *
     * @param CompteCourant $compteCourant The CompteCourant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CompteCourant $compteCourant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comptecourant_delete', array('id' => $compteCourant->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
