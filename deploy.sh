#!/bin/bash

# Check if a folder argument was provided
if [ -z "$1" ]; then
    echo "Usage: $0 <folder>"
    exit 1
fi

FOLDER="$1"

# Check if the folder exists and is a directory
if [ ! -d "$FOLDER" ]; then
    echo "Error: '$FOLDER' is not a valid directory"
    exit 1
fi

# Check if php is installed
if ! command -v php >/dev/null 2>&1; then
    echo "Error: php is not installed or not in PATH"
    exit 1
fi

# Find the first index.php inside the folder (recursive)
INDEX_FILE=$(find "$FOLDER" -type f -name "index.php" | head -n 1)

if [ -z "$INDEX_FILE" ]; then
    echo "Error: no index.php found in '$FOLDER'"
    exit 1
fi

# Get the directory containing index.php (PHP -S serves a doc root)
DOC_ROOT=$(dirname "$INDEX_FILE")

echo "Found: $INDEX_FILE"
echo "Doc root: $DOC_ROOT"
echo "Starting server at http://localhost:3000"
echo "Press Ctrl+C to stop."

# Start the PHP built-in server
php -S localhost:3000 -t "$DOC_ROOT"
