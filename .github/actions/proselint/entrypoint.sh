entrypoint.sh#!/bin/bash
set -e

# Run proselint on all .md files
for file in $(find . -name '*.md'); do
  echo "Linting $file"
  proselint "$file"
done

