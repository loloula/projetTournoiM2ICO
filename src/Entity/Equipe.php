<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=EquipeRepository::class)
 * @ORM\Table(name="equipe")
 */
class Equipe
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
    private $nomEquipe;

    /**
     * @ORM\ManyToOne(targetEntity=Tournoi::class, inversedBy="equipes",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Type(type="App\Entity\Tournoi")
     */
    private $tournoi;

    /**
     * @ORM\ManyToOne(targetEntity=Tour::class, inversedBy="equipes",cascade={"persist"})
     * @Assert\Type(type="App\Entity\Tour")
     */
    private $tour;

    /**
     * @ORM\ManyToOne(targetEntity=Poulee::class, inversedBy="equipes",cascade={"persist"})
     * @Assert\Type(type="App\Entity\Poulee")
     */
    private $poule;

    /**
     * @ORM\OneToMany(targetEntity=Matchjouer::class, mappedBy="vainqueur")
     */
    private $matchjouers;

    public function __construct()
    {
        $this->matchjouers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEquipe(): ?string
    {
        return $this->nomEquipe;
    }

    public function setNomEquipe(string $nomEquipe): self
    {
        $this->nomEquipe = $nomEquipe;

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

    public function getTour(): ?Tour
    {
        return $this->tour;
    }

    public function setTour(?Tour $tour): self
    {
        $this->tour = $tour;

        return $this;
    }

    public function getPoule(): ?Poulee
    {
        return $this->poule;
    }

    public function setPoule(?Poulee $poule): self
    {
        $this->poule = $poule;

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
            $matchjouer->setVainqueur($this);
        }

        return $this;
    }

    public function removeMatchjouer(Matchjouer $matchjouer): self
    {
        if ($this->matchjouers->removeElement($matchjouer)) {
            // set the owning side to null (unless already changed)
            if ($matchjouer->getVainqueur() === $this) {
                $matchjouer->setVainqueur(null);
            }
        }

        return $this;
    }
}
