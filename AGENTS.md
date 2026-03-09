# AGENTS.md

## 1. Objectif

Maintenir ce dépôt comme template Nuxt de site vitrine simple, statique, réutilisable et rapide à déployer.

Produire des modifications minimales, cohérentes avec l’existant et faciles à reprendre sur un futur projet client.

## 2. Principes généraux

- Agis avec sobriété. Change uniquement ce qui est nécessaire.
- Privilégie la génération statique avec Nuxt. Ne bascule pas vers une architecture serveur.
- Préfère la simplicité, la lisibilité et la performance à l’abstraction.
- Respecte les conventions déjà visibles avant d’en introduire une nouvelle.
- Utilise Tailwind CSS avant d’ajouter du CSS personnalisé.
- Garde les contenus, composants et pages faciles à réutiliser pour d’autres clients.

## 3. Lecture obligatoire avant modification

Lis les fichiers concernés avant toute modification.

Lis au minimum :

- `package.json` pour les scripts et dépendances
- `nuxt.config.ts` pour le mode statique, le runtime config et les règles globales
- `app.vue` et `layouts/default.vue` pour la structure d’application
- les pages et composants touchés pour reprendre les patterns existants
- `AGENTS.md` en entier avant de commencer

Ne modifie jamais un fichier que tu n’as pas lu.

## 4. Règles de modification

- Modifie le plus petit nombre de fichiers possible.
- Réutilise d’abord les composants existants dans `components/`.
- Conserve les patterns actuels : `script setup`, TypeScript, composants Nuxt simples, classes Tailwind directement dans les templates.
- Préserve la structure actuelle : `pages/` pour les routes, `layouts/` pour les layouts, `components/` pour les blocs réutilisables, `public/` pour les assets statiques.
- Maintiens le SEO de base sur chaque page utile : title, description, structure de titres, canonical si le pattern existant s’applique.
- Si tu ajoutes une nouvelle règle ou convention non visible dans le dépôt, signale explicitement qu’elle est nouvelle.

## 5. Qualité du code

- Supprime le code mort. N’en ajoute jamais.
- Refuse la complexité inutile, les couches d’abstraction gratuites et les composants trop génériques.
- Évite les dépendances supplémentaires sauf besoin clair et justifié.
- Garde des noms explicites et un balisage accessible.
- Vérifie le responsive mobile, tablette et desktop.
- Vérifie que le résultat reste compatible avec `npm run generate`.
- Corrige les fautes visibles dans les contenus modifiés.

## 6. Cohérence architecturale

- Préserve l’orientation actuelle du projet : site vitrine Nuxt 4 avec SSR activé et preset Nitro statique.
- N’introduis pas de logique backend, d’état global complexe ou de système CMS improvisé.
- Centralise les métadonnées SEO selon le mécanisme déjà en place, notamment le composant `SeoPage` quand il convient.
- Préfère des sections réutilisables et composables plutôt que du code dupliqué dans les pages.
- N’ajoute pas de convention de dossiers nouvelle sans nécessité démontrée.
- `SuiviClient.md` est requis pour un projet client. S’il est demandé dans ce dépôt dérivé, crée-le et documente les choix techniques, l’hébergement et le déploiement.

## 7. Sécurité Git

- Ne crée aucun commit sans demande explicite.
- Ne fais aucun `git push` sans demande explicite.
- Ne fais aucun `git push --force` sans demande explicite.
- Ne réécris pas l’historique sans demande explicite.
- Ne supprime pas ni ne reviens sur des changements que tu n’as pas produits.
- Si l’arbre Git contient des modifications inattendues, isole ton travail et n’écrase rien.

## 8. Sécurité

- Ne place aucun secret, mot de passe, token ou accès sensible dans le code, les commits ou la documentation.
- N’expose pas de données privées dans `public/` ou dans le code client.
- Vérifie les URLs, emails et métadonnées avant de les publier.
- N’ajoute pas de script externe, tracker ou dépendance distante sans besoin clair.

## 9. Prise de décision

- Commence par observer l’existant, puis décide.
- Si plusieurs options sont possibles, choisis la plus simple et la plus locale.
- Si une demande pousse à casser l’architecture du template, propose une alternative minimale.
- Si une information manque, n’invente pas un standard de projet. Appuie-toi sur les fichiers présents et signale l’incertitude si nécessaire.

## 10. Actions interdites

- Ajouter du code mort, du code spéculatif ou des TODO non demandés.
- Introduire une dépendance sans justification technique concrète.
- Refondre l’architecture sans nécessité explicite.
- Mélanger un changement métier avec des retouches hors sujet.
- Remplacer les patterns existants par une préférence personnelle.
- Dégrader le SEO, l’accessibilité, la performance ou la génération statique.
- Modifier des fichiers non liés juste pour “uniformiser”.

## 11. Résultat attendu

Le résultat doit être :

- court à relire
- directement exploitable
- cohérent avec le template existant
- compatible avec un site vitrine statique Nuxt
- propre sur mobile et desktop
- sans régression évidente de SEO, d’accessibilité ou de structure

Chaque modification doit laisser le dépôt plus clair, pas plus complexe.
