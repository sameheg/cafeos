# Jobs Module

Manages job postings and applicant pipelines for EliteSaaS.

## API
- `POST /api/v1/jobs/applications` – submit application with CV.
- `GET /api/v1/jobs/postings` – list open job postings.

## State Machine
```mermaid
stateDiagram-v2
    [*] --> Posted
    Posted --> Applied: apply()
    Applied --> Screened: screen()
    Screened --> Hired: hire()
    Applied --> Rejected: reject()
```

## Domain Event
```php
ApplicationReceived::dispatch($application); // emits jobs.application.received@v1
```
