# Documentation technique du template Nuxt

## Résumé du projet

Ce dépôt est un template de site vitrine construit avec Nuxt 4, Vue 3 et Tailwind CSS.

Le code montre une application volontairement simple :

- deux pages publiques : l’accueil et les mentions légales
- un layout global avec en-tête et pied de page
- des composants de section réutilisables pour composer une page vitrine
- une configuration SEO de base
- une génération statique prévue pour le déploiement

Le projet ne contient pas de backend, pas d’API applicative et pas de logique métier complexe. Il sert de base de départ à personnaliser pour un client.

## Objectif et cas d’usage

L’objectif du dépôt est de fournir une base prête à adapter pour créer rapidement un site vitrine.

Cas d’usage visibles dans le code :

- présenter une activité ou un service
- afficher une page d’accueil structurée en sections
- proposer un formulaire de contact visuel
- exposer une page de mentions légales
- poser des bases SEO minimales pour une mise en ligne rapide

Le code laisse entendre que cette base doit être dupliquée pour des projets clients distincts. Cette intention est confirmée par le contenu de `AGENTS.md`, mais la mécanique de duplication n’est pas implémentée dans le code.

## Vue d’ensemble de l’architecture

L’architecture suit les conventions standards de Nuxt :

- `app.vue` délègue le rendu à `NuxtLayout` puis `NuxtPage`
- `layouts/default.vue` applique la structure globale commune
- `pages/` définit les routes
- `components/` regroupe les briques réutilisables
- `public/` contient les fichiers statiques servis tels quels
- `nuxt.config.ts` centralise la configuration globale

### Schéma de fonctionnement global

1. Nuxt démarre l’application via `app.vue`.
2. Le layout par défaut entoure chaque page avec `SiteHeader` et `SiteFooter`.
3. La page courante est rendue dans `<slot />` du layout.
4. Chaque page peut injecter ses métadonnées SEO via le composant `SeoPage`.
5. Le rendu final est prévu pour être généré statiquement via `nuxt generate`.

### Mode de rendu

Le projet active :

- `ssr: true`
- `nitro.preset = 'static'`

Cela signifie que le rendu côté serveur est utilisé par Nuxt, mais la cible de déploiement prévue est une génération statique. En pratique, le dépôt est pensé pour produire un site exportable sous forme de fichiers statiques.

## Organisation des dossiers et fichiers importants

### Racine

#### `package.json`

Déclare les scripts et dépendances principales :

- `npm run dev` : développement local
- `npm run build` : build de production
- `npm run generate` : génération statique
- `npm run preview` : prévisualisation
- `postinstall` : `nuxt prepare`

#### `nuxt.config.ts`

Fichier central de configuration. Il définit :

- l’activation des devtools
- le rendu SSR
- le preset Nitro statique
- les variables publiques de configuration
- les métadonnées HTML globales
- les modules Nuxt utilisés

#### `app.vue`

Point d’entrée minimal. Il ne contient aucune logique métier. Son rôle est uniquement d’imbriquer le layout et la page courante.

### `layouts/`

#### `layouts/default.vue`

Layout global unique du projet.

Responsabilités :

- appliquer la structure générale de la page
- rendre `SiteHeader`
- rendre le contenu principal dans `<main>`
- rendre `SiteFooter`

### `pages/`

#### `pages/index.vue`

Page d’accueil du template.

Elle contient :

- des données locales statiques pour les services
- des données locales statiques pour les témoignages
- des données locales statiques pour la FAQ
- l’assemblage des sections réutilisables

La page n’effectue aucun appel externe et ne lit aucune source de données distante.

#### `pages/mentions-legales.vue`

Page statique de mentions légales.

Le contenu visible est un texte de remplacement. Le code indique explicitement qu’il doit être remplacé avant mise en ligne. Il s’agit donc d’un squelette, pas d’un contenu final exploitable en production.

### `components/`

#### `components/SeoPage.vue`

Composant de centralisation SEO.

