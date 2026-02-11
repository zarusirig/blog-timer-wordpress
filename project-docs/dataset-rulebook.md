Got you. Here are the **full Dataset Spec** + **Internal Linking Rulebook** you can hand straight to dev/SEO without extra interpretation.

---

# 1) Full Dataset Spec (pSEO + Koray SCN)

## 1.1 Purpose

A single structured dataset drives:

* **Programmatic creation** of Timer pages (CPT posts)
* **Taxonomy assignment** (unit/bucket/use cases)
* **Template variables** (titles, intros, FAQs, schema)
* **Internal linking modules** (related timers, hub links, use-case links)
* **Multilingual strings mapping** (UI + page text)

---

## 1.2 Entities

### A) Timer Page Entity (core pSEO pages)

Represents one canonical URL like:

* `/timer/set-timer-for-5-minutes`
* `/timer/set-timer-for-10-seconds`

### B) Hub Entity (pillar pages)

Represents category pages like:

* `/minute-timers/`
* `/second-timers/`
* `/timers/short/`
* `/use-cases/productivity/`
* `/pomodoro/`

### C) Use Case Entity (outer/supporting, limited generation)

Curated pages only:

* `/use-cases/studying/`
* `/use-cases/cooking/`

### D) Copy Blocks (template library)

Reusable but **rotated** content:

* intro variants
* FAQ variants
* use-case snippets

---

## 1.3 Canonical URL & Slug Rules (non-negotiable)

To avoid duplicates/cannibalization:

### Timer URL format

`/timer/set-timer-for-{value}-{unit}`

**Unit is always plural**:

* minutes
* seconds

Examples:

* `/timer/set-timer-for-1-minutes` (allowed but ugly)
  Better: handle grammar in **title**, not slug. Keep slugs predictable:
* `/timer/set-timer-for-1-minutes`
* `/timer/set-timer-for-1-seconds`

If you *must* support singular in slug, enforce **one canonical** and 301 the other.

**Canonical rule (recommended)**: keep slugs always plural for simplicity + generator stability.

---

## 1.4 Buckets (taxonomy rules)

Used for navigation + related timers.

For **minutes**:

* `short`: 1–10
* `medium`: 11–30
* `long`: 31–60
* `extended`: 61–100 (or 61+)

For **seconds**:

* `seconds_short`: 1–10
* `seconds_medium`: 11–30
* `seconds_long`: 31–60
* `seconds_extended`: 61–300 (only if you ever expand)

> Keep buckets **mutually exclusive**. Every timer has exactly **one** bucket.

---

## 1.5 Required Dataset Outputs

You will maintain **one source dataset** (JSON/YAML/CSV) and generate:

* Timer CPT posts
* Taxonomy terms (unit, bucket, use_case)
* Hub pages list (Pages or CPT “hub”)
* Internal linking maps (computed)

---

## 1.6 Dataset Format Options

### Option 1 (Recommended): JSON (source of truth)

* Best for WP-CLI generator
* Supports multilingual and variants cleanly

### Option 2: CSV (for non-technical teams)

* Simple bulk edit
* Limited nested structures (FAQs etc.) unless split files

I’ll give you **JSON spec** + optional CSV mirror.

---

# 1.7 JSON Dataset Spec (Source of Truth)

## File: `datasets/timers.dataset.json`

### Top-level structure

