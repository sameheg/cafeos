# ChatGPT Codex — Fast Execution Guide

## Why this exists
Codex spins an isolated sandbox. After the **setup** phase, the environment is typically **offline**. If we cache deps and warm caches **once** in setup, subsequent tasks start fast.

## One‑time per repo
1. Connect GitHub → authorize the repo.
2. In Codex: **Environments → Create**.
3. Pick the repo/branch; set **Working directory** if monorepo.
4. Add **Secrets** (if needed): `GITHUB_TOKEN`, `COMPOSER_AUTH_JSON`, API keys.
5. Paste `CODEX_SETUP.md` script into **Setup Script**.
6. Save. Now tasks won’t reinstall toolchains each time.

## Task patterns (prompt)
- **Code task (recommended)**
  - Goal, Constraints, Entry points, Acceptance Criteria, Test plan.
  - Example:
    - Goal: Implement POS split tender (cash+card) with receipt & audit
    - Constraints: tenant scope + manager PIN for discounts >10%
    - Entry: `Modules/Pos/...`
    - AC: see `POS_P0_IMPLEMENTATION.md`
    - Test: add failing Feature test, then fix

- **Ask task**
  - Link context anchors: `README.md`, `ARCHITECTURE.md`, `CONTEXT_MAP.md`.

## Hotpaths to cache
- Composer/npm installs (done in setup)
- Laravel caches: `config/route/view`
- DB bootstrap/migrations (SQLite quick DB)

## Gotchas
- Don’t call external APIs during task run → preload in setup.
- Keep diffs small; Codex opens PRs faster on focused changes.
- Put module contracts/events in code comments near the entry points.
