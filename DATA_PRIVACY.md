# Data Privacy

## Overview
- This section outlines the primary goals and scope of Data Privacy.

## Prerequisites
- Familiarity with basic Data Privacy concepts and system requirements is recommended.

## Setup
- Follow these steps to configure and enable Data Privacy in your environment.

## Usage
- Instructions and examples for applying Data Privacy in day-to-day operations.

## References
- Additional resources and documentation about Data Privacy for further learning.


## Overview
Ensures compliance with GDPR, HIPAA.

## Principles
- Data minimization
- Encryption at rest and in transit
- Right to be forgotten

## Sensitive Data
- **PII** (names, emails, addresses) → restrict access, mask in logs, encrypt with AES-256.
- **Payment data** (card numbers) → tokenization and storage in PCI-DSS compliant services only.
- **Auth tokens** (passwords, API keys) → hash with bcrypt/argon2 and rotate regularly.
- **Health data** (allergies, notes) → limit access by role and keep audit trails.

## Encryption & Key Management
- TLS 1.2+ for all network traffic.
- AES-256 for databases, backups, and exports.
- Keys managed in a centralized KMS/HSM with rotation every 90 days.
- Separate duties: key custodians cannot access encrypted data.

## Requests
- API for data deletion/export

## Compliance
- **GDPR**: honor data access and deletion within 30 days; e.g., use the export API to deliver a user's data upon request.
- **PCI DSS**: avoid storing raw card data; e.g., rely on a tokenization gateway so only tokens persist.

## See Also
- [Consent Management](CONSENT_MANAGEMENT.md)

## Related Docs
- [README.md](README.md)
- [MASTER_INDEX.md](MASTER_INDEX.md)

