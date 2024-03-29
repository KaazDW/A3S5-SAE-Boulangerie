$*iu

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/">
    <img src="images/logo.png" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">A3S5 SAE Boulangerie</h3>

  <p align="center">
    SAE(Ptut) de 3e Année de BUT Informatique : ERP web pour une Boulangerie
    <br />
    <br />
  </p>
</div>

<p align="center">
  <a href="https://skillicons.dev">
    <img src="https://skillicons.dev/icons?i=symfony,sass,js" />
  </a>
</p>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>SOMMAIRE</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## A Propos

Liste des fonctionnalités : 
- ✅
- ⌛
- ❌

### Technologies : 
- Symfony 5.6.2 (c) 2021-2024

[//]: # (tableau markdown)

| PHP 8.2 | PhpUnit 9.6 | Htmx </> | Javascript | Font-awesome Free Licence | ApexCharts.js |
|---------|-------------|----------|------------|---------------------------|---------------|


<!-- GETTING STARTED -->
## Getting Started

Instructions concernant l'installation d'une copie local du projet

### Prérequis

- PHP 8.2
- SGDB MySQL
- Symfony CLI

### Installation

_Objectif : Installer et démarrer le projet localement :_
1. Cloner le projet et installer les dépendances
    ```sh
    git clone https://github.com/KaazDW/A3S5-SAE-Boulangerie.git
    ```
2. ```sh
    cd .\A3S5-SAE-Boulangerie\
    composer install
3. Créez une nouvelle base de donnée et renseignez ses identifiants d'accès dans le fichier .env.local (ligne 30)
    ```php
    DATABASE_URL="mysql://root:@127.0.0.1:3306/sae-boulangerie?charset=utf8"
    ```
3. Installer les migrations (avec jeu de test pour démo)
    ```sh
   php bin/console doctrine:migrations:migrate
   ```
4. Lancer le serveur local symfony
    ```sh
    symfony server:start
    ```
   


<!-- USAGE EXAMPLES -->
## Usage
### Tests fonctionnels
> `./tests/FunctionnelsTest.php`

Dupliquer votre base de donnée initiale, en y ajoutant le suffixe `_test`.

***exemple : bdd initiale -> "sae-boulangerie", bdd de test -> "sae-boulangerie_test"***

Dans le fichier de test, modifier l'adresse email utilisé pour l'authentification.

**Pour exécuter les tests, utilisez la commande suivante :**
```sh
php bin/phpunit
```

<br/>

### Commandes supplémentaires pour le développement
Compilation des feuilles de style SASS :
``` 
sass public/style/scss/base.scss:public/style/css/base.css -w
```

<!-- LICENSE -->
## License

Code du projet sous License MIT. 
<br>
> Cf `LICENSE.txt` pour plus d'informations.


<!-- Sources -->
## Crédits

