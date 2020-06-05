<?php

namespace App\Entity;

use App\Repository\FactuurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactuurRepository::class)
 */
class Factuur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="factuurs")
     */
    private $KlantId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datum;

    /**
     * @ORM\Column(type="array")
     */
    private $regels = [];

    /**
     * @ORM\OneToMany(targetEntity=Regel::class, mappedBy="factuurId")
     */
    private $factuurRegels;

    public function __construct()
    {
        $this->factuurRegels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKlantId(): ?User
    {
        return $this->KlantId;
    }

    public function setKlantId(?User $KlantId): self
    {
        $this->KlantId = $KlantId;

        return $this;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

        return $this;
    }

    public function getRegels(): ?array
    {
        return $this->regels;
    }

    public function setRegels(array $regels): self
    {
        $this->regels = $regels;

        return $this;
    }

    /**
     * @return Collection|Regel[]
     */
    public function getFactuurRegels(): Collection
    {
        return $this->factuurRegels;
    }

    public function addFactuurRegel(Regel $factuurRegel): self
    {
        if (!$this->factuurRegels->contains($factuurRegel)) {
            $this->factuurRegels[] = $factuurRegel;
            $factuurRegel->setFactuurId($this);
        }

        return $this;
    }

    public function removeFactuurRegel(Regel $factuurRegel): self
    {
        if ($this->factuurRegels->contains($factuurRegel)) {
            $this->factuurRegels->removeElement($factuurRegel);
            // set the owning side to null (unless already changed)
            if ($factuurRegel->getFactuurId() === $this) {
                $factuurRegel->setFactuurId(null);
            }
        }

        return $this;
    }
}
