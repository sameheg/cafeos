# KDS Android App

This module provides a minimal Android client for the CafeOS Kitchen Display System (KDS).
It fetches metrics and tickets from the backend and allows chefs to update ticket status in real time.

## Features
- Retrofit client for `/kds/metrics`, `/kds/tickets`, and `POST /kds/tickets/{id}/status`.
- Bearer-token validation ensuring the token role is either `CHEF` or `KITCHEN_MANAGER`.
- Jetpack Compose ticket board with buttons to move tickets through preparation and done states.

## Installation
1. Install [Android Studio](https://developer.android.com/studio) with Kotlin support.
2. Copy `kds-config.example.json` to `kds-config.json` and provide your API base URL and tokens.
3. Build and install:
   ```bash
   ./gradlew installDebug
   ```

## Configuration
`kds-config.json` holds the base URL and separate tokens for chefs and kitchen managers.
The token must include a `role` claim of `CHEF` or `KITCHEN_MANAGER`.

## Sample `kds-config.json`
See [kds-config.example.json](kds-config.example.json) for a template.
