#!/usr/bin/env bash
# Regenerate Table of Contents for markdown files with >20 lines.
set -e

# Find markdown files (excluding DOC_TEMPLATE) and update TOC if file has more than 20 lines.
find . -name "*.md" -not -name "DOC_TEMPLATE.md" | while read -r file; do
  if [ $(wc -l < "$file") -gt 20 ]; then
    npx doctoc "$file" --title "## Table of Contents" >/dev/null
  fi
done

# Last Updated: 2025-09-11 by ChatGPT
