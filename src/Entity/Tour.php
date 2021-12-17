<?php

namespace App\Entity;

use App\Repository\TourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TourRepository::class)
 * @ORM\Table(name="tour")
 */
class Tour
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
    private $nomtour;

    /**
     * @ORM\ManyToOne(targetEntity=Tournoi::class, inversedBy="tours",cascade={"persist"})
     * @Assert\Type(type="App\Entity\Tournoi")
     */
    private $tournoi;

    /**
     * @ORM\OneToMany(targetEntity=Equipe::class, mappedBy="tour")
     */
    private $equipes;

    /**
     * @ORM\OneToMany(targetEntity=Poulee::class, mappedBy="tour")
     */
    private $poulees;

    /**
     * @ORM\OneToMany(targetEntity=Matchjouer::class, mappedBy="tour")
     */
    private $matchjouers;

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
        $this->poulees = new ArrayCollection();
        $this->matchjouers = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomtour(): ?string
    {
        return $this->nomtour;
    }

    public function setNomtour(string $nomtour): self
    {
        $this->nomtour = $nomtour;

        return $this;
    }

    public function getTournoi(): ?Tournoi
    {
        return $this->tournoi;
    }

    public function setTournoi(?Tournoi $tournoi): self
    {
        $this->tournoi = $tournoi;

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
            $equipe->setTour($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipes->removeElement($equipe)) {
            // set the owning side to null (unless already changed)
            if ($equipe->getTour() === $this) {
                $equipe->setTour(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Poulee[]
     */
    public function getPoulees(): Collection
    {
        return $this->poulees;
    }

    public function addPoulee(Poulee $poulee): self
    {
        if (!$this->poulees->contains($poulee)) {
            $this->poulees[] = $poulee;
            $poulee->setTour($this);
        }

        return $this;
    }

    public function removePoulee(Poulee $poulee): self
    {
        if ($this->poulees->removeElement($poulee)) {
            // set the owning side to null (unless already changed)
            if ($poulee->getTour() === $this) {
                $poulee->setTour(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Matchjouer[]
     */
    public function getMatchjouers(): Collection
    {
        return $this->matchjouers;
    }

    public function addMatchjouer(Matchjouer $matchjouer): self
    {
        if (!$this->matchjouers->contains($matchjouer)) {
            $this->matchjouers[] = $matchjouer;
            $matchjouer->setTour($this);
        }

        return $this;
    }

    public function removeMatchjouer(Matchjouer $matchjouer): self
    {
        if ($this->matchjouers->removeElement($matchjouer)) {
            // set the owning side to null (unless already changed)
            if ($matchjouer->getTour() === $this) {
                $matchjouer->setTour(null);
            }
        }

        return $this;
    }
}
