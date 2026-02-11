According to a document from **(date not provided in the file metadata)**, Koray’s Framework targets **Topical Authority State** by increasing **Relevance + Responsiveness** and decreasing **Cost of Retrieval** through **query-network analysis** and a **Semantic Content Network (SCN)**. The same document also specifies an internal-linking architecture (hub-and-spoke, crawl depth, bidirectional linking, link density) and a QA checklist for validating the topical map and network. 

Below is an **in-depth PRD** for your WordPress timer website using **Koray’s framework + Programmatic SEO**, built and deployed via your **Docker → DigitalOcean one-command pipeline**.

---

# PRD: The Blog Timer (WordPress) — Koray Framework + Programmatic SEO

## 1) Product summary

### 1.1 Product concept

A fast, multilingual, SEO-driven timer web app on WordPress that programmatically generates “set timer for X minutes/seconds” pages and supports Pomodoro + browsing by categories/use-cases. The site is designed as a **Semantic Content Network** (SCN) to achieve topical authority in the “online timer” entity space.

### 1.2 Core principles (Koray alignment)

* **Increase Relevance**: comprehensive entity coverage and query-intent mapping. 
* **Increase Responsiveness**: consistent structured templates, micro-semantic consistency, internal linking architecture. 
* **Decrease Cost of Retrieval**: shallow crawl depth, hub pages, contextual links, predictable taxonomy. 

---

## 2) Goals & success metrics

### 2.1 Business goals

* Capture high-intent SEO traffic for “set timer for X minutes/seconds” queries (pSEO core).
* Expand to informational/supporting content to increase topical breadth and reinforce the core (Koray outer section).
* Achieve reliable, repeatable deployments with near-zero manual ops using your pipeline.

### 2.2 User goals

* Start a timer instantly with minimal friction.
* Easily find common durations and use cases (study, cooking, workout, meditation).
* Use across devices; timer remains usable after load.

### 2.3 Success metrics (KPIs)

**SEO**

* Indexation rate for core pSEO pages (coverage %).
* Growth in impressions/clicks per core cluster (minutes, seconds, pomodoro).
* Crawl depth compliance: core pages reachable within 2 clicks; outer within 3–4. 
* Cannibalization rate (duplicate intents) flagged and reduced (QA requirement). 

**Product**

* Timer start rate (sessions with start event / sessions).
* Completion rate (timer_end events / timer_start).
* Use of presets vs custom input.

**Performance**

* Page load (LCP), responsiveness (INP), layout stability (CLS).
* 0 critical errors in Playwright link checks (Phase 2.5 requirement in your workflow).

---

## 3) Scope

### 3.1 In-scope (MVP)

1. **Timer engine** (minutes + seconds) with:

   * Start/Reset
   * Name label (optional)
   * Preset durations
   * Custom input (1–100) minutes/seconds
   * End-of-timer alert sound
   * State persistence (localStorage)

2. **Programmatic SEO core pages**

   * `/timer/set-timer-for-{X}-minutes`
   * `/timer/set-timer-for-{X}-seconds`

3. **Taxonomy & hubs**

   * Minute timers hub page
   * Second timers hub page
   * Browse by buckets: short/medium/long/extended
   * Use-case sections (productivity, cooking, exercise, meditation)

4. **Pomodoro page**

   * `/pomodoro` with Pomodoro workflow and preset cycles.

5. **Multilingual**

   * Language directories (`/es/`, `/de/`, `/fr/`) via WPML/Polylang/TranslatePress.
   * Translated UI strings + core hubs.

6. **Deployment pipeline integration**

   * Works locally with Docker Compose
   * Deploys to DO droplet and migrates DB/wp-content with one command.

### 3.2 Out-of-scope (initially)

* Accounts/login
* Community features (comments, saved timers cloud sync)
* A/B testing platform
* AI content generation at scale without editorial guardrails

---

## 4) Users & personas

1. **Casual user**

   * Wants quick preset (5/10/15/25/30 mins).
2. **Student / deep work**

   * Uses Pomodoro, repeats daily.
3. **Cook / exercise**

   * Needs fast access to specific durations and audible alerts.
4. **Multilingual user**

   * Expects localized UI and core pages.

---

## 5) Functional requirements

## 5.1 Timer UX (core)

**FR-1** Timer display

* Display formatted time (MM:SS for minutes, SS for seconds with MM:SS fallback beyond 60s).

**FR-2** Controls

* Start/Pause toggle
* Reset
* Optional: Fullscreen mode (nice-to-have)

**FR-3** Presets & custom duration

* Preset grid for popular durations
* Custom input range 1–100, choose unit (minutes/seconds)

