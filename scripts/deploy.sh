#!/bin/bash
set -e

STACK="cafeos"
ACTIVE_COLOR=$(cat CURRENT_COLOR 2>/dev/null || echo blue)
if [ "$ACTIVE_COLOR" = "blue" ]; then
  NEW_COLOR="green"
else
  NEW_COLOR="blue"
fi

echo "Deploying ${NEW_COLOR} stack..."

docker compose -p "${STACK}-${NEW_COLOR}" -f production.yml up -d --build

if ./scripts/smoke_test.sh "http://localhost"; then
  echo "${NEW_COLOR}" > CURRENT_COLOR
  echo "Deployment succeeded. Switch traffic to ${NEW_COLOR}."
else
  echo "Smoke tests failed. Rolling back ${NEW_COLOR} stack." >&2
  docker compose -p "${STACK}-${NEW_COLOR}" -f production.yml down
  exit 1
fi
