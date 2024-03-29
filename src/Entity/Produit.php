<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prixUnitaire = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Recette::class)]
    private Collection $ingredients;

    #[ORM\ManyToMany(mappedBy: 'produits', targetEntity: User::class )]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'idProduit', targetEntity: FactureProduit::class)]
    private Collection $factures;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->factures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    /**
     * @return Collection<int, Recette>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Recette $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setProduit($this);
        }

        return $this;
    }

    public function removeIngredient(Recette $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getProduit() === $this) {
                $ingredient->setProduit(null);
            }
        }

        return $this;
    }

        /**
     * @return Collection<int, User>
     */
    public function getProduits(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addProduit($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeProduit($this);
        }
    
        return $this;
    }

    /**
     * @return Collection<int, FactureProduit>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(FactureProduit $factureProduit): static
    {
        if (!$this->factures->contains($factureProduit)) {
            $this->factures->add($factureProduit);
            $factureProduit->setIdProduit($this);
        }

        return $this;
    }

    public function removeFacture(FactureProduit $factureProduit): static
    {
        if ($this->factures->removeElement($factureProduit)) {
            // set the owning side to null (unless already changed)
            if ($factureProduit->getIdProduit() === $this) {
                $factureProduit->setIdProduit(null);
            }
        }

        return $this;
    }

}