```json
{
  "site": {
    "brand": "The Blog Timer",
    "defaultLanguage": "en",
    "languages": ["en", "es", "de", "fr"],
    "canonicalDomain": "https://theblogtimer.com"
  },
  "taxonomies": {
    "units": ["minutes", "seconds"],
    "buckets": {
      "minutes": [
        {"id": "short", "min": 1, "max": 10},
        {"id": "medium", "min": 11, "max": 30},
        {"id": "long", "min": 31, "max": 60},
        {"id": "extended", "min": 61, "max": 100}
      ],
      "seconds": [
        {"id": "seconds_short", "min": 1, "max": 10},
        {"id": "seconds_medium", "min": 11, "max": 30},
        {"id": "seconds_long", "min": 31, "max": 60}
      ]
    },
    "useCases": [
      {"id": "productivity", "enabled": true},
      {"id": "cooking", "enabled": true},
      {"id": "exercise", "enabled": true},
      {"id": "meditation", "enabled": true},
      {"id": "studying", "enabled": true}
    ]
  },
  "contentLibraries": {
    "introVariants": {
      "minutes": {
        "short": ["intro_m_short_01", "intro_m_short_02"],
        "medium": ["intro_m_med_01", "intro_m_med_02"],
        "long": ["intro_m_long_01"],
        "extended": ["intro_m_ext_01"]
      },
      "seconds": {
        "seconds_short": ["intro_s_short_01"],
        "seconds_medium": ["intro_s_med_01"],
        "seconds_long": ["intro_s_long_01"]
      }
    },
    "faqSets": {
      "timer_core": ["faq_timer_01", "faq_timer_02", "faq_timer_03"],
      "pomodoro": ["faq_pomo_01", "faq_pomo_02"]
    }
  },
  "hubs": [
    {
      "id": "hub_minutes",
      "type": "page",
      "slug": "/minute-timers/",
      "titleKey": "hub.minutes.title",
      "descriptionKey": "hub.minutes.desc",
      "unit": "minutes"
    },
    {
      "id": "hub_seconds",
      "type": "page",
      "slug": "/second-timers/",
      "titleKey": "hub.seconds.title",
      "descriptionKey": "hub.seconds.desc",
      "unit": "seconds"
    },
    {
      "id": "hub_pomodoro",
      "type": "page",
      "slug": "/pomodoro/",
      "titleKey": "hub.pomodoro.title",
      "descriptionKey": "hub.pomodoro.desc"
    },
    {
      "id": "hub_usecases",
      "type": "page",
      "slug": "/use-cases/",
      "titleKey": "hub.usecases.title",
      "descriptionKey": "hub.usecases.desc"
    }
  ],
  "timers": [
    {
      "id": "t_m_5",
      "unit": "minutes",
      "value": 5,
      "slug": "/timer/set-timer-for-5-minutes",
      "isPopular": true,
      "useCases": ["productivity", "cooking", "exercise"],
      "customMeta": {
        "schemaType": "WebApplication",
        "allowFullscreen": true
      }
    },
    {
      "id": "t_s_10",
      "unit": "seconds",
      "value": 10,
      "slug": "/timer/set-timer-for-10-seconds",
      "isPopular": true,
      "useCases": ["exercise", "meditation"]
    }
  ],
  "strings": {
    "en": {},
    "es": {},
    "de": {},
    "fr": {}
  }
}
```

---

## 1.8 Timer Object Spec (field-by-field)

### Required fields

* `id` (string): unique stable key, e.g. `t_m_25`
* `unit` (enum): `minutes` | `seconds`
* `value` (int): duration value
* `slug` (string): canonical path
* `isPopular` (bool)

### Optional fields

* `useCases` (string[]): list of use case ids (curated; do not explode into separate pages automatically)
* `customMeta` (object): flags for UI/schema/feature toggles
* `introVariantOverride` (string): force a specific intro key
* `faqSetOverride` (string): force a specific FAQ set

### Derived fields (generator computes)

* `bucket` (from taxonomy ranges)
* `title` (from title template + localization)
* `metaDescription` (from template + localization)
* `relatedTimers` (computed link set)
* `hub` (minutes or seconds hub)
* `breadcrumbs`

---

## 1.9 Strings & Localization Spec

### File: `datasets/strings.en.json` (and es/de/fr)

Flat key-value is easiest:

```json
{
  "ui.start": "Start",
  "ui.reset": "Reset",
  "ui.pause": "Pause",
  "ui.timer_name": "Set timer name",
  "ui.enter_value": "Enter time value (1-100)",
  "hub.minutes.title": "Minute Timers",
  "hub.minutes.desc": "Browse all minute-based countdown timers.",
  "timer.title.minutes": "Set Timer for {value} Minutes",
  "timer.title.seconds": "Set Timer for {value} Seconds",
  "timer.meta.minutes": "Start a {value}-minute countdown timer with sound alerts. Free, accurate, and works on any device.",
  "timer.meta.seconds": "Start a {value}-second countdown timer with sound alerts. Free, accurate, and works on any device."
}
```

