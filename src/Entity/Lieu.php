<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LieuRepository::class)
 */
class Lieu
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
     * @ORM\Column(type="string", length=255)
     */
    private $rue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $longitude;

    /**
     * @return Sortie
     */
    public function getSorties(): Sortie
    {
        return $this->sorties;
    }

    /**
     * @param Sortie $sorties
     * @return Lieu
     */
    public function setSorties(Sortie $sorties): Lieu
    {
        $this->sorties = $sorties;
        return $this;
    }

    /**
     * @var Lieux
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="lieux")
     */
    private $ville;

    /**
     * @var Sortie
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="lieu")
     */
    private $sorties;



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getLatitude(): ?int
    {
        return $this->latitude;
    }

    public function setLatitude(?int $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?int
    {
        return $this->longitude;
    }

    public function setLongitude(?int $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }


    public function getVille()
    {
        return $this->ville;
    }

    public function setVille($ville): self
    {
        $this->ville = $ville;
        return $this;
    }




}
