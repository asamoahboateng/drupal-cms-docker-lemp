#!/bin/bash

# Set database credentials
DB_HOST=${DB_HOST}
DB_USER=${DB_USER}
DB_PASSWORD=${DB_PASSWORD}
DB_NAME=${DB_NAME}

# Set backup directory
BACKUP_DIR=/var/backups

# Create backup directory if it doesn't exist
mkdir -p $BACKUP_DIR

# Dump database to backup file
mysqldump -h $DB_HOST -u $DB_USER -p$DB_PASSWORD $DB_NAME > $BACKUP_DIR/$(date +\%Y-\%m-\%d-\%H-\%M-\%S).sql