<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\TournoiRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TournoiRepository::class)
 * @ORM\Table(name="tournoi")
 */
class Tournoi
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank
     */
    private $nomt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="tournois",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Type(type="App\Entity\Evenement")
     * @Assert\Valid
     */
    private $ev;

    /**
     * @ORM\OneToMany(targetEntity=Equipe::class, mappedBy="tournoi")
     */
    private $equipes;

    /**
     * @ORM\OneToMany(targetEntity=Tour::class, mappedBy="tournoi")
     */
    private $tours;



    public function __construct()
    {
        $this->equipes = new ArrayCollection();
        $this->tours = new ArrayCollection();
    }
    function __toString(){
      return $this->nomt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomt(): ?string
    {
        return $this->nomt;
    }

    public function setNomt(string $nomt): self
    {
        $this->nomt = $nomt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEv(): ?Evenement
    {
        return $this->ev;
    }

    public function setEv(?Evenement $ev): self
    {
        $this->ev = $ev;

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
            $equipe->setTournoi($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipes->removeElement($equipe)) {
            // set the owning side to null (unless already changed)
            if ($equipe->getTournoi() === $this) {
                $equipe->setTournoi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tour[]
     */
    public function getTours(): Collection
    {
        return $this->tours;
    }

    public function addTour(Tour $tour): self
    {
        if (!$this->tours->contains($tour)) {
            $this->tours[] = $tour;
            $tour->setTournoi($this);
        }

        return $this;
    }

    public function removeTour(Tour $tour): self
    {
        if ($this->tours->removeElement($tour)) {
            // set the owning side to null (unless already changed)
            if ($tour->getTournoi() === $this) {
                $tour->setTournoi(null);
            }
        }

        return $this;
    }





}
