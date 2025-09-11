# Consent Management (CRM)

## Overview
- TBD

## Prerequisites
- TBD

## Setup
- TBD

## Usage
- TBD

## References
- TBD


## Overview
Manages GDPR consent for customer data.

## Features
- Opt-in/opt-out tracking
- Consent history log
- API for managing preferences

## Use Cases
- Recording marketing opt-ins for newsletters.
- Providing regulators with consent history.
- Allowing users to change preferences in self-service portals.

## Setup Steps
1. Enable the consent service in the admin panel.
2. Define consent categories such as marketing or analytics.
3. Integrate the API with signup and profile forms.

## Example Configuration
```bash
# Create a new consent record via API
curl -X POST https://api.cafeos.example/consents \
  -H "Authorization: Bearer <TOKEN>" \
  -d '{"user_id":123,"category":"marketing","status":"opt_in"}'
```

## Scenario
When a new user registers, the signup form calls the consent API to store their choice.
If the user later updates their preferences, the system logs the change and sends a notification to compliance teams.

## See Also
- [Data Privacy](DATA_PRIVACY.md)
