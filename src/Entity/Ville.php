<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VilleRepository::class)
 */
class Ville
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $codepostal;


    /**
     * @var Ville
     * @ORM\OneToMany(targetEntity="App\Entity\Lieu", mappedBy="ville")
     */
    private $lieux;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom) :self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCodepostal()
    {
        return $this->codepostal;
    }

    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;

        return $this;
    }


    public function getLieux()
    {
        return $this->lieux;
    }


    public function setLieux($lieux): self
    {
        $this->lieux = $lieux;
        return $this;
    }


}
