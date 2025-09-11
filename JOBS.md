# Jobs Module

## Overview
Manages recruitment processes, job postings, and candidate applications.

## Features
- Post new job listings.  
- Manage applications from candidates.  
- HR review and interview tracking.  
- Hire/reject workflows.  

## Workflow
```mermaid
flowchart TD
    Candidate -->|Applies| Jobs
    Jobs -->|Store Application| DB[(Applications DB)]
    HR -->|Reviews| Jobs
    HR -->|Shortlist/Reject| Candidate
    HR -->|Hire| Tenant
    Jobs --> Reports
```

## API
- `GET /api/jobs/posts` – List job posts.  
- `POST /api/jobs/posts` – Create job post.  
- `POST /api/jobs/applications` – Submit application.  

## Security
- Only tenant admins/HR staff can manage jobs.  
- Candidate data protected under GDPR.  

## Future Enhancements
- AI-driven CV screening.  
- Video interview integration.  
