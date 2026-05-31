# Velnex Platform Build Notes

This file records platform decisions, database structure, and implementation notes as the build moves forward.

## Current Architecture Decision

- Public website stays in the main theme: `velnex-block-theme`.
- Platform UI stays in the child theme: `velnex-platform-child`.
- Database, roles, login, verification, approvals, and data saving should be handled later by a plugin: `velnex-platform-plugin`.
- The child theme should only control UI screens and frontend presentation.

## Platform Route Flow

Current frontend flow:

1. `/platform-login/`
2. `/request-access/`
3. `/business-signup/`
4. `/investor-signup/`
5. `/vendor-signup/`
6. `/pending-approval/`
7. `/approved-flow/`

## No-Cost MVP Verification Decision

For the first real backend version:

- Use email verification through WordPress email.
- Store phone number but do not automate phone OTP yet.
- Phone verification can be manual until a paid SMS/WhatsApp gateway is added.
- Users should not get dashboard access until approved by Velnex.

## First Database Table

First required table:

`velnex_access_requests`

Purpose:

- Store first identity/contact request.
- Track email verification.
- Track party type: business, investor, vendor.
- Track request status.
- Allow users to continue the request process later.

SQL:

```sql
CREATE TABLE velnex_access_requests (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  request_uid VARCHAR(64) NOT NULL,
  email VARCHAR(190) NOT NULL,
  phone VARCHAR(40) DEFAULT NULL,
  party_type ENUM('business','investor','vendor') DEFAULT NULL,
  status ENUM(
    'draft',
    'email_pending',
    'email_verified',
    'form_submitted',
    'under_review',
    'more_info_needed',
    'approved',
    'rejected'
  ) NOT NULL DEFAULT 'draft',
  email_verified_at DATETIME DEFAULT NULL,
  verification_token_hash VARCHAR(255) DEFAULT NULL,
  verification_expires_at DATETIME DEFAULT NULL,
  last_login_at DATETIME DEFAULT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY request_uid_unique (request_uid),
  KEY email_index (email),
  KEY status_index (status),
  KEY party_type_index (party_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## Next Database Tables

After `velnex_access_requests`, create:

- `velnex_business_profiles`
- `velnex_investor_profiles`
- `velnex_vendor_profiles`
- `velnex_request_status_logs`

## Important Rule

Do not put serious database logic inside the theme.

Use:

- Theme / child theme: UI only.
- Plugin: database, validation, login/session logic, approval workflow, admin tools.

