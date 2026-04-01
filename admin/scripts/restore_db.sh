#!/usr/bin/env bash
set -e

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
ENV_FILE="$SCRIPT_DIR/.env"
TMP_DIR=""

if [ ! -f "$ENV_FILE" ]; then
  echo "Fichier .env introuvable: $ENV_FILE"
  exit 1
fi

cleanup() {
  if [ -n "$TMP_DIR" ] && [ -d "$TMP_DIR" ]; then
    rm -rf "$TMP_DIR"
  fi
}

trap cleanup EXIT

set -a
source "$ENV_FILE"
set +a

BACKUP_DIR="${BACKUP_DIR:-$(cd "$SCRIPT_DIR/.." && pwd)/backups}"

if [ -z "$DBNAME" ] || [ -z "$DBUSER" ] || [ -z "$DBPASS" ] || [ -z "$DBHOST" ] || [ -z "$BACKUP_DIR" ]; then
  echo "Variables DBNAME, DBUSER, DBPASS, DBHOST ou BACKUP_DIR manquantes dans $ENV_FILE"
  exit 1
fi

if [ -n "$MYSQL_BIN" ]; then
  MYSQL_CMD="$MYSQL_BIN"
elif command -v mariadb >/dev/null 2>&1; then
  MYSQL_CMD="mariadb"
elif command -v mysql >/dev/null 2>&1; then
  MYSQL_CMD="mysql"
else
  echo "Aucun client SQL trouve. Installe mariadb ou mysql, ou definis MYSQL_BIN dans $ENV_FILE"
  exit 1
fi

if [ -n "$1" ]; then
  BACKUP_FILE="$1"
else
  BACKUP_FILE="$(find "$BACKUP_DIR" -maxdepth 1 -type f -name 'jukebox-db-*.tar.gz' | sort | tail -n 1)"
fi

if [ -z "$BACKUP_FILE" ]; then
  echo "Aucune archive de base trouvee dans $BACKUP_DIR"
  exit 1
fi

if [ ! -f "$BACKUP_FILE" ]; then
  echo "Fichier de sauvegarde introuvable: $BACKUP_FILE"
  exit 1
fi

if [[ "$BACKUP_FILE" == *.tar.gz ]]; then
  TMP_DIR="$(mktemp -d)"
  tar -xzf "$BACKUP_FILE" -C "$TMP_DIR"
  SQL_FILE="$(find "$TMP_DIR" -maxdepth 1 -name '*.sql' | head -n 1)"

  if [ -z "$SQL_FILE" ] || [ ! -f "$SQL_FILE" ]; then
    echo "Aucun fichier SQL trouve dans l'archive: $BACKUP_FILE"
    exit 1
  fi

  "$MYSQL_CMD" -h"$DBHOST" -P"${DBPORT:-3306}" -u"$DBUSER" -p"$DBPASS" "$DBNAME" < "$SQL_FILE"
elif [[ "$BACKUP_FILE" == *.sql ]]; then
  "$MYSQL_CMD" -h"$DBHOST" -P"${DBPORT:-3306}" -u"$DBUSER" -p"$DBPASS" "$DBNAME" < "$BACKUP_FILE"
else
  echo "Format non supporte: $BACKUP_FILE"
  echo "Utilise un fichier .sql ou une archive jukebox-db-*.tar.gz"
  exit 1
fi

echo "Restauration terminee depuis: $BACKUP_FILE"
