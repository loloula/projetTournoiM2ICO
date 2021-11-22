<?php

namespace App\Entity;
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
}