**FR-4** Timer label

* Input “timer name”; persists for session (optional localStorage)

**FR-5** Audio alert

* Play sound on completion
* Must respect browser autoplay rules (sound starts after user gesture)

**FR-6** Persistence

* Persist end timestamp in localStorage so refresh restores correct remaining time.

**FR-7** Accessibility

* Keyboard navigable controls
* ARIA labels for buttons
* High contrast readable time

---

## 5.2 Programmatic SEO (pSEO) system

### 5.2.1 pSEO page generation approach

Implement via a **Timer CPT** + fields:

* `duration_value` (int)
* `duration_unit` (minutes|seconds)
* `bucket` (short|medium|long|extended)
* optional `is_popular` (bool)
* optional `translation_key` (string for multilingual mapping)

**FR-8** Slug rules (canonical)

* Minutes: `set-timer-for-{value}-minute` vs `minutes` (choose one; enforce consistent pluralization)
* Seconds: `set-timer-for-{value}-second(s)`
* Store canonical slug in meta to prevent drift.

**FR-9** Bulk generator (admin/CLI)

* Must generate Timer posts from config:

  * minutes: list or range (e.g., 1–60 plus 90)
  * seconds: list (1,5,10,30,60)
* Must be idempotent: re-running should update existing posts rather than duplicate.

**FR-10** Template uniqueness guardrails
Each timer page must include:

* Tool UI
* Short intro paragraph (variant library; rotate by bucket/use-case)
* Related timers module
* Links to hub pages and relevant outer guides

(These guardrails support “relevance/responsiveness” and reduce thin-page risk.)

---

## 5.3 Koray SCN + Internal linking architecture

Koray’s document explicitly defines a **hub-and-spoke** model with link rules and crawl depth targets. 

**FR-11** Hub pages (pillars; L2)

* Create 6–12 pillar pages total (start with: Minute Timers, Second Timers, Pomodoro, Use Cases, Features, Troubleshooting).
* Pillars link to all cluster content in their category and receive links back. 

**FR-12** Cluster pages (L3/L4)

* Timer pages link:

  * Up to the relevant pillar
  * Sideways to related timers (2–4 contextual links minimum) 
* Must implement “bidirectional confirmation” when contextually appropriate. 

**FR-13** Crawl depth enforcement

* Core timer pages: max **2 clicks from homepage**
* Outer guides: max **3–4 clicks** 
  Implementation:
* Top nav links to hubs
* Hubs expose popular timers + bucket browsing
* Timer pages include breadcrumb + hub link

**FR-14** Link density guidelines

* Pillars: 20–40 internal links
* Clusters: 5–15 internal links
* Deep-dives: 3–8 internal links 

---

## 5.4 Content taxonomy & “core vs outer” separation

Koray’s framework requires a clear distinction between core and outer sections and avoidance of taxonomy overlap. 

**FR-15** Core section (pSEO)

* Timer duration pages
* Pomodoro tool page
* Key utility pages

**FR-16** Outer section (supporting)

* Guides (how-to, troubleshooting, best practices)
* Use-case content (only where it adds meaningful differentiation)

**FR-17** Taxonomy rules

* No overlapping categories (“mutually exclusive” buckets).
* Every generated timer must be assigned exactly:

  * one unit
  * one bucket

---

## 5.5 Multilingual requirements

**FR-18** Language routing

* Support directories: `/es/`, `/de/`, `/fr/`
* Translate:

  * UI strings (“Start”, “Reset”, etc.)
  * Hub pages
  * Core page template strings

**FR-19** SEO for multilingual

* hreflang tags
* language-specific sitemaps (if plugin supports)
* avoid duplicate-content issues by ensuring language pages are truly localized.

---

## 5.6 SEO & structured data

**FR-20** Sitemap coverage

* Timer CPT included in sitemap
* Language variants included

**FR-21** Metadata rules per page
The Koray doc includes title construction and per-article metadata expectations. 
For timer pages:

* Title format: “Set Timer for {X} {Minutes/Seconds} – {Brand}”
* Meta description includes primary intent + key features (audio, accuracy, mobile)

**FR-22** Schema (recommended)

* WebApplication / SoftwareApplication schema for timer tool pages
* FAQ schema for hub/guide pages (keep Q/A high quality)

---

## 6) Technical requirements & architecture

## 6.1 WordPress implementation

### Custom plugin: `timer-engine`

Responsibilities:

* Register CPT `timer` (REST enabled)
* Register taxonomies (unit, bucket, use_case)
* Template loader (single timer)
* Shortcodes/blocks:

  * popular timers
  * browse buckets
  * related timers
