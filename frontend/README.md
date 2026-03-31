# Template Nuxt pour site vitrine

## Résumé

Ce dépôt est un template de site vitrine construit avec Nuxt 4, Vue 3 et Tailwind CSS.

Il fournit une base simple et réutilisable avec :

- une page d’accueil composée de sections prêtes à personnaliser
- une page de mentions légales
- un layout global avec header et footer
- une configuration SEO de base
- une cible de génération statique pour le déploiement

Le projet est pensé comme une base de départ pour un futur site client. Il ne contient pas de backend ni de logique métier complexe.

## Objectif et cas d’usage

L’objectif du dépôt est de permettre de démarrer rapidement un site vitrine sans repartir d’un projet vide.

Cas d’usage visibles dans le code :

- présenter une activité, un service ou une petite structure
- afficher une page d’accueil structurée avec hero, services, présentation, témoignages, FAQ et contact
- publier une page de mentions légales
- préparer un site exportable en statique

Le dépôt sert de template. La duplication vers un dépôt client séparé est mentionnée dans `AGENTS.md`, mais cette étape n’est pas automatisée dans le code.

## Stack visible

- Nuxt 4
- Vue 3
- Vue Router 4
- Tailwind CSS via `@nuxtjs/tailwindcss`
- module `@nuxt/icon`

Remarque : `@nuxt/icon` est installé, mais aucun usage explicite n’a été relevé dans les composants analysés.

## Prérequis

Prérequis réellement vérifiables à partir du dépôt :

- Node.js installé
- npm disponible

La version exacte de Node.js n’est pas indiquée dans les fichiers analysés. Elle n’est donc pas vérifiable ici.

## Installation

Le dépôt indique l’usage de `npm`.

```bash
npm install
```

Après installation, le script `postinstall` exécute `nuxt prepare`.

## Dépendances importantes

### `nuxt`

Framework principal du projet. Il structure les pages, layouts, composants et le rendu.

### `@nuxtjs/tailwindcss`

Permet l’usage de Tailwind CSS dans les templates. La mise en forme du projet repose largement sur des classes utilitaires directement dans les composants.

### `vue` et `vue-router`

Dépendances de base du framework et de la navigation.

### `@nuxt/icon`

Module installé dans `nuxt.config.ts`. Son usage n’est pas démontré dans les fichiers consultés.

## Configuration visible

Le fichier `nuxt.config.ts` expose une configuration publique via `runtimeConfig.public`.

Variables d’environnement visibles :

- `NUXT_PUBLIC_SITE_NAME`
- `NUXT_PUBLIC_SITE_URL`
- `NUXT_PUBLIC_SITE_DESCRIPTION`
- `NUXT_PUBLIC_CONTACT_EMAIL`

Valeurs par défaut si elles ne sont pas définies :

- nom du site : `Template Studio`
- URL du site : `https://example.com`
- description : `Base Nuxt pour site vitrine avec sections reutilisables et configuration SEO.`
- email de contact : `contact@example.com`

Ces valeurs sont utilisées dans :

- les métadonnées globales
- le composant SEO
- le header
- le footer
- le formulaire de contact

## Commandes utiles

### Développement local

```bash
npm run dev
```

Lance le serveur de développement Nuxt.

### Build de production

```bash
npm run build
```

Construit l’application pour la production.

### Génération statique

```bash
npm run generate
```

Génère une version statique du site. C’est la commande la plus cohérente avec la configuration actuelle du dépôt.

### Prévisualisation du build

```bash
npm run preview
```

Permet de prévisualiser le build produit par Nuxt.

## Structure du projet

```text
.
├── app.vue
├── components/
│   ├── AppContainer.vue
│   ├── BaseButton.vue
│   ├── ContactForm.vue
│   ├── ContentGrid.vue
│   ├── FaqSection.vue
│   ├── SectionBlock.vue
│   ├── SeoPage.vue
│   ├── ServiceCard.vue
│   ├── SiteFooter.vue
│   ├── SiteHeader.vue
│   └── TestimonialsSection.vue
├── layouts/
│   └── default.vue
├── pages/
│   ├── index.vue
│   └── mentions-legales.vue
├── public/
│   ├── favicon.ico
│   ├── robots.txt
│   └── sitemap.xml
├── nuxt.config.ts
└── package.json
```

## Organisation fonctionnelle

### `app.vue`

Point d’entrée minimal. Charge le layout Nuxt puis la page courante.

### `layouts/default.vue`

Applique la structure globale commune :

- header
- contenu principal
- footer

### `pages/index.vue`

Page d’accueil du template. Elle assemble les sections réutilisables et déclare localement les contenus d’exemple :

- services
- témoignages
- FAQ

### `pages/mentions-legales.vue`

Page statique de mentions légales avec contenu de remplacement.

### `components/SeoPage.vue`

Composant dédié au SEO par page :

- titre
- description
- canonical
- balise `robots`
- métadonnées Open Graph minimales

### `components/SectionBlock.vue`

Composant principal de composition des sections. Il standardise la structure et l’apparence des blocs de page.

### `components/ContactForm.vue`

Formulaire de contact d’interface uniquement. Il n’effectue aucun envoi à ce stade.

## Points d’attention et limites visibles

### Formulaire non connecté

Le formulaire de contact intercepte la soumission avec `@submit.prevent`, mais ne contient :

- aucune validation
- aucun état local
- aucun appel réseau
- aucune logique d’envoi d’email

Il faut donc le considérer comme un squelette d’interface.

### Contenus et URLs d’exemple

Plusieurs valeurs sont manifestement provisoires :

- `Template Studio`
- `contact@example.com`
- `https://example.com`
- les textes de démonstration de la page d’accueil
- les textes génériques des mentions légales

Une personnalisation est nécessaire avant toute mise en ligne.

### `robots.txt` et `sitemap.xml` statiques

Ces fichiers existent dans `public/`, mais utilisent des URLs codées en dur avec le domaine `example.com`.

Le dépôt ne montre pas de génération automatique de ces fichiers à partir de `NUXT_PUBLIC_SITE_URL`.

### Navigation mobile incomplète

Le header masque la navigation sur petit écran et aucun menu mobile alternatif n’est visible dans le code analysé.

### Hiérarchie de titres à surveiller

Le composant `SectionBlock` rend un `h1` quand une prop `title` est fournie. Comme plusieurs sections utilisent ce composant, une page peut contenir plusieurs `h1`.

Ce point doit être revu lors de la personnalisation si la sémantique HTML ou le SEO doivent être durcis.

### Tests non visibles

Aucun script de test ni fichier de test n’a été relevé dans les fichiers consultés.

## Démarrage rapide

```bash
npm install
npm run dev
```

Pour préparer une version statique :

```bash
npm run generate
```

## Ce qui n’est pas vérifiable ici

Les éléments suivants ne sont pas démontrés par les fichiers consultés :

- version minimale exacte de Node.js
- pipeline CI/CD
- procédure de déploiement précise
- usage réel du module `@nuxt/icon`
