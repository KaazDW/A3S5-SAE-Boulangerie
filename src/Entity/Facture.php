<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idUser = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'idFacture', targetEntity: FactureProduit::class)]
    private Collection $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, FactureProduit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(FactureProduit $factureProduit): static
    {
        if (!$this->produits->contains($factureProduit)) {
            $this->produits->add($factureProduit);
            $factureProduit->setIdFacture($this);
        }

        return $this;
    }

    public function removeProduit(FactureProduit $factureProduit): static
    {
        if ($this->produits->removeElement($factureProduit)) {
            // set the owning side to null (unless already changed)
            if ($factureProduit->getIdFacture() === $this) {
                $factureProduit->setIdFacture(null);
            }
        }

        return $this;
    }
}
