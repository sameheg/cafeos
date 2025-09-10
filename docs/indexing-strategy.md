# Indexing Strategy

To ensure scalable multi-tenant performance, all new tables must include a composite index on `tenant_id`, `status`, and `created_at`.

## Guidelines

- **Columns**
  - `tenant_id` – foreign key to the owning tenant.
  - `status` – string or enum representing record state.
  - `created_at` – provided by `timestamps()`.
- **Index**
  - Define an index combining the three columns: `[$table->index(['tenant_id', 'status', 'created_at']);]`
  - Keeps lookups fast for per-tenant queries with status filters and chronological sorting.
- **Order of Columns**
  - Place `tenant_id` first to leverage partitioning by tenant.
  - `status` second to support workflows and dashboards.
  - `created_at` third to enable time-based queries.

Following this pattern improves query planner choices and keeps hot paths responsive as data grows.
