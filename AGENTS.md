# AGENTS.md

## Objectif

Développer Jukebox comme une application web locale, simple et rapide à faire évoluer, destinée à fonctionner sur Raspberry Pi sans dépendre d'un accès réseau côté utilisateur.

L'agent agit comme un développeur fullstack orienté simplicité. Il privilégie les solutions courtes, lisibles et directement exploitables.

## Principes généraux

- Respecter strictement la séparation entre frontend, backend et admin.
- Garder une seule source de vérité pour la logique métier: le backend.
- Faire transiter toutes les données par une API JSON.
- Favoriser des fonctions simples, des fichiers courts et des flux explicites.
- Optimiser pour un fonctionnement local fiable avant toute autre considération.

## Lecture obligatoire avant modification

Avant toute modification, lire au minimum:

- le fichier ciblé
- les fichiers directement appelés par ce fichier
- les points d'entrée concernés
- les routes API ou handlers impactés

Ne jamais modifier un fichier en supposant son rôle sans l'avoir lu.

## Règles de modification

- Modifier seulement ce qui est nécessaire au besoin demandé.
- Conserver l'architecture existante si elle reste cohérente avec ces règles.
- Si une logique métier change, la modifier dans le backend puis adapter le frontend.
- Si une donnée est utilisée par plusieurs interfaces, la définir une seule fois côté backend.
- Si un comportement n'a pas sa place dans le frontend, le déplacer vers l'API.

## Qualité du code

- Écrire du PHP simple sans framework et sans couche d'abstraction inutile.
- Préférer des fonctions claires à des classes introduites par habitude.
- Retourner du JSON cohérent, avec des structures stables et explicites.
- Éviter la sur-ingénierie, les patterns décoratifs et les helpers génériques prématurés.
- Supprimer le code mort, les branches inutiles et les doublons.

## Cohérence architecturale

Structure cible:

- `frontend/`: interface principale Nuxt pour consulter, sélectionner et lancer la lecture.
- `backend/public/index.php`: point d'entrée HTTP.
- `backend/routes/api.php`: définition des routes API.
- `backend/handlers/*.php`: logique métier et orchestration.
- `backend/core/db.php`: connexion base de données centralisée.
- `admin/`: interface d'administration séparée si nécessaire.

Règles strictes:

- Ne jamais mélanger rendu frontend et logique backend dans le même fichier.
- Ne jamais accéder directement à la base depuis Nuxt ou depuis l'admin JS.
- Ne jamais dupliquer une règle métier entre Nuxt et l'admin.
- Toute lecture ou écriture métier passe par une route API JSON.
- L'interface admin suit les mêmes règles d'API que le frontend principal.

## Standards de code

### PHP

- Utiliser un PHP procédural simple ou des fonctions isolées par responsabilité.
- Mettre la logique HTTP minimale dans `public/index.php`.
- Garder `routes/api.php` centré sur le mapping route -> handler.
- Mettre la logique métier dans `handlers/`.
- Centraliser la connexion base de données dans `core/db.php`.

### Frontend Nuxt

- Limiter le frontend à l'affichage, à la collecte d'actions utilisateur et aux appels API.
- Ne pas embarquer de logique métier, de règles d'autorisation ou de règles de planification.
- Garder les appels réseau explicites et proches des usages.

### JSON

- Répondre avec `application/json`.
- Utiliser des clés stables, lisibles et prévisibles.
- Retourner des erreurs explicites avec un code HTTP adapté quand c'est possible.

## Nommage et organisation des fichiers

- Nommer les routes API avec des noms métier simples et stables.
- Nommer les handlers selon l'action métier réelle, pas selon la technologie.
- Utiliser des noms de fichiers explicites: `getPlaylists.php`, `savePlaylist.php`, `getUsagePeriods.php`.
- Éviter les fichiers fourre-tout du type `utils.php`, `common.php`, `apiHelpers.php` si la responsabilité n'est pas nette.
- Garder les fichiers frontend alignés sur l'organisation Nuxt existante.

## Sécurité Git

- Ne jamais faire de commit, push, force-push ou rebase sans demande explicite.
- Ne jamais réécrire l'historique sans instruction explicite.
- Ne jamais écraser des changements non liés au besoin traité.

## Sécurité

- Valider toutes les entrées côté backend.
- Ne jamais faire confiance aux données envoyées par le frontend ou l'admin.
- Sanitiser les paramètres utilisés dans les requêtes SQL.
- Utiliser une connexion DB centralisée et des requêtes préparées si une base SQL est en jeu.
- Vérifier les cas d'erreur simples: paramètres manquants, format invalide, ressource absente.
- Éviter toute dépendance à un service réseau externe pour une fonctionnalité critique du jukebox.

## Prise de décision

- Choisir la solution la plus simple qui couvre le besoin complet.
- Refuser d'ajouter une abstraction si elle ne réduit pas un vrai coût actuel.
- En cas d'hésitation, privilégier:
  1. clarté
  2. centralisation backend
  3. fonctionnement local
  4. facilité de maintenance

## Actions interdites

- Ajouter un framework PHP.
- Mettre de la logique métier dans Nuxt, dans le JS admin ou dans des composants UI.
- Dupliquer les règles métier entre plusieurs interfaces.
- Introduire des websockets, files de messages, microservices ou caches complexes sans besoin explicite.
- Créer des couches `service`, `repository`, `manager` ou `factory` par réflexe.
- Coder "pour plus tard" au lieu de répondre au besoin réel.

## Exemples concrets

### Route API

```php
// backend/routes/api.php
$routes['GET']['/api/playlists'] = 'getPlaylists';
$routes['POST']['/api/playlists'] = 'savePlaylist';
```

### Handler PHP

```php
// backend/handlers/getPlaylists.php
function getPlaylists(PDO $db): void
{
    $stmt = $db->query('SELECT id, name FROM playlists ORDER BY name ASC');
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode(['playlists' => $items]);
}
```

### Appel depuis Nuxt

```ts
// frontend/pages/index.vue
const { data, error } = await useFetch('/api/playlists')
```

Rappel:

- le frontend affiche `data`
- le backend décide du format, des validations et des règles métier
- l'admin consomme la même API JSON

## Résultat attendu

Chaque changement produit par l'agent doit:

- respecter la séparation frontend/backend/admin
- conserver la logique métier dans le backend
- rester court, lisible et testable manuellement
- fonctionner en local sur le jukebox sans dépendance externe critique
