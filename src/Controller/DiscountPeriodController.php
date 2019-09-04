<?php

namespace App\Controller;

use App\Entity\DiscountPeriod;
use App\Form\DiscountPeriodType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class DiscountPeriodController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/discount_periods",
     *     name = "app_discount_periods_list"
     * )
     * @Rest\View
     */
    public function list()
    {
        $em = $this->getDoctrine()->getManager();
        $discountPeriods = $em->getRepository(DiscountPeriod::class)->findAll();
        return $discountPeriods;
    }

    /**
     * @Rest\Get(
     *     path = "/discount_periods/{id}",
     *     name = "app_discount_periods_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function show(DiscountPeriod $discountPeriod)
    {
        return $discountPeriod;
    }

    /**
     * @Rest\Post(
     *     path = "/discount_periods",
     *     name = "app_discount_periods_create"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function create(Request $request)
    {
        $discountPeriod = new DiscountPeriod();
        $form = $this->createForm(DiscountPeriodType::class, $discountPeriod);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($discountPeriod);
            $em->flush();
            return $discountPeriod;
        }
        return $this->view($form);
    }

    /**
     * @Rest\Put(
     *     path = "/discount_periods/{id}",
     *     name = "app_discount_periodst_update"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function update(Request $request, DiscountPeriod $discountPeriod)
    {
        $form = $this->createForm(DiscountPeriodType::class, $discountPeriod);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($discountPeriod);
            $em->flush();
            return $discountPeriod;
        }
        return $this->view($form);
    }

    /**
     * @Rest\Delete(
     *     path = "/discount_periods/{id}",
     *     name = "app_discount_periods_remove",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function remove(DiscountPeriod $discountPeriod)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($discountPeriod);
        $em->flush();
    }
}
