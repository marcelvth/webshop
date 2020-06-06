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
     * @ORM\ManyToOne(targetEntity=Factuur::class, inversedBy="regels")
     */
    private $factuurId;

    /**
     * @ORM\Column(type="integer")
     */
    private $aantal;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="regels")
     */
    private $productId;


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

    public function getAantal(): ?int
    {
        return $this->aantal;
    }

    public function setAantal(int $aantal): self
    {
        $this->aantal = $aantal;

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

}
