<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Repository\RecetteRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Recette;
use App\Entity\Produit;
use App\Entity\Ingredient;


class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'produits')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        //Recupere l'ensemble des produits
        $produits = $entityManager->getRepository(Produit::class)->findAll();
        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    // PEUT ETRE MODIFIER IDRECETTE ET IDINGREDIENT POUR NE PRENDRE QUE L'ID DE LA RECETTE
    #[Route('/produit/modifQuantiteIngr/{idRecette}/{quantite}', name: 'modifierQuantite', methods: ['GET', 'POST'])]
    public function majQuantiteIngredient(EntityManagerInterface $entityManager, Request $request, $idRecette, $quantite): Response
    {
        //SI METHODE GET RENVOIE LE FORMULAIRE POUR MODIFIER LA QUANTITE DE L'INGREDIENT
        if ($request->isMethod('GET')){
            $recette = $entityManager->getRepository(Recette::class)->find($idRecette);

            return $this->render('produit/modifQuantiteIngr/modifForm.html.twig', [
                'recette' => $recette,
                'quantite' => $quantite,
            ]);
        }

        // SI METHODE POST MODIFIE LA QUANTITE DE L'INGREDIENT ET METS A JOUR LA PAGE AVEC LA NOUVELLE QUANTITE
        elseif ($request->isMethod('POST')) {
            //recupere la nouvelle quantite
            $nouvelleQuantite = $request->request->get('quantite');

            // RECUPERE LA RECETTE ET METS A JOUR LA QUANTITE DE SON INGREDIENT
            $recette = $entityManager->getRepository(Recette::class)->find($idRecette);
            $recette->setQuantite($nouvelleQuantite);
            $entityManager->flush();

            return $this->render('produit/modifQuantiteIngr/quantiteModifiee.html.twig', [
                'recette' => $recette,
                'quantite' => $nouvelleQuantite,
            ]);
        }
    }

    // PEUT ETRE MODIFIER IDRECETTE ET IDINGREDIENT POUR NE PRENDRE QUE L'ID DE LA RECETTE
    #[Route('/produit/modifProduit/{idProduit}', name: 'modifProduit', methods: ['GET', 'POST'])]
    public function majProduit(EntityManagerInterface $entityManager, Request $request, $idProduit): Response
    {
        $produit = $entityManager->getRepository(Produit::class)->find($idProduit);
        return $this->render('produit/modifProduit/modifProduitForm.html.twig', [
            'produit' => $produit,
        ]);
    }


    #[Route('/produit/ajouterIngredient/{idProduit}', name: 'ajouterIngredient', methods: ['GET', 'POST'])]
    public function ajouterIngredient(EntityManagerInterface $entityManager, Request $request, $idProduit): Response
    {
        // SI METHODE GET RENVOIE LE FORMULAIRE POUR AJOUTER L'INGREDIENT
        if ($request->isMethod('GET')){

            //recupere le produit avec l'id donné en param
            $produit = $entityManager->getRepository(Produit::class)->find($idProduit);
            //recupere l'ensemble des ingredients
            $ingredients = $entityManager->getRepository(Ingredient::class)->findAll();

            return $this->render('produit/ajouterIngredient/ajouterIngredientForm.html.twig', [
                'produit' => $produit,
                'ingredients' => $ingredients,
            ]);
        }

        // SI METHODE POST CREER L'INGREDIENT
        elseif ($request->isMethod('POST')) {

            $quantite = $request->request->get('quantite'); //recupere la quantite
            $ingredientChoisi = $request->request->get('ingredient'); // recupere l'id de l'ingredient
            $ingredient = $entityManager->getRepository(Ingredient::class)->find($ingredientChoisi); // recupere l'ingredient grâce à son id
            $produit = $entityManager->getRepository(Produit::class)->find($idProduit); // recupere le produit avec son id

            // Creer le lien entre le produit et l'ingredient (et sa quantite) en ajoutant une recette
            $recette = new Recette();
            $recette->setIngredient($ingredient);
            $recette->setProduit($produit);
            $recette->setQuantite($quantite);

            // mets a jour la bdd
            $entityManager->persist($recette);
            $entityManager->flush();

            return $this->render('produit/ajouterIngredient/ingredientAjoute.html.twig', [
                'produit' => $produit,
                'ingredient' => $ingredient,

            ]);
        }
        
    }
}
