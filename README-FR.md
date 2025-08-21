# SAE23 – Création d’une Solution Informatique (Plateforme IPAM)
<img width="1919" height="899" alt="image" src="https://github.com/user-attachments/assets/d4ed1c0d-894f-4dfa-ba59-d45b61a5658d" />

## Présentation du Projet
L’objectif est de créer une **plateforme de gestion d’adresses IP (IPAM)** pour une entreprise fictive.  
La plateforme est divisée en **trois sites**, chacun disposant de son propre **administrateur**.  

---

## Administrateurs
- Peuvent **créer des clients**, **supprimer des clients** et **consulter la liste des clients** de leur site.  
- Lorsqu’un **client est créé**, la plateforme lui assigne automatiquement :
  - Une **adresse IP**
  - Un **VLAN**
<img width="1918" height="898" alt="image" src="https://github.com/user-attachments/assets/1377dc46-2af8-461c-bf62-6069ef917d5b" />

---

## Clients
- Peuvent **attribuer des adresses IP** à leurs machines en fonction du réseau.  
- Peuvent **consulter la liste** des machines de leur VLAN.  
- Peuvent **supprimer des machines**.  
<img width="1919" height="899" alt="image" src="https://github.com/user-attachments/assets/62d10e3b-0625-4820-9675-1f945cef988d" />

---

## Fichiers PHP

### `form-connexion.php`
- Fournit le **formulaire de connexion**.  
- Les utilisateurs peuvent se connecter en tant qu’**administrateur** ou **client**.  
- Les mots de passe sont masqués (affichés en points).  
- Contient un lien **"Contacter le support"** (`mailto:` avec une adresse e-mail prédéfinie).  
- Après connexion, redirection vers **`connexion.php`**.  

---

### `menu.php` (Menu Administrateur)
Si l’utilisateur est un **administrateur**, il peut :
- **Ajouter un client**
- **Voir la liste des clients**
- **Se déconnecter**

En choisissant **"Ajouter un client"**, l’administrateur est redirigé vers :

---

### `form-ajout-client.php`
Permet de créer un **nouveau client** avec les informations suivantes :
- Nom du client  
- Identifiant (login)  
- Mot de passe  
- Adresse e-mail  

---

### `liste_client.php`
- Affiche la **liste des clients** créés.  
- Exemple : si l’**administrateur du site 1** crée un client, celui-ci :
  - Appartient au **site 1**
  - Possède un **ID client**
  - Reçoit une **adresse réseau** selon les spécifications
  - Dispose d’un **Route Distinguisher**
  - Affiche les informations entrées lors de sa création  

Limite : **16 clients maximum par site**.  

---

### `menu_client.php` (Menu Client)
Si l’utilisateur est un **client**, il peut :
- **Ajouter une machine**
- **Lister ses machines**
- **Supprimer des machines**

Exemple : ajouter une machine `p2021` dans la salle `P202` en remplissant simplement le formulaire.  

---

## Outils et Technologies
- **PostgreSQL** → Pour gérer la base de données (fichier SQL).  
- **WAMP / XAMPP** → Pour héberger et exécuter la plateforme PHP localement.  
