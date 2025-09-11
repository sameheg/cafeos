# Testing Guide

## Types of Tests
- Unit tests → Pest/PHPUnit.  
- Integration tests → module interactions.  
- E2E tests → Cypress/Dusk.  

## Commands
```bash
composer test
npm run test:e2e
```

## Coverage
- Minimum 80% coverage per module.  

## CI Integration
- All PRs trigger full test suite.  