Responsabilités :

- calculer le titre de page
- calculer la description
- calculer l’URL canonique
- définir la balise `robots`
- alimenter `useSeoMeta`
- injecter le lien canonical via `useHead`

Ce composant ne rend rien de visible. Le `<span class="hidden" aria-hidden="true" />` sert uniquement à satisfaire le template.

#### `components/SectionBlock.vue`

Bloc de section générique.

Responsabilités :

- fournir une structure commune de section
- gérer un identifiant HTML optionnel
- afficher un eyebrow, un titre et une description
- exposer un slot principal et un slot `actions`
- appliquer une variante visuelle via la prop `variant`

Variantes visibles :

- `default`
- `muted`
- `hero`

Ce composant est central dans la composition de la page d’accueil.

#### `components/AppContainer.vue`

Conteneur de largeur maximale.

Responsabilité unique :

- limiter la largeur du contenu et appliquer des marges horizontales cohérentes

#### `components/ContentGrid.vue`

Grille réutilisable.

Responsabilités :

- accepter un nombre de colonnes limité à `2` ou `3`
- choisir la grille Tailwind correspondante

#### `components/BaseButton.vue`

Composant d’action réutilisable.

Responsabilités :

- rendre un `NuxtLink` si la prop `href` est présente
- rendre un bouton HTML sinon
- appliquer une variante visuelle `primary` ou `secondary`

Point important :

le composant sert à la fois pour la navigation et pour la soumission du formulaire.

#### `components/ServiceCard.vue`

Carte de service simple.

Responsabilités :

- afficher un titre
- afficher une description
- calculer un pseudo-identifiant visuel à partir des deux premières lettres du titre

Limite visible :

la logique `title.slice(0, 2)` suppose que le titre contient au moins deux caractères.

#### `components/TestimonialsSection.vue`

Section de témoignages prête à l’emploi.

Responsabilités :

- recevoir une liste d’éléments en props
- utiliser `SectionBlock`
- mettre en page les témoignages via `ContentGrid`

#### `components/FaqSection.vue`

Section FAQ prête à l’emploi.

Responsabilités :

- recevoir une liste de questions/réponses
- utiliser `SectionBlock`
- s’appuyer sur les éléments HTML natifs `details` et `summary`

Le choix de `details/summary` simplifie l’interaction sans JavaScript supplémentaire.

#### `components/ContactForm.vue`

Formulaire de contact statique.

Responsabilités visibles :

- afficher des champs de formulaire
- suggérer l’adresse de réception issue du runtime config public
- proposer un bouton de soumission

Limite majeure :

le formulaire ne possède ni état local, ni validation, ni envoi réseau, ni gestion de succès ou d’erreur. L’événement `@submit.prevent` bloque simplement la soumission native.

#### `components/SiteHeader.vue`

En-tête global.

Responsabilités :

- afficher le nom du site via `runtimeConfig.public.siteName`
- exposer une navigation principale
- rester visible en haut de l’écran grâce à un positionnement `sticky`

La navigation est codée en dur dans le composant.

#### `components/SiteFooter.vue`

Pied de page global.

Responsabilités :

- afficher le nom du site
- afficher l’email de contact
- exposer deux liens de navigation

### `public/`

#### `public/robots.txt`

Autorise tous les robots et référence un sitemap.

Limite visible :

le sitemap pointe vers `https://example.com/sitemap.xml`, qui est une valeur d’exemple et doit être remplacée pour un vrai projet.

#### `public/sitemap.xml`

Sitemap statique contenant deux URLs :

- `/`
- `/mentions-legales`

Limite visible :

les URLs utilisent également le domaine d’exemple `https://example.com`.

#### `public/favicon.ico`

Présence confirmée dans le dépôt. Son contenu n’a pas été analysé ici.

## Fonctionnement détaillé

### Configuration globale

La configuration lit plusieurs variables d’environnement publiques :