* WP-CLI command: `wp timer generate …`
* WP-CLI command: `wp timer validate-links …` (optional but valuable)

### Theme

* Lightweight theme (your starter theme is fine)
* Dedicated templates:

  * Home
  * Timer single
  * Timer archives (minutes/seconds/buckets/use-case)
  * Pomodoro page
  * Hub/guide templates

## 6.2 Deployment pipeline requirements (Docker → DO)

**TR-1** Local dev parity

* Docker Compose: WordPress + MySQL + phpMyAdmin
* Volumes: wp-content, wp-config.php, .htaccess (as you described)

**TR-2** Provisioning

* DO droplet creation via Python script + cloud-init
* SSH keys auto configured

**TR-3** Migration

* Export DB + package wp-content
* Transfer and import on droplet
* URL replacement (localhost → production)
* Restart Apache

**TR-4** “No-hassle” improvements (required for stability)

* Idempotent scripts (re-run safe)
* State file (droplet id/IP) to avoid confusion
* Post-deploy health checks:

  * homepage 200
  * wp-admin reachable
  * sample timer URL 200
  * permalinks working

---

## 7) Non-functional requirements

* **Performance**: timer pages should load fast; minimal JS; caching enabled.
* **Reliability**: timer must not drift significantly; handle tab sleep reasonably (use end timestamp approach).
* **Security**: hardened WP config; minimal plugins; disable password SSH on droplet.
* **Observability**: logging for deploy steps; basic error logging for JS timer failures.

---

## 8) Analytics & tracking

Events (GA4 or alternative):

* `timer_preset_click` (value, unit)
* `timer_start` (value, unit, page_type)
* `timer_pause`
* `timer_reset`
* `timer_complete`
* `timer_custom_set`
* `language_change`

SEO monitoring:

* GSC property per language (if needed)
* Index coverage by directory and CPT type

---

## 9) QA plan & acceptance criteria

### 9.1 Koray-style QA checklist (project version)

Koray’s QA list includes requirements like clear core/outer separation, internal linking architecture, metadata, and cannibalization checks. 

**AC-1** Architecture & taxonomy

* Core vs outer is documented and enforced
* No taxonomy overlap (bucket boundaries are exclusive)

**AC-2** Internal linking

* Every core timer page:

  * links to its hub
  * links to related timers (2–4+)
* Every hub links to all core timers in its scope (paginated acceptable)

**AC-3** Crawl depth

* Core timer pages accessible within 2 clicks from homepage. 

**AC-4** Technical

* Playwright: 0 broken internal links, 0 404
* Sitemap includes Timer CPT URLs

**AC-5** pSEO generator

* Re-running generation does not create duplicates
* Updates titles/meta when templates change

---

## 10) Rollout plan (phased)

### Phase 0 — Foundation

* Set up repo + Docker local environment
* Baseline theme + required plugins
* Implement timer-engine plugin skeleton

### Phase 1 — Core pSEO cluster (authority base)

* Timer CPT + generator
* Minutes (1–60 + 90), Seconds (1,5,10,30,60)
* Hub pages: Minute timers, Second timers
* Related timers + internal linking rules implemented

### Phase 2 — Pomodoro + use-case navigation

* Pomodoro tool page
* Use-case hub + curated use-case sections (not mass-generated thin pages)

### Phase 3 — Outer content (topical breadth)

* Troubleshooting, accuracy, mobile/browser behavior, productivity guides
* Strengthen SCN signals with contextual links

### Phase 4 — Multilingual expansion

* Translate hubs + template strings
* Expand translations based on traction

---

## 11) Risks & mitigations

**Risk: Thin/duplicate pSEO pages**

* Mitigation: enforce template enrichment + intro variants + related modules; expand only when validated by GSC.

**Risk: Cannibalization across similar durations**

* Mitigation: strict canonical slug rules + avoid duplicate “5 minutes” pages in multiple places; use hubs/taxonomies rather than duplicate posts.

**Risk: Index bloat**

* Mitigation: start with limited sets; scale after performance signals.

**Risk: Deployment drift**

* Mitigation: idempotent provisioning, state file, health checks.

---

## 12) Deliverables checklist

* [ ] `timer-engine` WP plugin (CPT, taxonomies, template loader, JS engine)
* [ ] WP-CLI generator command + config file (JSON/YAML)
* [ ] Hub templates + archive templates
* [ ] Multilingual configuration + translation string registration
* [ ] Sitemap validation + schema output
* [ ] Playwright QA scripts (404 + crawl depth + sample URL checks)
* [ ] One-command deploy flow integrated with your existing scripts

---


