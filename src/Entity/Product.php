<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
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
     * @ORM\Column(type="string", length=255)
     */
    private $productName;

    /**
     * @ORM\Column(type="float")
     */
    private $productPrice;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $productDescription;

    /**
     * @ORM\OneToMany(targetEntity=Regel::class, mappedBy="productId")
     */
    private $regels;

    public function __construct()
    {
        $this->regels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductPrice(): ?float
    {
        return $this->productPrice;
    }

    public function setProductPrice(float $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    public function setProductDescription(?string $productDescription): self
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    /**
     * @return Collection|Regel[]
     */
    public function getRegels(): Collection
    {
        return $this->regels;
    }

    public function addRegel(Regel $regel): self
    {
        if (!$this->regels->contains($regel)) {
            $this->regels[] = $regel;
            $regel->setProductId($this);
        }

        return $this;
    }

    public function removeRegel(Regel $regel): self
    {
        if ($this->regels->contains($regel)) {
            $this->regels->removeElement($regel);
            // set the owning side to null (unless already changed)
            if ($regel->getProductId() === $this) {
                $regel->setProductId(null);
            }
        }

        return $this;
    }
}
