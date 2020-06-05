<?php

namespace App\Entity;

use App\Repository\RegelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RegelRepository::class)
 */
class Regel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Factuur::class, inversedBy="factuurRegels")
     */
    private $factuurId;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="regels")
     */
    private $productId;

    /**
     * @ORM\Column(type="float")
     */
    private $aantal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactuurId(): ?Factuur
    {
        return $this->factuurId;
    }

    public function setFactuurId(?Factuur $factuurId): self
    {
        $this->factuurId = $factuurId;

        return $this;
    }

    public function getProductId(): ?Product
    {
        return $this->productId;
    }

    public function setProductId(?Product $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getAantal(): ?float
    {
        return $this->aantal;
    }

    public function setAantal(float $aantal): self
    {
        $this->aantal = $aantal;

        return $this;
    }
}
