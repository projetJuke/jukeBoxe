#!/usr/bin/env bash
set -e

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
ENV_FILE="$SCRIPT_DIR/.env"
TIMESTAMP="$(date "+%Y-%m-%d-%H-%M-%S")"

if [ ! -f "$ENV_FILE" ]; then
  echo "Fichier .env introuvable: $ENV_FILE"
  exit 1
fi

set -a
source "$ENV_FILE"
set +a

BACKUP_DIR="${BACKUP_DIR:-$(cd "$SCRIPT_DIR/.." && pwd)/backups}"
SQL_FILE="$BACKUP_DIR/jukebox-db-$TIMESTAMP.sql"
BACKUP_FILE="$BACKUP_DIR/jukebox-db-$TIMESTAMP.tar.gz"

if [ -z "$DBNAME" ] || [ -z "$DBUSER" ] || [ -z "$DBPASS" ] || [ -z "$DBHOST" ] || [ -z "$BACKUP_DIR" ]; then
  echo "Variables DBNAME, DBUSER, DBPASS, DBHOST ou BACKUP_DIR manquantes dans $ENV_FILE"
  exit 1
fi

if [ -n "$MYSQLDUMP_BIN" ]; then
  DUMP_CMD="$MYSQLDUMP_BIN"
elif command -v mariadb-dump >/dev/null 2>&1; then
  DUMP_CMD="mariadb-dump"
elif command -v mysqldump >/dev/null 2>&1; then
  DUMP_CMD="mysqldump"
else
  echo "Aucun binaire de dump trouve. Installe mariadb-dump ou mysqldump, ou definis MYSQLDUMP_BIN dans $ENV_FILE"
  exit 1
fi

mkdir -p "$BACKUP_DIR"
SQL_FILE="$BACKUP_DIR/jukebox-db-$TIMESTAMP.sql"
BACKUP_FILE="$BACKUP_DIR/jukebox-db-$TIMESTAMP.tar.gz"

"$DUMP_CMD" -h"$DBHOST" -P"${DBPORT:-3306}" -u"$DBUSER" -p"$DBPASS" "$DBNAME" > "$SQL_FILE"
tar -czf "$BACKUP_FILE" -C "$BACKUP_DIR" "$(basename "$SQL_FILE")"
rm -f "$SQL_FILE"

echo "Sauvegarde creee: $BACKUP_FILE"
