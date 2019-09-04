<?php

namespace App\Controller;

use App\Entity\Merchent;
use App\Form\MerchentType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class MerchentController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/merchents",
     *     name = "app_merchent_list"
     * )
     * @Rest\View
     */
    public function list()
    {
        $em = $this->getDoctrine()->getManager();
        $merchents = $em->getRepository(Merchent::class)->findAll();
        return $merchents;
    }

    /**
     * @Rest\Get(
     *     path = "/merchents/{id}",
     *     name = "app_merchent_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function show(Merchent $merchent)
    {
        return $merchent;
    }

    /**
     * @Rest\Post(
     *     path = "/merchents",
     *     name = "app_merchent_create"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function create(Request $request)
    {
        $merchent = new Merchent();
        $form = $this->createForm(MerchentType::class, $merchent);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($merchent);
            $em->flush();
            return $merchent;
        }
        return $this->view($form);
    }

    /**
     * @Rest\Put(
     *     path = "/merchents/{id}",
     *     name = "app_merchent_update"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function update(Request $request, Merchent $merchent)
    {
        $form = $this->createForm(MerchentType::class, $merchent);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($merchent);
            $em->flush();
            return $merchent;
        }
        return $this->view($form);
    }

    /**
     * @Rest\Delete(
     *     path = "/merchents/{id}",
     *     name = "app_merchent_remove",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function remove(Merchent $merchent)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($merchent);
        $em->flush();
    }
}