**Rules**

* Titles use `{value}` placeholder
* Keep slug structure **unchanged** across languages (recommended for dev speed), but translate on-page UI + headings.
* If you later translate slugs, add `slugByLanguage` to each timer object (not MVP).

---

## 1.10 Content Libraries Spec (Intro + FAQ)

### File: `datasets/copyblocks.json`

```json
{
  "intros": {
    "intro_m_short_01": {
      "en": "Use this {value}-minute timer for quick focus bursts, short breaks, or simple tasks.",
      "es": "Usa este temporizador de {value} minutos para..."
    }
  },
  "faqs": {
    "faq_timer_01": {
      "en": {
        "q": "Is the timer accurate?",
        "a": "Yes—this timer counts down to the second and uses your device clock for stability."
      }
    }
  }
}
```

**Intro uniqueness guard**

* Each page selects intro variant by:

  1. `introVariantOverride` if set
  2. else by `(unit + bucket)` rotating through available variants

**FAQ selection**

* Each timer page shows **2–4 FAQs**
* Rotate to reduce boilerplate

---

## 1.11 Related Timers Computation Spec

This is crucial for SCN and crawl paths.

### Related logic (minutes)

For value `X` minutes, build related set in this order:

1. **Near neighbors**: `X-1`, `X+1` (if within available range)
2. **Same bucket populars**: choose 2–4 from popular list in that bucket
3. **Step links**: `X+5`, `X+10` (bounded)
4. **Global populars** (fallback): 5,10,15,25,30,45,60,90

Limit: **8–12 total**.

### Related logic (seconds)

For `X` seconds:

1. neighbors: `X-1`, `X+1` (if exists)
2. popular seconds: 1,5,10,30,60

Limit: **6–10 total**.

---

## 1.12 Optional CSV Mirror (if your boss likes spreadsheets)

### File: `datasets/timers.csv`

Columns:

* `id`
* `unit`
* `value`
* `slug`
* `is_popular`
* `use_cases` (pipe-separated: `productivity|cooking`)
* `intro_override`
* `faq_override`

Example row:

* `t_m_25,minutes,25,/timer/set-timer-for-25-minutes,true,productivity|studying,,`

---

# 2) Internal Linking Rulebook (Koray SCN + pSEO)

## 2.1 Linking goals

* Make core pages discoverable fast (**low cost of retrieval**)
* Build topical clusters (**entity completeness + relevance**)
* Avoid spammy cross-linking (**keep contextual + limited**)

---

## 2.2 Page Types

1. **Home**
2. **Hub Pages (pillars)**

   * Minute Timers hub
   * Second Timers hub
   * Use Cases hub
   * Buckets hubs (Short/Medium/Long/Extended)
3. **Timer Pages (core programmatic)**
4. **Pomodoro (core tool)**
5. **Guides (outer support)**
6. **Utility pages** (about/contact/privacy/terms/faq)

---

## 2.3 Global Linking Rules (apply everywhere)

### Rule G1: Contextual first

* Internal links should be inside meaningful modules or content blocks
* Avoid “footer link farms”

### Rule G2: Crawl depth targets

* Timer pages reachable in **≤ 2 clicks** from Home:

  * Home → Minutes hub → Timer
  * Home → Seconds hub → Timer
* Outer guides in **≤ 3–4 clicks**

### Rule G3: Bidirectional confirmation

* If page A links to page B as a “related” or “recommended” link,
  page B must link back to:

  * the same hub, and ideally
  * at least one relevant sibling in the cluster

### Rule G4: Link density caps

* Timer pages: **8–15 internal links** total (including nav/breadcrumb)
* Hubs: **25–60 internal links** (pagination allowed)
* Guides: **6–12 internal links**

### Rule G5: Anchor text policy

* Mix anchors:

  * exact-ish: “5 minute timer”
  * partial: “set a 5-minute countdown”
  * contextual: “short break timer”
* Never repeat the exact same anchor in every module

---

## 2.4 Mandatory Modules by Page Type

## A) Home Page Linking Modules

**Must include**

1. Primary nav links:

   * Minute Timers hub
   * Second Timers hub
   * Pomodoro
   * Use Cases
