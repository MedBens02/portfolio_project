# Plateforme Scolarité

## Présentation

Ce dépôt contient les fichiers sources d'une application web pour la gestion de la scolarité. L'application est construite avec HTML, CSS, PHP et JavaScript.

## Prérequis

- Serveur web avec support PHP (Apache, Nginx)
- MySQL Server

## Installation

Suivez ces étapes pour configurer et exécuter votre application:


### Utiliser un script
Telecharger les config.sh et executer le, n'oublier pas de modifier les identifiants de votre base de donnee ainsi que le chemain vers la racine de votre serveur Web.

```bash
sudo chmod +x config.sh
./config.sh
```

### 1. Clonage du dépôt

Clonez ce dépôt dans le répertoire nommé `proj` situé à la racine de votre serveur web. Vous pouvez le faire avec la commande suivante si vous avez git installé:

```bash
	git clone https://github.com/MedBens02/Web_proj.git /chemin/vers/serveur/root/proj
```

### 2. Configuration de la base de données
Créez une base de données MySQL nommée plateforme_scolaire.
Utilisez l'utilisateur MySQL root avec un mot de passe vide.
Le fichier de configuration de la base de données se trouve dans database/DB.php. Voici son contenu pour référence:

```bash

<?php
class DB{
    static public function connect(){
        $pdo = new PDO('mysql:host=localhost;dbname=plateforme_scolaire', 'root', '');
        $pdo->exec("set names utf8");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}
?>
```
### 3. Importation de la structure de la base de données
Importez la structure de la base de données en exécutant les scripts SQL fournis dans le répertoire database/. Vous pouvez utiliser des outils comme phpMyAdmin ou la ligne de commande MySQL pour cela.
```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS plateforme_scolaire"
mysql -u root -p plateforme_scolaire < database/plateforme_scolaire.sql
```

### 4. Lancement de l'application
Une fois la configuration terminée, ouvrez votre navigateur et accédez à l'application via http://localhost/proj.

### 5. Comptes

- **Professeur**  
  Email: `test@gmail.com`  
  Mot de passe: `test`

- **Étudiant**  
  Email: `test@gmail.com`  
  Mot de passe: `test`

- **Admin**  
  Utilisateur: `admin`  
  Mot de passe: `admin`
