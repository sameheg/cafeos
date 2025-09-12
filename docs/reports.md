# Reports Module

This module provides report generation, scheduling and exports for EliteSaaS.

```mermaid
stateDiagram-v2
    [*] --> Generated
    Generated --> Exported: export()
    Generated --> Scheduled: schedule()
    Exported --> Delivered: email()
```

Example domain event:

```json
{"event":"reports.generated@v1","data":{"report_id":"2222","type":"sales"}}
```
