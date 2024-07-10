#!/bin/bash

# Configurable variables
REPO_URL="https://github.com/MedBens02/Web_proj.git"
WEB_ROOT="/var/www/html"
PROJECT_DIR="$WEB_ROOT/proj"
DB_NAME="plateforme_scolaire"
DB_USER="root"
DB_PASS="" # Password is empty, set if you have a password
SQL_FILE_PATH="$PROJECT_DIR/database/plateforme_scolaire.sql" # Change to your actual SQL file path

# Clone the repository
echo "Cloning repository..."
git clone $REPO_URL $PROJECT_DIR

# Check if cloning was successful
if [ ! -d "$PROJECT_DIR" ]; then
    echo "Failed to clone repository."
    exit 1
else
    echo "Repository cloned successfully."
fi

# Create the database
echo "Creating database..."
mysql -u $DB_USER -p$DB_PASS -e "CREATE DATABASE IF NOT EXISTS $DB_NAME;"

# Check if database was created successfully
if [ $? -ne 0 ]; then
    echo "Failed to create database."
    exit 1
else
    echo "Database created successfully."
fi

# Import SQL file
echo "Importing SQL file..."
mysql -u $DB_USER -p$DB_PASS $DB_NAME < $SQL_FILE_PATH

# Check if SQL import was successful
if [ $? -ne 0 ]; then
    echo "Failed to import SQL file."
    exit 1
else
    echo "SQL file imported successfully."
fi

echo "Setup completed successfully."
