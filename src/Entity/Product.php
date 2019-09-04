<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $discount_price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Merchent",cascade={"remove"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank
     */
    private $merchent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DiscountPeriod", inversedBy="products",cascade={"remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $discountPeriods;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Package", inversedBy="products",cascade={"remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $packages;

    public function __construct()
    {
        $this->discountPeriods = new ArrayCollection();
        $this->packages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDiscountPrice(): ?float
    {
        return $this->discount_price;
    }

    public function setDiscountPrice(?float $discount_price): self
    {
        $this->discount_price = $discount_price;

        return $this;
    }

    public function getMerchent(): ?Merchent
    {
        return $this->merchent;
    }

    public function setMerchent(?Merchent $merchent): self
    {
        $this->merchent = $merchent;

        return $this;
    }

    /**
     * @return Collection|DiscountPeriod[]
     */
    public function getDiscountPeriods(): Collection
    {
        return $this->discountPeriods;
    }

    public function addDiscountPeriod(DiscountPeriod $discountPeriod): self
    {
        if (!$this->discountPeriods->contains($discountPeriod)) {
            $this->discountPeriods[] = $discountPeriod;
        }

        return $this;
    }

    public function removeDiscountPeriod(DiscountPeriod $discountPeriod): self
    {
        if ($this->discountPeriods->contains($discountPeriod)) {
            $this->discountPeriods->removeElement($discountPeriod);
        }

        return $this;
    }

    /**
     * @return Collection|Package[]
     */
    public function getPackages(): Collection
    {
        return $this->packages;
    }

    public function addPackage(Package $package): self
    {
        if (!$this->packages->contains($package)) {
            $this->packages[] = $package;
        }

        return $this;
    }

    public function removePackage(Package $package): self
    {
        if ($this->packages->contains($package)) {
            $this->packages->removeElement($package);
        }

        return $this;
    }
}
