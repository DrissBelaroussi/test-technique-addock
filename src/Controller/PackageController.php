<?php

namespace App\Controller;

use App\Entity\Package;
use App\Form\PackageType;
use App\Form\ProductPackageType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class PackageController extends AbstractFOSRestController
{

    /**
     * @Rest\Get(
     *     path = "/packages",
     *     name = "app_package_list"
     * )
     * @Rest\View
     */
    public function list()
    {
        $em = $this->getDoctrine()->getManager();
        $packages = $em->getRepository(Package::class)->findAll();
        return $packages;
    }

    /**
     * @Rest\Get(
     *     path = "/packages/{id}",
     *     name = "app_package_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function show(Package $package)
    {
        return $package;
    }

    /**
     * @Rest\Post(
     *     path = "/packages",
     *     name = "app_package_create"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function create(Request $request)
    {
        $package = new Package();
        $form = $this->createForm(PackageType::class, $package);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($package);
            $em->flush();
            return $package;
        }
        return $this->view($form);
    }

    /**
     * @Rest\Put(
     *     path = "/packages/{id}",
     *     name = "app_package_update",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function update(Request $request, Package $package)
    {
        $form = $this->createForm(PackageType::class, $package);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($package);
            $em->flush();
            return $package;
        }
        return $this->view($form);
    }

    /**
     * @Rest\Delete(
     *     path = "/packages/{id}",
     *     name = "app_package_remove",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function remove(Package $package)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($package);
        $em->flush();
    }
}
