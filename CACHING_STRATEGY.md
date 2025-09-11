# Caching Strategy

## Overview
Caching improves performance and reduces DB load.

## Layers
- Redis: session, queue, cache store
- Query caching
- HTTP caching for APIs

## Invalidation
- On update/delete events via EventBus
