# Contributing

- Run `composer test` before submitting PRs.
- Use conventional commits (`feat:`, `fix:`) for semantic release.
- Ensure PHP 8.3+ and disable OpenTelemetry during local testing with `OTEL_TRACES_EXPORTER=null` and `OTEL_TRACES_SAMPLER_TYPE=always_off`.
