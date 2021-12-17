<?php

namespace App\Entity;

use App\Repository\PouleeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PouleeRepository::class)
 * @ORM\Table(name="poulee")
 */
class Poulee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nompoule;

    /**
     * @ORM\ManyToOne(targetEntity=Tour::class, inversedBy="poulees",cascade={"persist"})
     * @Assert\Type(type="App\Entity\Tour")
     */
    private $tour;

    /**
     * @ORM\OneToMany(targetEntity=Equipe::class, mappedBy="poule")
     */
    private $equipes;

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNompoule(): ?string
    {
        return $this->nompoule;
    }

    public function setNompoule(string $nompoule): self
    {
        $this->nompoule = $nompoule;

        return $this;
    }

    public function getTour(): ?Tour
    {
        return $this->tour;
    }

    public function setTour(?Tour $tour): self
    {
        $this->tour = $tour;

        return $this;
    }

    /**
     * @return Collection|Equipe[]
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }

    public function addEquipe(Equipe $equipe): self
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes[] = $equipe;
            $equipe->setPoule($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipes->removeElement($equipe)) {
            // set the owning side to null (unless already changed)
            if ($equipe->getPoule() === $this) {
                $equipe->setPoule(null);
            }
        }

        return $this;
    }
}
