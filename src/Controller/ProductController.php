<?php

namespace App\Controller;

use App\Entity\DiscountPeriod;
use App\Entity\Package;
use App\Entity\Product;
use App\Form\ProductType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/products",
     *     name = "app_product_list"
     * )
     * @Rest\View
     */
    public function list()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findAll();
        return $products;
    }

    /**
     * @Rest\Get(
     *     path = "/products/{id}",
     *     name = "app_product_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * @Rest\Post(
     *     path = "/products",
     *     name = "app_product_create"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function create(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $product;
        }
        return $this->view($form);
    }

    /**
     * @Rest\Put(
     *     path = "/products/{id}",
     *     name = "app_product_update"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function update(Request $request, Product $product)
    {
        $form = $this->createForm(ProductType::class, $product);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $product;
        }
        return $this->view($form);
    }

    /**
     * @Rest\Delete(
     *     path = "/products/{id}",
     *     name = "app_product_remove",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function remove(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
    }

    /**
     * @Rest\Post(
     *     path = "/products/{id}/packages/{id_package}",
     *     name = "app_product_add_package",
     *     requirements = {"id"="\d+", "id_product"="\d+"}
     * )
     * @ParamConverter("package", options={"id" = "id_package"})
     * @Rest\View
     */
    public function addPackage(Product $product, Package $package)
    {
        $em = $this->getDoctrine()->getManager();
        $product->addPackage($package);
        $em->persist($product);
        $em->flush();
    }


    /**
     * @Rest\Delete(
     *     path = "/products/{id}/packages/{id_package}",
     *     name = "app_product_remove_package",
     *     requirements = {"id"="\d+", "id_product"="\d+"}
     * )
     * @ParamConverter("package", options={"id" = "id_package"})
     * @Rest\View
     */
    public function removePackage(Product $product, Package $package)
    {
        $em = $this->getDoctrine()->getManager();
        $product->removePackage($package);
        $em->persist($product);
        $em->flush();
    }

    /**
     * @Rest\Post(
     *     path = "/products/{id}/discount_periods/{id_discount_periods}",
     *     name = "app_product_add_discount",
     *     requirements = {"id"="\d+", "id_discount_periods"="\d+"}
     * )
     * @ParamConverter("discountPeriod", options={"id" = "id_discount_periods"})
     * @Rest\View
     */
    public function addDiscountPeriod(Product $product, DiscountPeriod $discountPeriod)
    {
        $today = new \DateTime();
        if ($today > $discountPeriod->getStartDate() && $today < $discountPeriod->getEndDate()) {
            $product->setDiscountPrice($product->getPrice() * (100 - $discountPeriod->getDiscount()) / 100);
        }
        $em = $this->getDoctrine()->getManager();
        $product->addDiscountPeriod($discountPeriod);
        $em->persist($product);
        $em->flush();
    }

    /**
     * @Rest\Delete(
     *     path = "/products/{id}/discount_periods/{id_discount_periods}",
     *     name = "app_product_remove_discount",
     *     requirements = {"id"="\d+", "id_discount_periods"="\d+"}
     * )
     * @ParamConverter("discountPeriod", options={"id" = "id_discount_periods"})
     * @Rest\View
     */
    public function removeDiscountPeriod(Product $product, DiscountPeriod $discountPeriod)
    {
        $em = $this->getDoctrine()->getManager();
        $product->removeDiscountPeriod($discountPeriod);
        $em->persist($product);
        $em->flush();
    }
}
