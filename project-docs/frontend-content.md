Below are **frontend design + content template rules** you can hand to dev/design and start building immediately. It’s optimized for: **pSEO scale, Koray SCN, fast UX, multilingual**, and WordPress templating.

---

# A) Frontend Design System (UI/UX Spec)

## A1) Brand + Visual System

**Goal:** utility-first, “timer-app” feel, zero clutter, fast scanning.

### Colors (tokens, not hard-coded)

* `--bg`: page background
* `--surface`: card background
* `--text`: primary text
* `--muted`: secondary text
* `--border`: subtle borders
* `--primary`: CTA (Start)
* `--danger`: Reset
* `--success`: completion state
* `--focus`: outline

> Use CSS variables so multilingual and theming changes don’t require refactors.

### Typography

* **H1**: 32–40px (mobile 28–32)
* **Timer digits**: 64–96px (responsive)
* **Body**: 16–18px
* **Small**: 13–14px

### Spacing

* 8px base scale
* Card padding 16–24px
* Section spacing 32–48px

### Layout

* Max width: **1100–1200px**
* Single-column on mobile; 2-column at ≥ 992px for hub pages

---

## A2) Global Header / Nav

**Header height:** 56–64px
**Must include:**

* Logo/brand (links Home)
* Primary nav:

  * Home
  * Minute Timers (hub)
  * Second Timers (hub)
  * Pomodoro
  * Info dropdown (About, FAQ, Contact)
* Language switcher (top right)

**Behavior**

* Sticky header
* Mobile hamburger menu
* Active state highlight on current hub/section

---

## A3) Global Footer

* Important Links: About, Contact, FAQ, Privacy, Terms, Sitemap
* Language links
* Copyright

**Do not** stuff with keyword links (no link farm). Keep legal + essential navigation.

---

# B) Page-by-Page Frontend Design Specs

## B1) Home Page Template (/)

### Sections (in this exact order)

1. **Hero**

   * H1: “Online Timer for Any Duration”
   * Subtext: “Set precise timers for work, cooking, exercise, and more.”
   * Primary CTA: “Start 5-minute timer”
   * Secondary: “Browse all timers”

2. **Timer Widget (embedded, default 5:00)**

   * Same component as timer pages

3. **Popular Timers**

   * Tabs: Popular / Short / Medium / Long / Extended / Seconds
   * Grid links (cards)

4. **Timer Use Cases**

   * Cards: Productivity, Cooking, Exercise, Meditation
   * Each card shows 3–6 recommended timers (links)

5. **Key Features**

   * Precision Timing
   * Audio Alerts
   * Fully Customizable
   * Multi-language Support

6. **How to Use**

   * 3-step (Choose duration → Start → Get notified)

7. **FAQ (3–5 Qs)**

**UI rules**

* Each section uses consistent “surface card” styling
* Avoid heavy imagery; optionally use subtle icons

---

## B2) Timer Page Template (Core pSEO)

URL example: `/timer/set-timer-for-25-minutes`

### Above-the-fold (must be visible without scroll on desktop)

1. Breadcrumbs: Home → Minute Timers → 25 Minutes
2. H1: “Set Timer for 25 Minutes”
3. Timer Widget (large digits)
4. Primary controls row: Start/Pause, Reset
5. Secondary controls:

   * Timer name input
   * Custom time input (1–100)
   * Unit toggle (Minutes/Seconds)
   * Sound toggle + volume (optional)
   * Fullscreen (optional)

### Below-the-fold sections (in order)

6. **Quick Use Ideas** (short bullets; semi-unique based on useCase)

   * e.g., “Pomodoro focus session”, “Workout interval”, “Tea steeping”

7. **Related Timers** (8–12 links)

   * “Nearby durations” + “popular in this category”
   * This is your SCN reinforcement

8. **Browse All Timers CTA**

   * Link to minutes hub or seconds hub

9. **How to Use Our Timer** (3 steps, consistent)

10. **FAQ (2–4 Qs, rotated set)**

11. **Short Timers / Medium / Long** (optional mini module)

* Show 4 links per bucket for discovery

**Critical UX rules**

* Start button must be the most prominent
* When running, page shows:

  * progress ring or bar (optional)
  * remaining time in title (optional; can help engagement)
* On completion:

  * visual completion state (banner)
  * replay sound button

---

## B3) Hub Pages (Minute Timers / Second Timers)

Example: `/minute-timers/`

### Layout

* Two-column on desktop:

  * Left: filters / buckets / use cases
  * Right: timer grid

### Sections

1. H1 + intro paragraph
2. Popular timers grid (8–12)
3. Bucket navigation (Short/Medium/Long/Extended)
4. Search by value (input + quick jump)
5. Full list grid (paginated)

**Rules**

* Filters must NOT create indexable URLs (no index bloat)

  * Use JS filtering or query vars that are `noindex,follow`

---

## B4) Pomodoro Page (/pomodoro/)

### Above fold

* H1: “Pomodoro Timer”
* Presets: 25/5, 50/10, Custom cycles
* Start/Pause/Reset
* Sessions counter (optional)

### Below fold

* Links to relevant timer pages (25,5,15,50)
* “How Pomodoro works” summary
* FAQ (Pomodoro-specific)

---

## B5) Use Case Pages (/use-cases/{id}/)

**Curated (do not generate thousands).**

Sections:

