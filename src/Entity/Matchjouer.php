<?php

namespace App\Entity;

use App\Repository\MatchjouerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatchjouerRepository::class)
 * @ORM\Table(name="matchjouer")
 */
class Matchjouer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nommatch;

    /**
     * @ORM\ManyToOne(targetEntity=Tour::class, inversedBy="matchjouers",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Type(type="App\Entity\Tour")
     */
    private $tour;

    /**
     * @ORM\ManyToOne(targetEntity=Equipe::class, inversedBy="matchjouers",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Type(type="App\Entity\Equipe")
     */
    private $vainqueur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNommatch(): ?string
    {
        return $this->nommatch;
    }

    public function setNommatch(string $nommatch): self
    {
        $this->nommatch = $nommatch;

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

    public function getVainqueur(): ?Equipe
    {
        return $this->vainqueur;
    }

    public function setVainqueur(?Equipe $vainqueur): self
    {
        $this->vainqueur = $vainqueur;

        return $this;
    }
}