- `NUXT_PUBLIC_SITE_NAME`
- `NUXT_PUBLIC_SITE_URL`
- `NUXT_PUBLIC_SITE_DESCRIPTION`
- `NUXT_PUBLIC_CONTACT_EMAIL`

Si elles sont absentes, des valeurs par défaut sont utilisées :

- nom du site : `Template Studio`
- URL du site : `https://example.com`
- description : texte générique de template
- email de contact : `contact@example.com`

Ces valeurs alimentent :

- le titre global du site
- la description par défaut
- l’URL canonique
- le header
- le footer
- le formulaire de contact

### SEO et métadonnées

Le projet répartit le SEO entre :

- `nuxt.config.ts` pour les métadonnées globales
- `SeoPage.vue` pour les métadonnées par page

Dans `nuxt.config.ts`, on trouve :

- `lang="fr"` au niveau du document HTML
- un `titleTemplate`
- un `meta viewport`
- une meta description globale

Dans `SeoPage.vue`, on trouve :

- `title`
- `description`
- `ogTitle`
- `ogDescription`
- `ogSiteName`
- `ogType`
- `ogUrl`
- `twitterCard`
- `robots`
- lien canonical

Le calcul de l’URL canonique normalise le chemin fourni à la prop `path`, puis le combine avec `runtimeConfig.public.siteUrl`.

### Composition de la page d’accueil

La page d’accueil suit une composition séquentielle :

1. déclaration des données statiques dans le bloc `script setup`
2. injection du SEO de la page
3. rendu de la section hero
4. rendu de la liste de services
5. rendu du bloc de présentation
6. rendu des témoignages
7. rendu de la FAQ
8. rendu du formulaire de contact

Cette page joue aussi le rôle de démonstrateur de composants. Elle montre comment assembler les blocs existants pour construire une page client.

### Navigation

La navigation principale est définie localement dans `SiteHeader.vue` :

- `Accueil`
- `Services`
- `Presentation`
- `Contact`
- `Mentions legales`

Plusieurs liens ciblent des ancres de la page d’accueil :

- `/#services`
- `/#about`
- `/#contact`

Cela implique que les sections correspondantes portent bien les identifiants HTML attendus. C’est le cas dans `pages/index.vue`.

### Formulaire de contact

Le cycle actuel du formulaire est très limité :

1. l’utilisateur saisit des champs
2. il clique sur `Envoyer`
3. l’événement `submit` est intercepté
4. aucune action supplémentaire n’est effectuée

Il n’existe donc à ce stade :

- aucune persistance
- aucune validation métier
- aucun branchement vers une API
- aucun envoi d’email

### Page des mentions légales

La page utilise le même système de sections que l’accueil, mais avec un contenu purement textuel.

Le projet ne contient pas de mécanisme pour injecter automatiquement les données juridiques réelles d’un client. Le remplacement du texte se fait donc manuellement.

## Flux principaux ou cycle de vie

### Flux de rendu d’une page

1. Nuxt résout la route.
2. `app.vue` charge le layout.
3. `layouts/default.vue` rend le header, puis la page, puis le footer.
4. La page courante instancie ses composants de contenu.
5. Si la page utilise `SeoPage`, les métadonnées sont enregistrées pendant le rendu.

### Flux de configuration

1. Nuxt lit les variables d’environnement publiques.
2. `nuxt.config.ts` les expose via `runtimeConfig.public`.
3. Les composants récupèrent ces valeurs avec `useRuntimeConfig()`.
4. Les valeurs sont réutilisées dans le header, le footer, le SEO et le formulaire.

### Flux de génération statique

1. `npm run generate` exécute `nuxt generate`.
2. Nuxt pré-rend les routes connues.
3. Les fichiers statiques générés peuvent ensuite être servis sans serveur Node applicatif.

Le dépôt ne contient pas de configuration de déploiement. La cible d’hébergement exacte n’est donc pas vérifiable ici.

## Dépendances et intégrations visibles

### Dépendances directes

- `nuxt`
- `vue`
- `vue-router`
- `@nuxtjs/tailwindcss`
- `@nuxt/icon`

