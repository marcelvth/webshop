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
     * @ORM\OneToMany(targetEntity=Regel::class, mappedBy="factuurId")
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
            $regel->setFactuurId($this);
        }

        return $this;
    }

    public function removeRegel(Regel $regel): self
    {
        if ($this->regels->contains($regel)) {
            $this->regels->removeElement($regel);
            // set the owning side to null (unless already changed)
            if ($regel->getFactuurId() === $this) {
                $regel->setFactuurId(null);
            }
        }

        return $this;
    }


}