2. “Popular timers” block:

   * 5, 10, 15, 25, 30, 45, 60, 90 minutes
   * 10, 30, 60 seconds
3. “Browse by bucket” block:

   * Short / Medium / Long / Extended
4. “Use cases” block:

   * Productivity, Cooking, Exercise, Meditation

**Target**: 20–35 internal links on Home (not counting footer legal links).

---

## B) Hub Page Linking Modules (Minute Timers / Second Timers)

### Minute Timers Hub (`/minute-timers/`)

**Must include**

1. “Popular minutes” grid (8–12 links)
2. Bucket navigation (links to bucket hubs)
3. Search/filter (UX; not SEO indexable results)
4. Paginated list of minute timers (e.g., 1–60, 61–100)

**Internal link target**: 35–80 (pagination OK)

### Second Timers Hub (`/second-timers/`)

Same structure with seconds set.

---

## C) Bucket Hub Pages (Short/Medium/Long/Extended)

Example: `/minute-timers/short/`

**Must include**

1. Definition text (what “short timers” are good for)
2. List/grid of all timers in bucket (links)
3. Links back to main hub
4. Link to 1–2 relevant Guides (outer support)

---

## D) Timer Page Linking Modules (Core pSEO)

Each `/timer/set-timer-for-X-{unit}` page must contain:

1. **Breadcrumbs**

* Home → (Minutes hub OR Seconds hub) → Current timer

2. **Related timers (mandatory)**

* 8–12 related links computed (spec above)
* Must prioritize same-unit + close durations

3. **Popular timers mini-module**

* 4–8 links (global popular set)
* This creates consistent cross-cluster reinforcement

4. **Contextual use-case links**

* Link to 1–2 use-case pages only (curated):

  * e.g. “Timers for Studying”, “Timers for Cooking”

5. **Link back to hub**

* prominent CTA: “Browse all minute timers”

**Timer page internal link target**: 8–15 total
(Count includes breadcrumbs + related + use-case + hub)

---

## E) Pomodoro Page Linking Rules

Pomodoro is a pillar-like tool page.

**Must include**

1. Link to Minute Timers hub
2. Link to core timers commonly used in pomodoro:

   * 25 minutes
   * 5 minutes
   * 15 minutes
   * 50 minutes
3. Link to 1–2 Guides:

   * “How Pomodoro works”
   * “Best Pomodoro schedules”

**Target**: 12–25 internal links

---

## F) Guides (Outer Support) Linking Rules

Guides should behave like semantic bridges.

**Must include**

1. Link to the most relevant hub
2. Link to 3–8 relevant timer pages (not too many)
3. Link to 1–3 other guides in the same cluster

**Target**: 6–12 internal links

**No mass-generated guides.** Keep curated.

---

## 2.5 Orphan Prevention Rule (hard requirement)

A page is “orphan” if it has:

* 0 internal links pointing to it (excluding sitemap)

**Requirements**

* Every Timer page must be linked from:

  1. its unit hub
  2. at least 2 other timer pages (via related module)
* Every Guide must be linked from:

  1. a hub or use-case page
  2. at least 1 timer page

---

## 2.6 Canonical + Indexing Rules (to avoid pSEO traps)

* Core timer pages: **index**
* Hub pages: **index**
* Bucket hubs: **index**
* Search results/filter pages: **noindex, follow**
* Tag archives (if not used intentionally): **noindex** (or disable)

---

## 2.7 Link Automation Mapping (what code needs to do)

Your `timer-engine` plugin should auto-render modules:

### For Timer pages:

* compute bucket from dataset ranges
* fetch related timers from dataset (or via meta query)
* render:

  * breadcrumbs
  * related timers
  * popular timers
  * use-case links (from timer object’s `useCases`, max 2)

### For hubs:

* query timers by unit/bucket
* render popular set first
* paginate full list

---

## 2.8 Acceptance Checklist (what your boss will want)

* ✅ A single dataset generates all timer pages reliably (idempotent)
* ✅ Every timer page has:

  * breadcrumbs
  * related timers module
  * hub link
  * popular module
* ✅ Hubs list timers and link down
* ✅ No orphan pages
* ✅ No indexed internal search/filter pages
* ✅ Multilingual strings separated from content logic

---
