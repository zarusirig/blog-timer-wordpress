# Internal Linking SEO Audit + Full Plan

Date: 2026-02-11
Audited environment: `http://localhost:8085` (this repo's Docker WordPress)

## Scope and Method
- Crawled all indexable URLs from `wp-sitemap.xml` plus homepage.
- Extracted internal links from rendered HTML.
- Computed:
  - crawl reachability from homepage,
  - internal inlinks/outlinks,
  - contextual inlinks (excluding sitewide links that appear on >=80% pages),
  - orphan URL detection.

## URL Inventory (Indexable)
- Total indexable URLs: `271`
- Core pages: `10`
- Timer pages (`/timer/...`): `221`
- Guide pages (`/guides/...`): `20`
- Timer unit taxonomies: `2`
- Timer bucket taxonomies: `7`
- Timer use-case taxonomies: `5`
- Guide cluster taxonomies: `6`

## Critical Findings

### 1) 23 URLs are not reachable from homepage crawl path
These are not discoverable by following internal links from `/`.

Unreachable taxonomies (20):
- `/timer-unit/minutes/`
- `/timer-unit/seconds/`
- `/timer-bucket/short/`
- `/timer-bucket/medium/`
- `/timer-bucket/long/`
- `/timer-bucket/extended/`
- `/timer-bucket/seconds_short/`
- `/timer-bucket/seconds_medium/`
- `/timer-bucket/seconds_long/`
- `/timer-usecase/productivity/`
- `/timer-usecase/cooking/`
- `/timer-usecase/exercise/`
- `/timer-usecase/meditation/`
- `/timer-usecase/studying/`
- `/guide-cluster/accuracy/`
- `/guide-cluster/cooking/`
- `/guide-cluster/exercise/`
- `/guide-cluster/meditation/`
- `/guide-cluster/pomodoro/`
- `/guide-cluster/studying/`

Unreachable guides (3):
- `/guides/break-timers/`
- `/guides/cooking-timers-common/`
- `/guides/tea-coffee-timers/`

Root cause: guide cluster archive pages are orphaned, and these guides depend on those cluster archives for discovery.

### 2) 20 orphan indexable pages (zero inlinks)
All 20 orphan pages are taxonomy archives (same list above minus the 3 guide URLs).

### 3) Internal graph is dominated by sitewide links
15 targets receive sitewide links from >=80% of pages, including:
- `/`, `/minute-timers/`, `/second-timers/`, `/pomodoro/`, `/use-cases/`, `/faq/`, `/about/`, `/contact/`, `/privacy-policy/`, `/terms-of-service/`
- `/timer/set-timer-for-5-minutes/`, `/timer/set-timer-for-10-minutes/`, `/timer/set-timer-for-15-minutes/`, `/timer/set-timer-for-25-minutes/`
- `/guides/timer-accuracy/`

Effect: crawl equity and anchor relevance are concentrated in a small fixed set of URLs.

### 4) Contextual linking depth is weak for many URLs
- Timer pages with <=2 contextual inlinks: `58/221`
- Guide pages with <=2 contextual inlinks: `7/20`
- Taxonomy pages with 0 contextual inlinks: `20/20`

### 5) Core informational pages rely mostly on nav/footer links
`/about/`, `/contact/`, `/faq/`, `/privacy-policy/`, `/terms-of-service/` have near-zero contextual outlinking to topical hubs/taxonomies.

## Code Evidence (Current State)
- Header nav links only to broad hubs: `wp-content/themes/my-custom-theme/header.php:26`
- No taxonomy discoverability links in header/footer:
  - `wp-content/themes/my-custom-theme/header.php:26`
  - `wp-content/themes/my-custom-theme/footer.php:62`
- Homepage use-case cards anchor only to section fragments (not taxonomy archives):
  - `wp-content/themes/my-custom-theme/front-page.php:256`
- Guide archive does not expose cluster archive links:
  - `wp-content/themes/my-custom-theme/archive-guide.php:24`
- Taxonomy pages exist and are indexable but receive no internal links:
  - `wp-content/themes/my-custom-theme/taxonomy-timer_unit.php:1`
  - `wp-content/themes/my-custom-theme/taxonomy-timer_bucket.php:1`
  - `wp-content/themes/my-custom-theme/taxonomy-timer_usecase.php:1`
  - `wp-content/themes/my-custom-theme/taxonomy-guide_cluster.php:1`
- Single timer has related timer/guide links but no explicit links to its own taxonomy archives:
  - `wp-content/themes/my-custom-theme/single-timer.php:107`

## Google-Aligned Requirements (Applied)
Use these as constraints for the linking rebuild:
- Use descriptive link text and avoid generic anchors.
- Ensure important pages have clear internal links from other pages.
- Keep important pages easy to find from navigation and contextual links.

References:
- [Google SEO Starter Guide](https://developers.google.com/search/docs/fundamentals/seo-starter-guide)
- [How to write links](https://developers.google.com/search/docs/crawling-indexing/links-crawlable)
- [Site hierarchy guidance](https://developers.google.com/search/docs/crawling-indexing/site-structure)

## Full Internal Linking Plan

## 1) Target Architecture
- Tier 0: Homepage
- Tier 1: Core hubs (`/minute-timers/`, `/second-timers/`, `/pomodoro/`, `/use-cases/`, `/guides/`)
- Tier 2: Taxonomy archives (`timer_unit`, `timer_bucket`, `timer_usecase`, `guide_cluster`)
- Tier 3: Singles (`/timer/*`, `/guides/*`)

Hard rule: every Tier 2 and Tier 3 URL must have >=3 contextual inlinks.

## 2) Required Link Blocks by Page Type

### Homepage (`/`)
Add a new "Explore by Category" section linking to all 20 taxonomy archives:
- 2 unit terms
- 7 bucket terms
- 5 use-case terms
- 6 guide clusters

Result: all taxonomy pages become reachable in one click.

### Header Navigation
Add dropdowns:
- Timers: Unit + Bucket archive links
- Use Cases: direct links to `/timer-usecase/{slug}/`
- Guides: links to `/guide-cluster/{slug}/`

Keep existing top-level links; add 1 click path to all taxonomy archives.

### Guide Archive (`/guides/`)
Add "Browse by Topic" block linking all guide clusters.

### Minute Hub (`/minute-timers/`)
For each bucket section heading, add "View all in {Bucket}" link to corresponding taxonomy URL.
Add direct link to `/timer-unit/minutes/`.

### Second Hub (`/second-timers/`)
Add links to:
- `/timer-unit/seconds/`
- `/timer-bucket/seconds_short/`
- `/timer-bucket/seconds_medium/`
- `/timer-bucket/seconds_long/`

### Use Cases Hub (`/use-cases/`)
Convert or duplicate each card CTA to taxonomy pages:
- `/timer-usecase/productivity/`
- `/timer-usecase/cooking/`
- `/timer-usecase/exercise/`
- `/timer-usecase/meditation/`
- `/timer-usecase/studying/`

### Single Timer (`/timer/*`)
Add a "Related Categories" block containing:
- current unit taxonomy link,
- current bucket taxonomy link,
- all assigned `timer_usecase` links.

### Single Guide (`/guides/*`)
Add explicit link to primary `guide_cluster` term archive.
Add one secondary cluster link where relevant.

### Taxonomy Templates
On each taxonomy page, add sibling taxonomy links:
- `timer_unit`: link all bucket pages for the same unit + all use-case pages.
- `timer_bucket`: link sibling bucket pages and related use-case pages.
- `timer_usecase`: link sibling use-cases + key unit/bucket pages.
- `guide_cluster`: link sibling clusters and key hub pages.

### Informational Pages (`about`, `contact`, `faq`, `privacy`, `terms`)
Add 2-4 contextual links each to hubs and one relevant guide/taxonomy page.

## 3) Anchor Text Strategy
- Use explicit intent + entity:
  - "25 minute Pomodoro timer"
  - "short focus timer range"
  - "productivity timer use-case"
  - "Pomodoro guides"
- Keep anchors concise (2-6 words typical).
- Avoid over-repeating exact anchors for the same URL sitewide.

## 4) Internal Link Budget Rules
Per template (minimums):
- Homepage: 25+ contextual links (including all taxonomy archives)
- Hub pages: 30+ contextual links
- Taxonomy archives: 12+ contextual links
- Single timer: 8+ contextual links
- Single guide: 8+ contextual links
- Info pages: 3+ contextual links

## 5) Implementation Order (High to Low Impact)
1. Homepage taxonomy block
2. Header nav taxonomy dropdowns
3. Guide archive cluster block
4. Hub page taxonomy deep-links
5. Single timer/guide taxonomy blocks
6. Taxonomy sibling cross-link modules
7. Info page contextual links

## 6) Acceptance Criteria (Must Pass)
- Reachability from homepage:
  - `0` unreachable indexable URLs
- Orphans:
  - `0` orphan indexable URLs
- Contextual inlink thresholds:
  - Taxonomy URLs: min `3`
  - Guide URLs: min `3`
  - Timer URLs: min `3` (target `>=5`)
- No broken internal links / no 404s
- Anchor text remains descriptive and non-spammy

## 7) Post-Implementation Validation Checklist
- Recrawl all sitemap URLs and recompute graph metrics.
- Confirm all 20 taxonomy archives have >=3 contextual inlinks.
- Confirm previously unreachable guides are reachable from `/` within <=3 clicks.
- Recheck top targets so link equity is less concentrated in only sitewide footer/header links.

