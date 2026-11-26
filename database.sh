#!/bin/bash

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

sudo -i -u postgres psql -f "$SCRIPT_DIR/setup.sql"
