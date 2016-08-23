<?php

namespace BanqueBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BanqueBundle\Entity\MessageSupport;
use BanqueBundle\Form\MessageSupportType;

/**
 * MessageSupport controller.
 *
 * @Route("/support")
 */
class MessageSupportController extends Controller
{
    /**
     * Lists all MessageSupport entities.
     *
     * @Route("/", name="support_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $messageSupports = $em->getRepository('BanqueBundle:MessageSupport')->findAll();

        return $this->render('messagesupport/index.html.twig', array(
            'messageSupports' => $messageSupports,
        ));
    }

    /**
     * Creates a new MessageSupport entity.
     *
     * @Route("/new", name="support_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $messageSupport = new MessageSupport();
        $form = $this->createForm('BanqueBundle\Form\MessageSupportType', $messageSupport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($messageSupport);
            $em->flush();

            return $this->redirectToRoute('support_show', array('id' => $messageSupport->getId()));
        }

        return $this->render('messagesupport/new.html.twig', array(
            'messageSupport' => $messageSupport,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MessageSupport entity.
     *
     * @Route("/{id}", name="support_show")
     * @Method("GET")
     */
    public function showAction(MessageSupport $messageSupport)
    {
        $deleteForm = $this->createDeleteForm($messageSupport);

        return $this->render('messagesupport/show.html.twig', array(
            'messageSupport' => $messageSupport,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MessageSupport entity.
     *
     * @Route("/{id}/edit", name="support_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MessageSupport $messageSupport)
    {
        $deleteForm = $this->createDeleteForm($messageSupport);
        $editForm = $this->createForm('BanqueBundle\Form\MessageSupportType', $messageSupport);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($messageSupport);
            $em->flush();

            return $this->redirectToRoute('support_edit', array('id' => $messageSupport->getId()));
        }

        return $this->render('messagesupport/edit.html.twig', array(
            'messageSupport' => $messageSupport,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a MessageSupport entity.
     *
     * @Route("/{id}", name="support_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MessageSupport $messageSupport)
    {
        $form = $this->createDeleteForm($messageSupport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($messageSupport);
            $em->flush();
        }

        return $this->redirectToRoute('support_index');
    }

    /**
     * Creates a form to delete a MessageSupport entity.
     *
     * @param MessageSupport $messageSupport The MessageSupport entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MessageSupport $messageSupport)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('support_delete', array('id' => $messageSupport->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