* H1: “Timers for Studying”
* A short guide paragraph (unique)
* Recommended timers grid (8–16)
* Link back to hubs
* Link to 1–2 guides

---

# C) Core Components Spec (Reusable UI)

## C1) Timer Widget Component

**Props:**

* `defaultValue` (seconds)
* `allowCustomInput` (bool)
* `showName` (bool)
* `showUnitToggle` (bool)
* `soundEnabled` (bool)
* `persistState` (bool)

**State rules**

* Store:

  * `endTimestamp`
  * `durationSeconds`
  * `isRunning`
  * `timerName`
  * `soundEnabled`
* If `endTimestamp` exists and > now → resume

**Edge cases**

* Tab sleep: use timestamp diff, not tick count
* Audio restrictions: require user gesture first

---

## C2) Timer Link Card (for grids)

* Title: “5 minutes”
* Subtitle: “Quick break timer” (optional)
* Clickable area large, mobile-friendly

---

## C3) Related Timers Module

* Two rows:

  * “Nearby” (X-1, X+1, X+5)
  * “Popular” (global popular set)
* Cap at 8–12 links total

---

## C4) FAQ Accordion

* Expand/collapse
* Add FAQ schema (where applicable)

---

# D) Content Template Rules (for pSEO + Koray)

## D1) Page Types and Required Content Blocks

### Timer Page (mandatory blocks)

1. H1 (unique with value)
2. Intro (2–3 sentences, variant rotation)
3. Tool UI (timer)
4. Quick use ideas (bullets; semi-unique)
5. Related timers module
6. Hub CTA (“Browse all minute timers”)
7. How-to steps
8. FAQs (2–4)
9. Schema output

If any of these are missing → page fails QA.

---

## D2) Title + Meta Rules (strict)

### Title templates

* Minutes: `Set Timer for {value} Minutes – {brand}`
* Seconds: `Set Timer for {value} Seconds – {brand}`

### Meta description templates (rotate 3 variants)

Variant A:

* “Start a {value}-minute countdown timer with sound alerts. Free, accurate, and works on any device.”

Variant B:

* “Use this {value}-minute timer for focus, breaks, cooking, or workouts. Simple controls and clear alerts.”

Variant C:

* “Set a {value}-minute timer instantly. Custom name, presets, and reliable countdown on desktop or mobile.”

**Rule:** do not reuse the same meta description across all pages.

---

## D3) Intro Uniqueness Rules (anti-thin)

Each timer page must produce a **unique-ish** intro by combining:

* bucket-specific sentence + use-case snippet + feature snippet

Example assembly:

* Sentence 1 (bucket intro):
  “This {value}-minute timer is ideal for short focused tasks and quick breaks.”
* Sentence 2 (use-case pick, 1 of 3):
  “Many people use it for Pomodoro breaks, stretching, or steeping tea.”
* Sentence 3 (feature):
  “Press Start and you’ll get a clear sound alert when time’s up.”

**Rotation logic**

* Use 2–4 intro templates per bucket and rotate by value
* Ensure adjacent values don’t share identical intros

---

## D4) Quick Use Ideas Rules

Pick 4–6 bullets from a curated library based on unit/bucket/useCases.

Examples (minutes)

* “Pomodoro focus sprint”
* “Short break”
* “Stretching”
* “French press brew”
* “HIIT rest”
* “Meditation check-in”

Seconds

* “Plank interval”
* “Breathing cadence”
* “Reaction drill”
* “Rest timer between reps”

**Rule:** At least 2 bullets must differ between neighboring timer pages.

---

## D5) FAQ Rules

Timer pages: 2–4 FAQs from a rotating pool.

* Must answer *tool intent* not general fluff:

  * accuracy
  * mobile behavior
  * sound
  * offline after load
  * background limitations (be honest)

Hub pages: 3–6 FAQs
Pomodoro: 4–8 FAQs

**Schema rule**

* Only output FAQ schema if the visible FAQ exists on that page.

---

## D6) Internal Linking Rules inside content (enforced)

Timer page must include:

* 1 link to its hub in intro/CTA
* Related timers module (8–12)
* 1–2 use-case links max
* 0–2 guide links max

**No** keyword-stuffed paragraphs solely for links.

---

# E) Template Implementation Rules (WordPress Dev)

## E1) Single Timer Template (`single-timer.php`)

Must render blocks in this order:

1. breadcrumbs
2. H1
3. intro
4. timer widget
5. quick use ideas
6. related timers
7. hub CTA
8. how-to
9. faq
10. schema

## E2) Archive Templates

* `archive-timer.php` for `/timer/` (optional)
* Custom pages for `/minute-timers/` and `/second-timers/` as hubs (recommended as Pages with custom query blocks)

## E3) Translation strings

All UI labels must be string keys (WPML/Polylang/TranslatePress compatible):

* Start, Pause, Reset, etc.
* Section headings: “Key Features”, “Related Timers”, “How to Use”

---

# F) QA Rules (Fast Checklist for Your Boss)

A timer page is “approved” only if:

* ✅ Above fold: H1 + timer digits + Start + Reset visible
* ✅ Intro is not identical to 10 other pages
* ✅ Related module has 8–12 links
* ✅ Breadcrumb includes hub
* ✅ Hub CTA present
* ✅ FAQ visible + matches schema
* ✅ Total internal links between 8–15 (reasonable)
* ✅ Mobile: controls usable with thumb, no overflow

