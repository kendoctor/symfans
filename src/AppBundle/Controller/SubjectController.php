<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subject;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Subject controller.
 *
 * @Route("admin/subject")
 */
class SubjectController extends Controller
{
    /**
     * Lists all subject entities.
     *
     * @Route("/", name="admin_subject_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        /** @var QueryBuilder $qb */
        $qb = $em->getRepository('AppBundle:Subject')->getQbByUser($this->getUser()->getId());

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb->getQuery(),
            $request->query->getInt('page', 1)/*page number*/,
            8/*limit per page*/
        );

        return $this->render('subject/index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new subject entity.
     *
     * @Route("/new", name="admin_subject_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $subject = new Subject();
        $form = $this->createForm('AppBundle\Form\SubjectType', $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $subject->setCreatedBy($this->getUser());
            $em->persist($subject);
            $em->flush();

            return $this->redirectToRoute('admin_subject_show', array('id' => $subject->getId()));
        }

        return $this->render('subject/new.html.twig', array(
            'subject' => $subject,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a subject entity.
     *
     * @Route("/{id}", name="admin_subject_show")
     * @Method("GET")
     */
    public function showAction(Subject $subject)
    {
        $deleteForm = $this->createDeleteForm($subject);

        return $this->render('subject/show.html.twig', array(
            'subject' => $subject,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing subject entity.
     *
     * @Route("/{id}/edit", name="admin_subject_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Subject $subject)
    {
        $deleteForm = $this->createDeleteForm($subject);
        $editForm = $this->createForm('AppBundle\Form\SubjectType', $subject);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_subject_edit', array('id' => $subject->getId()));
        }

        return $this->render('subject/edit.html.twig', array(
            'subject' => $subject,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a subject entity.
     *
     * @Route("/{id}", name="admin_subject_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Subject $subject)
    {
        $form = $this->createDeleteForm($subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subject);
            $em->flush();
        }

        return $this->redirectToRoute('admin_subject_index');
    }

    /**
     * Creates a form to delete a subject entity.
     *
     * @param Subject $subject The subject entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Subject $subject)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_subject_delete', array('id' => $subject->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
