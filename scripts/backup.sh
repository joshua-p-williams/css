#!/bin/bash

__usage="
Usage: $(basename "$0") [OPTIONS]... [COMMAND]

Script to safely back up the CSS project.

Options:
    -h, --help               Show this help message
    -p, --project-path PATH  Specify the project base path (default: auto-detected)

Commands:
    backup-all               Create a full project backup
    backup-db                Create a database backup (MySQL volume only)
    restore-db FILE          Restore the database from a .tar.gz backup file
"

# Defaults
__project_path="$( cd "$( dirname "${BASH_SOURCE[0]}" )/.." && pwd )"
__backup_dir="$__project_path/public/backup"

# Logging helpers
info() {
    echo -e "\033[0;34m[INFO] $1\033[0m"
}

success() {
    echo -e "\033[0;32m[SUCCESS] $1\033[0m"
}

error() {
    echo -e "\033[0;31m[ERROR] $1\033[0m"
}

fail() {
    error "$1"
    exit 1
}

ensure_backup_dir_exists() {
    if [ ! -d "$__backup_dir" ]; then
        info "Creating backup directory at $__backup_dir"
        mkdir -p "$__backup_dir" || fail "Could not create backup directory"
    fi
}

timestamp() {
    date +%Y-%m-%d-%H-%M-%S
}

backup_all() {
    ensure_backup_dir_exists
    local stamp
    stamp=$(timestamp)
    local tarball="$__backup_dir/all-$stamp.tar.gz"
    local latest="$__backup_dir/all-latest.tar.gz"

    info "Creating full project backup..."
    tar -czf "$tarball" -C "$__project_path" . --exclude='./public/backup' || fail "Failed to create full backup"
    cp -f "$tarball" "$latest" || fail "Failed to copy latest backup"
    success "Full backup created: $tarball"
    success "Updated latest backup: $latest"
}

backup_db() {
    ensure_backup_dir_exists
    local stamp
    stamp=$(timestamp)
    local tarball="$__backup_dir/db-$stamp.tar.gz"
    local latest="$__backup_dir/db-latest.tar.gz"

    info "Creating database backup..."
    local db_path="$__project_path/.mysql-data"
    if [ ! -d "$db_path" ]; then
        fail "Database directory not found at $db_path"
    fi

    tar -czf "$tarball" -C "$__project_path" .mysql-data || fail "Failed to create DB backup"
    cp -f "$tarball" "$latest" || fail "Failed to copy latest DB backup"
    success "Database backup created: $tarball"
    success "Updated latest DB backup: $latest"
}

restore_db() {
    local archive_path="$1"

    if [ -z "$archive_path" ]; then
        fail "You must provide the path to a .tar.gz backup file."
    fi

    if [ ! -f "$archive_path" ]; then
        fail "Backup file does not exist: $archive_path"
    fi

    if [[ "$archive_path" != *.tar.gz ]]; then
        fail "Backup file must be a .tar.gz archive"
    fi

    local db_path="$__project_path/.mysql-data"

    info "Restoring database from archive: $archive_path"

    # Remove existing database directory
    if [ -d "$db_path" ]; then
        info "Removing existing database directory at $db_path"
        rm -rf "$db_path" || fail "Failed to remove existing .mysql-data"
    fi

    # Extract tarball into project root
    tar -xzf "$archive_path" -C "$__project_path" || fail "Failed to extract archive"

    if [ ! -d "$db_path" ]; then
        fail "Expected .mysql-data directory was not restored from archive"
    fi

    success "Database successfully restored from $archive_path"
}

# Argument parsing
POSITIONAL=()
while [[ $# -gt 0 ]]; do
    key="$1"
    case $key in
        -h|--help)
            echo "$__usage"
            exit 0
            ;;
        -p|--project-path)
            __project_path="$2"
            __backup_dir="$__project_path/public/backup"
            shift
            shift
            ;;
        *) # unknown option or command
            POSITIONAL+=("$1")
            shift
            ;;
    esac
done

set -- "${POSITIONAL[@]}"
__command=${POSITIONAL[0]}

# Command dispatcher
case "$__command" in
    backup-all)
        backup_all
        ;;
    backup-db)
        backup_db
        ;;
    restore-db)
        restore_db "${POSITIONAL[1]}"
        ;;
    *)
        echo "$__usage"
        exit 1
        ;;
esac
