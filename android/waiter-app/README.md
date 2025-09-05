# Waiter App Module

This Android module provides a simple waiter-facing application for CafeOS.

## Features

- Select tables and submit orders
- Fetch products via `GET /products`
- Submit orders via `POST /orders`
- Uses bearer tokens (`auth:api`) for authentication

## Build

1. Ensure Android SDK and Java 21 are installed.
2. From the repository root:

```bash
cd android/waiter-app
./gradlew assembleDebug
```

The resulting APK is located under `app/build/outputs/apk/`.
