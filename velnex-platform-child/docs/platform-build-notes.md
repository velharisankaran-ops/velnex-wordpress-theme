# Velnex Platform Build Notes

This file records platform decisions, database structure, and implementation notes as the build moves forward.

## Restart Context If Chat Is Lost

Workspace root:

`C:\Users\kannan\Velhari Sankaran\3. Velnex\07_MARKETING\02. Webite`

Main public website theme working folder:

`C:\Users\kannan\Velhari Sankaran\3. Velnex\07_MARKETING\02. Webite\velnex-block-theme-folder\velnex-block-theme`

Main public website GitHub repo:

`https://github.com/velharisankaran-ops/velnex-wordpress-theme.git`

Platform child theme source folder:

`C:\Users\kannan\Velhari Sankaran\3. Velnex\07_MARKETING\02. Webite\velnex-platform-child`

Platform child theme copy inside the main website repo:

`C:\Users\kannan\Velhari Sankaran\3. Velnex\07_MARKETING\02. Webite\velnex-block-theme-folder\velnex-block-theme\velnex-platform-child`

Current rule:

- Public website is frozen unless the user explicitly asks to change it.
- Platform work should happen in `velnex-platform-child`.
- The clean platform child theme has also been copied into the `velnex-wordpress-theme` repo under `velnex-platform-child/`.
- When pushing platform source to the same repo as the website, stage only `velnex-platform-child/`.
- Do not stage old trial files from the parent theme unless the user explicitly asks.

Important WordPress deployment rule:

- WordPress child themes must be placed as a sibling of the parent theme.
- Correct Hostinger path:
  `/public_html/wp-content/themes/velnex-platform-child`
- Parent theme path:
  `/public_html/wp-content/themes/velnex-block-theme`
- If Hostinger Git deploy copies `velnex-platform-child` inside `velnex-block-theme`, WordPress will not detect it as a separate theme.
- In that case, copy/upload the `velnex-platform-child` folder manually into `/wp-content/themes/`.

Current pushed commits:

- Public website/home theme repo: `velharisankaran-ops/velnex-wordpress-theme`
- Latest platform child theme source commit in that repo: `80cbf92` (`Add platform child theme source`)
- Platform child was also pushed earlier to `velharisankaran-ops/velnex-website`, but the preferred repo for website + child theme source is now `velnex-wordpress-theme`.

Current local preview files:

- Platform login preview:
  `C:\Users\kannan\Velhari Sankaran\3. Velnex\07_MARKETING\02. Webite\velnex-platform-child\local-platform.html`
- Request access preview:
  `C:\Users\kannan\Velhari Sankaran\3. Velnex\07_MARKETING\02. Webite\velnex-platform-child\local-request-access.html`
- Business signup preview:
  `C:\Users\kannan\Velhari Sankaran\3. Velnex\07_MARKETING\02. Webite\velnex-platform-child\local-business-signup.html`
- Investor signup preview:
  `C:\Users\kannan\Velhari Sankaran\3. Velnex\07_MARKETING\02. Webite\velnex-platform-child\local-investor-signup.html`
- Vendor signup preview:
  `C:\Users\kannan\Velhari Sankaran\3. Velnex\07_MARKETING\02. Webite\velnex-platform-child\local-vendor-signup.html`

Current WordPress slugs:

- `/platform-login/`
- `/request-access/`
- `/business-signup/`
- `/investor-signup/`
- `/vendor-signup/`
- `/pending-approval/`
- `/approved-flow/`

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

## Internal Foundation Dashboard Direction

Source document:

`docs/foundation-stage-internal-management.md`

This document records the foundation-stage internal management structure for Velnex. It should be used when planning the internal dashboard and backend data model.

The internal dashboard is not public marketing content. It is for tracking:

- company registration and compliance records
- current foundation-stage team and roles
- investor preparation and discussion notes
- business case studies
- case study templates
- partner and vendor network
- expenses
- weekly progress
- documents

Important wording rule:

- Merin Johny, Jeevan Joseph, and Nijo Jomon should be described as foundation-stage support/team members unless formal legal roles are created later.
- Do not present informal contributors as legally registered employees or partners.

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