### Intégrations réellement visibles dans le code

#### Tailwind CSS

Très utilisé dans les templates pour toute la mise en forme.

Aucun fichier CSS personnalisé n’a été repéré dans les fichiers analysés.

#### Runtime config public Nuxt

Utilisé pour injecter des informations de branding et de contact sans les coder en dur partout.

#### Outils SEO Nuxt

- `useSeoMeta`
- `useHead`

#### `@nuxt/icon`

La dépendance est installée dans `package.json`, mais aucun usage explicite n’a été observé dans les composants analysés.

Ce point doit donc être considéré comme une dépendance présente mais non démontrée par le code consulté.

## Points sensibles, limites et dette technique visible

### Formulaire non fonctionnel

Le formulaire de contact est uniquement une interface visuelle. C’est la limite la plus importante du template.

### Contenus d’exemple

Plusieurs contenus sont manifestement provisoires :

- nom du site par défaut
- email de contact par défaut
- domaine `example.com`
- contenu de démonstration de la page d’accueil
- mentions légales génériques

Une mise en production sans remplacement de ces valeurs créerait des incohérences visibles.

### Sitemap et robots statiques

`robots.txt` et `sitemap.xml` utilisent des URLs codées en dur. Il n’existe pas de génération dynamique de ces fichiers à partir de `runtimeConfig.public.siteUrl`.

### Navigation mobile limitée

Dans `SiteHeader.vue`, la navigation est masquée sur petit écran via `md:flex`, sans menu mobile alternatif visible dans le code.

Conséquence :

sur mobile, seul le nom du site reste affiché dans le header. L’accès direct aux liens de navigation semble absent.

### Hiérarchie de titres à surveiller

`SectionBlock.vue` rend un `h1` dès qu’une prop `title` est fournie. Comme ce composant est réutilisé plusieurs fois dans une même page, plusieurs `h1` peuvent apparaître sur une seule page.

Ce choix n’est pas forcément bloquant techniquement, mais il doit être considéré comme un point SEO et sémantique à vérifier lors d’une personnalisation réelle.

### Absence de tests

Aucun fichier de test n’a été observé dans les éléments analysés.

### Pas de gestion de contenu structurée

Les contenus sont définis directement dans les composants de page. Il n’existe pas de couche dédiée pour :

- centraliser le contenu
- traduire le site
- brancher une source de données externe

Ce n’est pas un défaut pour un template simple, mais c’est une limite si le projet grossit.

## Guide de lecture rapide pour un nouveau développeur

Pour comprendre le projet rapidement, lire dans cet ordre :

1. `package.json` pour voir les scripts et dépendances.
2. `nuxt.config.ts` pour comprendre le mode de rendu, les variables publiques et les bases SEO.
3. `app.vue` puis `layouts/default.vue` pour voir la structure globale.
4. `pages/index.vue` pour comprendre comment la page d’accueil est composée.
5. `components/SectionBlock.vue`, `components/ContentGrid.vue` et `components/BaseButton.vue` pour comprendre les briques de composition.
6. `components/SeoPage.vue` pour le fonctionnement SEO.
7. `components/ContactForm.vue` pour identifier la limite actuelle du formulaire.
8. `pages/mentions-legales.vue`, `public/robots.txt` et `public/sitemap.xml` pour les obligations de mise en ligne.

### Ce qu’il faut retenir en priorité

- le projet est un template, pas un site finalisé
- la logique applicative est volontairement minimale
- la structure repose sur quelques composants réutilisables
- la configuration publique pilote le branding et certaines métadonnées
- le formulaire n’est pas connecté
- plusieurs contenus doivent être remplacés avant une mise en production

### Points non vérifiables à partir du code consulté

- la stratégie réelle de déploiement
- l’existence d’un pipeline CI/CD
- l’usage prévu de `@nuxt/icon`
- la présence éventuelle de conventions supplémentaires hors des fichiers analysés
