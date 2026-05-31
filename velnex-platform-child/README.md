# Velnex Platform Child Theme

Child theme folder: `velnex-platform-child`

## Parent theme requirement
- Parent folder name must be: `velnex-block-theme`

## What this child theme provides
- Separate page templates for the platform access flow
- Separate template parts for each platform page
- Dedicated platform styles: `assets/platform.css`
- Dedicated platform JS: `assets/platform.js`
- Auto-creates these page slugs on activation:
  - `platform-login`
  - `request-access`
  - `business-signup`
  - `investor-signup`
  - `vendor-signup`
  - `pending-approval`
  - `approved-flow`
- Keeps platform UI separate from the public website theme

## Install
1. Upload folder `velnex-platform-child` to:
   - `/wp-content/themes/`
2. Ensure parent theme folder exists:
   - `/wp-content/themes/velnex-block-theme`
3. Activate **Velnex Platform Child** from WordPress -> Appearance -> Themes.
4. Open page URL:
   - `/platform-login/`

## Local preview
Open:
- `local-platform.html`
