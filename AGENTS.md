# AGENTS.md

## 1. Objectif

Maintiens ce dépôt comme template Nuxt 4 de site vitrine simple, réutilisable et compatible avec la génération statique.

Fais des modifications courtes, locales et faciles à reprendre sur un futur projet client.

## 2. Principes généraux

- Change uniquement ce qui est nécessaire.
- Respecte d’abord les conventions déjà présentes dans le dépôt.
- Préfère la simplicité, la lisibilité et la performance.
- Garde une architecture frontend légère. N’ajoute ni logique backend, ni couche métier complexe.
- Utilise Tailwind CSS avant d’écrire du CSS personnalisé.
- Conserve des composants et contenus faciles à adapter pour d’autres clients.

## 3. Lecture obligatoire avant modification

Lis toujours les fichiers avant de les modifier.

Lis au minimum :

- `AGENTS.md`
- `package.json`
- `nuxt.config.ts`
- `app.vue`
- `layouts/default.vue`
- chaque page, composant ou fichier de configuration concerné par ta modification

Ne modifie jamais un fichier que tu n’as pas lu.

## 4. Règles de modification

- Modifie le plus petit nombre de fichiers possible.
- Réutilise d’abord les composants existants dans `components/`.
- Conserve les patterns visibles : `script setup`, TypeScript, composants simples, classes Tailwind directement dans les templates.
- Préserve la structure actuelle : `pages/`, `components/`, `layouts/`, `public/`.
- Utilise `SeoPage` pour les métadonnées de page quand le besoin correspond au pattern existant.
- Réutilise `SectionBlock`, `ContentGrid`, `BaseButton` et les blocs existants avant d’en créer de nouveaux.
- Garde les contenus simples et locaux à la page quand c’est déjà le cas. N’introduis pas de couche de données ou de CMS improvisé.
- Passe par `runtimeConfig.public` pour les informations globales déjà centralisées comme le nom du site, l’URL ou l’email de contact.
- Si tu introduis une convention absente du dépôt, signale explicitement qu’elle est nouvelle.

## 5. Qualité du code

- N’ajoute aucun code mort.
- Supprime le code mort rencontré s’il est dans le périmètre direct de ta modification.
- Refuse la complexité inutile, les abstractions gratuites et les composants trop génériques.
- N’ajoute pas de dépendance sans besoin concret.
- Garde des noms explicites et un balisage accessible.
- Vérifie le responsive mobile, tablette et desktop.
- Vérifie que le résultat reste compatible avec `npm run generate`.
- Corrige les fautes visibles dans les contenus que tu modifies.

## 6. Cohérence architecturale

- Préserve l’orientation actuelle : Nuxt 4, SSR activé, preset Nitro `static`.
- Ne bascule pas vers une architecture serveur.
- Ne remplace pas les métadonnées centralisées par du SEO dispersé page par page sans raison.
- Préfère des sections composables à la duplication de blocs dans les pages.
- Ne crée pas de nouveau dossier ou de nouvelle convention de rangement sans nécessité claire.
- Respecte le niveau de simplicité actuel des composants. N’ajoute pas d’état global complexe.

## 7. Sécurité Git

- Ne crée aucun commit sans demande explicite.
- Ne fais aucun `git push` sans demande explicite.
- Ne fais aucun `git push --force` sans demande explicite.
- Ne réécris pas l’historique sans demande explicite.
- Ne supprime pas et ne réécris pas des changements que tu n’as pas produits.
- Si l’arbre Git contient des modifications inattendues, isole ton travail et n’écrase rien.

## 8. Sécurité

- N’écris aucun secret, mot de passe, token ou accès sensible dans le code ou la documentation.
- N’expose aucune donnée privée dans `public/` ou dans le code client.
- Vérifie les URLs, emails, coordonnées et métadonnées avant publication.
- N’ajoute aucun script externe, tracker ou ressource distante sans besoin clair.
- Ne laisse pas en production des contenus manifestement provisoires comme des coordonnées d’exemple ou des mentions légales non remplacées.

## 9. Prise de décision

- Observe l’existant avant de décider.
- Choisis l’option la plus simple et la plus locale.
- Si la demande pousse à casser l’architecture du template, propose une alternative minimale.
- N’invente pas de standard de projet en l’absence d’indice clair dans le dépôt.
- En cas d’incertitude, appuie-toi sur les fichiers présents et signale explicitement l’hypothèse retenue.

## 10. Actions interdites

- Ajouter du code mort, spéculatif ou non utilisé.
- Ajouter des TODO non demandés.
- Introduire une dépendance sans justification technique précise.
- Refondre l’architecture sans nécessité explicite.
- Mélanger un besoin réel avec des retouches hors sujet.
- Remplacer un pattern existant par une préférence personnelle.
- Dégrader le SEO, l’accessibilité, la performance ou la compatibilité avec la génération statique.
- Modifier des fichiers non liés pour uniformiser le style.

## 11. Résultat attendu

Le résultat doit être :

- court à relire
- strict et immédiatement applicable
- cohérent avec les conventions visibles du dépôt
- compatible avec un site vitrine Nuxt généré statiquement
- propre sur mobile et desktop
- sans régression évidente de structure, de SEO, d’accessibilité ou de performance

Chaque modification doit rendre le dépôt plus clair, pas plus complexe.
