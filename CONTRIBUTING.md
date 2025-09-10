# Contributing Guide

## Rules
- Keep PRs small and focused.  
- Every module **must** define its own ServiceProvider:
  - Views → `$this->loadViewsFrom`
  - Translations → `$this->loadTranslationsFrom`
  - Routes → `$this->loadRoutesFrom`
  - Blade Components → `Blade::componentNamespace`
- Ensure strict tenant isolation (`BelongsToTenant`).  
- Follow event naming convention: `context.entity.action`.  
- Testing: unit, feature, and e2e coverage for critical flows.  
- Mandatory i18n/RTL support for UI changes.  
- Respect performance budgets (POS checkout < 200ms).  

## Workflow
1. Fork → branch (`feat/xyz`) → commit → PR.  
2. CI/CD runs linting, tests, security scan.  
3. Reviews require at least one approval.
