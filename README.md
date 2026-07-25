# Ripper Sports WordPress Theme

A WordPress theme converted from the static Ripper Sports site. It keeps the green/gold Australian sports-media design, live-score ticker, mega-menu sports navigation, card layouts, and accessibility features while making everything dynamic through WordPress.

## Installation

1. Copy this folder to `wp-content/themes/ripper-sports-wp-theme/` in your Local WordPress site.
2. Log in to WordPress admin.
3. Go to **Appearance → Themes** and activate **Ripper Sports**.

## Recommended setup

1. **Settings → Reading**
   - Set "Your homepage displays" to **Your latest posts** if you want the front-page template to render, or create a page named "Home" and set it as a static homepage (the theme will still use `front-page.php`).
2. **Settings → General**
   - Set **Site Title** to `Ripper Sports`.
   - Set **Tagline** to `Australia's premier destination for bold sports journalism, real-time data, and unmissable highlights.`.
3. Create these pages:
   - **About** — use the default page template.
   - **Contact** — use the **Contact** page template.
   - **Sports** — use the **Sports Directory** page template.
   - **Privacy Policy** — use the default page template.
   - **Terms of Service** — use the default page template.
4. Go to **Appearance → Menus** and create:
   - A **Primary** menu with Home, News, Sports, Blog, Contact.
   - A **Footer** menu with quick links.
5. Go to **Posts → Categories** or **Posts → Sports** and add sports terms: AFL, NRL, Cricket, Soccer, Basketball, Rugby, Tennis, Motorsport, Golf, Boxing / MMA.
6. Add posts and assign them a **Sport** so the homepage and archive pages populate automatically.

## Features

- Responsive dark theme with green/gold brand colours.
- Live score ticker (decorative/JS-only; wire to a real API when ready).
- Hero section + category sections on the homepage.
- Sports taxonomy archive pages.
- AJAX newsletter and contact forms.
- Cookie consent banner.
- Accessible skip link, focus rings, ARIA labels, keyboard Escape handling.

## File map

- `style.css` — WordPress theme header.
- `functions.php` — Theme setup, menus, widgets, image sizes, enqueues, AJAX handlers, sports taxonomy.
- `header.php` / `footer.php` — Site shell.
- `front-page.php` — Homepage with live ticker, hero, and category sections.
- `index.php` / `archive.php` / `search.php` — Blog, archive, and search loops.
- `single.php` / `page.php` — Single post and generic page.
- `page-contact.php` — Contact page template.
- `page-sports.php` — Sports directory page template.
- `404.php` — 404 page.
- `template-parts/` — Reusable card, single, page, and none components.
- `assets/css/style.css` + `utilities.css` — Theme styles.
- `assets/js/main.js` — Theme JavaScript.
- `assets/images/logo.svg` — Site logo.

## Notes

- The previous `sinaquant-wp-theme` has been backed up to `sinaquant-wp-theme-backup-20260725`.
- The documents folder zips (`Sinaquant Theme.ezyZip.zip`, etc.) contain an older version of the Sinaquant theme and were left untouched.
