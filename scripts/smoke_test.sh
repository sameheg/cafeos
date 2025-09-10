#!/bin/bash
set -e

BASE_URL="${1:-http://localhost}"

curl -fsS "$BASE_URL/health" >/dev/null
curl -fsS "$BASE_URL/metrics" >/dev/null

echo "Smoke tests passed."
