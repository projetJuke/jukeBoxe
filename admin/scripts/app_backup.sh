#!/usr/bin/env bash
set -e

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
PROJECT_DIR="$(cd "$SCRIPT_DIR/../.." && pwd)"
TIMESTAMP="$(date "+%Y-%m-%d-%H-%M-%S")"

if [ ! -f "$SCRIPT_DIR/.env" ]; then
  echo "Fichier .env introuvable: $SCRIPT_DIR/.env"
  exit 1
fi

set -a
source "$SCRIPT_DIR/.env"
set +a

BACKUP_DIR="${BACKUP_DIR:-$(cd "$SCRIPT_DIR/.." && pwd)/backups}"
BACKUP_FILE="$BACKUP_DIR/jukebox-app-$TIMESTAMP.tar.gz"

mkdir -p "$BACKUP_DIR"

TAR_ARGS=()

case "$BACKUP_DIR" in
  "$PROJECT_DIR"/*)
    EXCLUDE_PATH="${BACKUP_DIR#$PROJECT_DIR/}"
    TAR_ARGS+=("--exclude=./$EXCLUDE_PATH")
    ;;
esac

tar "${TAR_ARGS[@]}" -czf "$BACKUP_FILE" -C "$PROJECT_DIR" .

echo "Sauvegarde creee: $BACKUP_FILE"
