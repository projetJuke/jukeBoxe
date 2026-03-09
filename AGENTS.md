# Agent.md – Template de site vitrine Nuxt

## Objectif du dépôt

Ce dépôt sert de **template de base pour créer rapidement des sites vitrines** pour des clients.

Il contient une structure Nuxt prête à l’emploi, une configuration stable et des composants réutilisables.
L’objectif est de produire des sites **simples, rapides, maintenables et faciles à déployer**.

Pour chaque nouveau client, il faut partir de ce template afin de garder une architecture cohérente, un environnement maîtrisé et un temps de mise en place réduit.

Chaque projet client doit ensuite avoir **son propre dépôt Git**.

---

## Structure du projet

Le projet suit les conventions de Nuxt.

* `app.vue` : point d’entrée principal de l’application.
* `pages/` : pages du site. Chaque fichier correspond à une route.
* `layouts/` : layouts partagés entre les pages.
* `components/` : composants réutilisables (header, footer, sections).
* `public/` : fichiers statiques (images, favicon, robots.txt, sitemap…).
* `assets/` : styles ou ressources utilisées dans le build.
* `nuxt.config.ts` : configuration principale du projet.
* `package.json` : dépendances et scripts npm.

Chaque site client est une **copie de ce template**.

---

## Commandes de développement

Utiliser npm.

Installation des dépendances
`npm install`

Développement local
`npm run dev`

Build de production
`npm run build`

Prévisualisation du build
`npm run preview`

Génération statique pour l’hébergement
`npm run generate`

Les sites vitrines doivent être **générés en statique** afin d’être compatibles avec les hébergements mutualisés.

---

## Règles de développement pour l’agent

Lors de modifications du projet, respecter les règles suivantes :

Toujours privilégier **la simplicité et la performance**.

Toujours préférer **la génération statique avec Nuxt** plutôt qu’un serveur Node.

Ne jamais ajouter de dépendances inutiles.

Favoriser les **composants réutilisables** dans `components/`.

Respecter la structure du template et les conventions de Nuxt.

Utiliser **Tailwind CSS** avant d’écrire du CSS personnalisé.

Optimiser les images et éviter les fichiers lourds.

Toujours vérifier le **responsive** (mobile, tablette, desktop).

Respecter les bonnes pratiques **SEO de base** :
title, meta description, structure des titres.

Le code doit rester **clair, lisible et facile à maintenir**.

---

## Suivi du projet client

Chaque projet client doit contenir un fichier :

`SuiviClient.md`

Ce fichier doit documenter :

* les étapes de développement
* les choix techniques
* les dépendances utilisées
* les informations d’hébergement
* les instructions de déploiement
* les accès techniques si nécessaire

Ce document doit permettre une **maintenance facile du projet dans le futur**.

---

## Checklist avant réponse de l’agent

Avant de proposer une modification ou une solution :

* vérifier les fautes d’orthographe
* vérifier la clarté de la réponse
* vérifier que la réponse est complète
* vérifier que la réponse est pertinente par rapport à la question
* tester la solution si possible
* vérifier que la solution respecte les bonnes pratiques de développement
* vérifier que la solution est responsive et accessible
* vérifier que la solution reste compatible avec la génération statique

L’objectif est de fournir **des solutions simples, robustes et adaptées à un site vitrine**.
