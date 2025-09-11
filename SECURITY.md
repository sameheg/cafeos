# Security & Compliance

## Overview
- This section outlines the primary goals and scope of Security.

## Prerequisites
- Familiarity with basic Security concepts and system requirements is recommended.

## Setup
- Follow these steps to configure and enable Security in your environment.

## Usage
- Instructions and examples for applying Security in day-to-day operations.

## References
- Additional resources and documentation about Security for further learning.


## Authentication
- Laravel Sanctum/JWT.  
- OAuth2 for external apps.  

## Authorization
- RBAC with Spatie permissions.  
- ABAC for advanced rules.  

## Data Protection
Sensitive data is classified and protected with layered controls.

### Sensitive Data
- **Personal identifiable information (PII)**: names, emails, addresses → encrypted with AES‑256 at rest, transmitted over TLS‎ 1.2+ and access logged.
- **Payment card data**: PAN, CVV → tokenized, stored only in PCI‑DSS compliant vaults, and never written to logs.
- **Authentication secrets**: passwords, API keys, session tokens → hashed with bcrypt/argon2 and rotated via a secrets manager.
- **Health information**: allergies, medical notes → restricted to authorized roles with audit trails and AES‑256 encryption.

### Encryption & Key Management
- TLS 1.2+ enforced for all external traffic.
- AES-256 used for databases, backups, and sensitive files.
- Keys stored in an HSM/KMS with access limited to dedicated roles.
- Keys rotated at least every 90 days and retired immediately on compromise.

## Compliance
### GDPR
- Maintain consent logs and honor data access/erasure requests within 30 days.
- Example: use the data export API to provide a user's full record and confirm deletion once completed.

### PCI DSS
- Segment the cardholder data environment and perform quarterly vulnerability scans.
- Example: process cards through a tokenization service so raw numbers never touch application logs.

### Other Frameworks
- HIPAA for health-related use cases.

## Tenant Isolation
- Middleware to enforce per-tenant DB/schema.

## Related Docs
- [README.md](README.md)
- [MASTER_INDEX.md](MASTER_INDEX.md)

