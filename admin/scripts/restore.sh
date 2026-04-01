#!/usr/bin/env bash
set -e

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
ENV_FILE="$SCRIPT_DIR/.env"

if [ ! -f "$ENV_FILE" ]; then
  echo "Fichier .env introuvable: $ENV_FILE"
  exit 1
fi

if [ -z "$1" ]; then
  echo "Usage: $0 chemin/vers/backup.sql|backup.tar.gz"
  exit 1
fi

BACKUP_FILE="$1"

if [ ! -f "$BACKUP_FILE" ]; then
  echo "Fichier SQL introuvable: $BACKUP_FILE"
  exit 1
fi

set -a
source "$ENV_FILE"
set +a

if [ -z "$DBNAME" ] || [ -z "$DBUSER" ] || [ -z "$DBPASS" ]; then
  echo "Variables DBNAME, DBUSER ou DBPASS manquantes dans $ENV_FILE"
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

if [[ "$BACKUP_FILE" == *.tar.gz ]]; then
  TMP_DIR="$(mktemp -d)"
  tar -xzf "$BACKUP_FILE" -C "$TMP_DIR"
  SQL_FILE="$(find "$TMP_DIR" -maxdepth 1 -name '*.sql' | head -n 1)"

  if [ -z "$SQL_FILE" ] || [ ! -f "$SQL_FILE" ]; then
    rm -rf "$TMP_DIR"
    echo "Aucun fichier SQL trouve dans l'archive: $BACKUP_FILE"
    exit 1
  fi

  "$MYSQL_CMD" -u"$DBUSER" -p"$DBPASS" "$DBNAME" < "$SQL_FILE"
  rm -rf "$TMP_DIR"
else
  "$MYSQL_CMD" -u"$DBUSER" -p"$DBPASS" "$DBNAME" < "$BACKUP_FILE"
fi

echo "Restauration terminee depuis: $BACKUP_FILE"
