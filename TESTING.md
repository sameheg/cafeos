<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
## Table of Contents

- [Testing Guide](#testing-guide)
  - [Overview](#overview)
  - [Prerequisites](#prerequisites)
  - [Setup](#setup)
  - [Usage](#usage)
  - [References](#references)
  - [Types of Tests](#types-of-tests)
  - [Commands](#commands)
  - [Coverage](#coverage)
  - [CI Integration](#ci-integration)
  - [Unit Tests](#unit-tests)
  - [Integration Tests](#integration-tests)
  - [Performance Tests](#performance-tests)
  - [Model Validation](#model-validation)
  - [Related Docs](#related-docs)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

# Testing Guide

## Overview
- This section outlines the primary goals and scope of Testing.

## Prerequisites
- Familiarity with basic Testing concepts and system requirements is recommended.

## Setup
- Follow these steps to configure and enable Testing in your environment.

## Usage
- Instructions and examples for applying Testing in day-to-day operations.

## References
- Additional resources and documentation about Testing for further learning.


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

## Unit Tests
- Execute fast feedback loops with Pest.
```bash
./vendor/bin/pest
```
```
Pest 2.x
✓ example test passes
```

## Integration Tests
- Validate module interactions via PHPUnit.
```bash
./vendor/bin/phpunit --testsuite=Integration
```
```
PHPUnit 9.x
..                                                                  2 / 2 (100%)
```

## Performance Tests
- Assess client performance with Cypress.
```bash
npx cypress run --config-file cypress.performance.config.js
```
```
All specs passed!                             3 of 3 completed (2s)
```

## Model Validation
- Verify AI model quality and response speed.
```bash
python scripts/validate_models.py
```
```
assistant_accuracy=0.91 latency=180ms
```

## Related Docs
- [README.md](README.md)
- [MASTER_INDEX.md](MASTER_INDEX.md)

