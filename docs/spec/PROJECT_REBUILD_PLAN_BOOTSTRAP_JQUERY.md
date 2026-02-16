# Laravel 12 + Bootstrap 5 + jQuery Admin Platform
## Complete Project Plan - AI-Optimized & Minimal Dependencies

---

**Document Version:** 10.0 (Bootstrap + jQuery Stack)  
**Created:** February 16, 2026  
**Framework:** Laravel 12 + Bootstrap 5 + jQuery 3.6.1  
**Theme:** Bootstrap-based admin theme (default: Plain Bootstrap; optional: Limitless/AdminLTE4)  
**Philosophy:** Minimal dependencies, Maximum speed, AI-friendly code  
**Plan Scope:** Core Platform (Phase 0-21)  
**Enterprise Scope:** Optional Add-on (Phase 22-27, separate sellable pack) → see `PROJECT_REBUILD_PLAN_BOOTSTRAP_JQUERY_SCALE_ADDON.md`  


## 🎯 Project Overview

**สร้าง Laravel Admin Platform ใหม่ทั้งหมด** โดยใช้ Bootstrap 5 + jQuery แทน Vue/Livewire/Tailwind เพื่อ:

### ✅ ข้อดีหลัก:
1. **ไม่ต้อง npm build!** - แก้ไขเห็นผลทันที (hot reload)
2. **AI เขียนได้ดีที่สุด** - Bootstrap + jQuery มี training data มหาศาล
3. **เว็บไซต์เล็กและเร็ว** - ไม่มี Vue/React bundle, vendor น้อย
4. **Cursor ทำ UI เร็วและแม่นยำ** - syntax ง่าย มี snippet ให้ copy
5. **Theme สลับได้ในอนาคต** - เริ่มจาก Plain Bootstrap แล้วค่อย map ไป AdminLTE4/Limitless ได้โดยไม่แตะ feature logic
6. **Traditional MVC** - Controller → Blade → jQuery AJAX (ง่ายที่สุด)

---

## ✅ Feature Parity (Livewire Plan → Bootstrap Plan)

**เป้าหมายหลักของเอกสารชุดนี้คือ “เปลี่ยน stack แต่คงระบบ/ฟังก์ชันเท่าเดิม”** จาก `PROJECT_REBUILD_PLAN_LIVEWIRE_COMPLETE.md`

### What is already specified (Scope)
- ✅ โครงระบบ, เฟส, และหัวข้อฟีเจอร์หลัก ถูกสรุปเป็น spec ที่ Cursor ทำตามได้
- ✅ Phase 0 (Theme foundation) วางแนว Theme Adapter เพื่อสลับธีมภายหลังได้
- ✅ Phase 1–6 มีรายละเอียดและ snippets เพียงพอให้เริ่ม implement แบบ SSR+jQuery
- ✅ Phase 22–27 ถูกแยกเป็น optional add-on file เพื่อทำขายได้

### What is NOT fully rewritten yet (Details)
- ⚠️ บาง Phase ยังเป็น baseline spec/snippets (เพียงพอให้ Cursor ทำตาม pattern ได้) แต่ยังไม่ลงรายละเอียด “ทุก edge-case/ทุก workflow” แบบ ops-grade
- ⚠️ Builder/Factory/Enterprise-level UX (Phase 10+ และ Phase 22–27) ควรทำหลังผ่าน Layer gates เพื่อกัน drift

### Phase Mapping (Conceptual)
| Livewire Complete | Feature Set | Bootstrap Plan Status |
|---|---|---|
| Phase 0 | Base Theme Setup | ✅ Spec ready (theme adapter + minimal shell) |
| Phase 1 | Project setup | ✅ Covered (no npm build approach) |
| Phase 2 | Core migrations | ✅ Covered (RBAC tables + middleware baseline) |
| Phase 3 | Modules scaffold | ✅ Covered (first CRUD baseline pattern; generator in Phase 7) |
| Phase 4 | Core UI (dashboard/profile) | ✅ Covered (Phase 6 dashboard + auth views) |
| Phase 6 | Social login / 2FA / SMTP | ⚠️ To be detailed (will be added in Phase 7+) |
| Phase 7–13 | Tenant/RBAC/I18n/Menu/Media/Blog/SaaS | ✅ Covered (Layer gates + examples; deepen per module as needed) |
| Phase 17–19 | Theme/Module/Settings managers | ✅ Covered (kernel service baselines; expand ops-grade later) |
| Phase 21 | Payment & Billing (optional) | ⚠️ Not in core 0–21 (out of scope for this core plan) |
| Phase 22–27 | Scale features | ✅ Split to add-on file |

### ❌ สิ่งที่ไม่ใช้ (เพื่อลดขนาดและความซับซ้อน):
- ❌ Vue 3 / React / Livewire (framework overhead)
- ❌ Tailwind CSS (bundle ใหญ่)
- ❌ TypeScript (compile overhead)
- ❌ Inertia.js (middleware overhead)
- ❌ npm build process (ช้า)
- ❌ Alpine.js (ไม่จำเป็น มี jQuery แล้ว)
- ❌ Vendor packages ที่ไม่จำเป็น

### 🎨 Theme Strategy:
```
Theme Adapter Architecture
├── Theme 1 (default): Plain Bootstrap (minimal shell) ✅
├── Theme 2 (optional later): AdminLTE4 ✅
├── Theme 3 (optional later): Limitless ✅
├── Future themes: Plug-in style registration
└── Common component contract: card/modal/form/datatable (Layer A = plain Bootstrap markup; Layer B = Blade component library)

Goal: Build once, switch theme later without refactor feature logic
```

### 🔁 Theme Swapping Policy (No Rush on AdminLTE4)
1. **เริ่มจาก Plain Bootstrap ก่อน** เพื่อให้ระบบบูตได้เร็วและลด drift
2. **AdminLTE4 ยังไม่ต้องทำทันที** แต่รองรับด้วยโครง Theme Adapter ตั้งแต่ Phase 0
3. เมื่อพร้อมค่อยเพิ่ม `themes/adminlte4` และ map component contract เดิม
4. Route, Controller, Service และ Module code ต้องไม่ผูกกับ theme ใด theme หนึ่ง
5. ทุกหน้าเรียกผ่าน helper (`theme_view`, `theme_asset`) เพื่อสลับธีมได้จาก config

---

## 📦 Tech Stack (Minimal & Optimized)

### Backend (Essential Only)
```json
{
    "laravel/framework": "^12.41",
    "php": "^8.2",
    
    // Authentication (built-in Laravel)
    "laravel/sanctum": "^4.0",        // API tokens only
    
    // RBAC (custom or minimal package)
    // Option 1: Custom (0 dependencies)
    // Option 2: spatie/laravel-permission (if needed)
    
    // Multi-tenant (custom or minimal)
    // Will use custom tenant middleware (0 dependencies)
    
    // File uploads
    "intervention/image": "^3.0",     // Image manipulation only
    
    // Optional utilities (install only if needed)
    "barryvdh/laravel-debugbar": "^3.0"  // dev only
}
```

**Total Vendor Packages: ~5-7** (vs 50+ in typical Laravel projects)

### Frontend (CDN First!)
```html
<!-- Bootstrap 5.3.3 (CDN) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery 3.6.1 (CDN or local from Limitless) -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables (CDN) - Layer C optional - Load per-page only (Index pages) to keep core small -->
<!--
<link href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.min.js"></script>
-->

<!-- Limitless Custom (local) -->
<link href="{{ asset('themes/limitless/css/limitless.min.css') }}" rel="stylesheet">
<script src="{{ asset('themes/limitless/js/limitless.min.js') }}"></script>
```

**No npm, No build, No webpack!** 🎉

### JavaScript Policy (Vanilla vs jQuery)
**สรุป:** ใช้ **jQuery เป็น default สำหรับ Admin UI** (AI-friendly + plugin ecosystem) แต่ **อนุญาต vanilla JS** ในจุดที่มัน “เล็กกว่า/ตรงกว่า” และไม่ทำให้ต้องมี build

- **jQuery-first** สำหรับ: DOM manipulation, event delegation, AJAX (`$.ajax`), Bootstrap modal/toast helpers, DataTables (Layer C optional)
- **Vanilla-OK** สำหรับ: utility เล็กๆ (format, debounce), browser APIs (`URLSearchParams`, `Intl`, `FormData`), หรือ vendor ขนาดเล็กที่ไม่ต้อง build (เช่น `SortableJS`)
- **Rule:** 1 หน้าควรมี “1 style หลัก” อย่าผสมหลาย pattern ในหน้าเดียวถ้าไม่จำเป็น
- **No build-only libraries:** หลีกเลี่ยง lib ที่บังคับ bundler/TS/webpack

---

## 📉 File & Asset Minimization Policy (Cursor Guardrails)

เป้าหมาย: ให้ Cursor/AI สร้างระบบได้เร็วโดย **ไฟล์น้อย/เล็ก** และ “ไม่ลาก template ใหญ่ทั้งก้อน” เข้ามาตั้งแต่ต้น

### Hard Rules
- **ห้ามสร้าง megafile**: อย่าเขียน JS/CSS ยาว ๆ รวมทุกอย่างในไฟล์เดียวแบบควบคุมไม่ได้
- **ต่อหน้า = ต่อไฟล์**: JS แบบ per-page เป็นค่าเริ่มต้น (เช่น `public/js/pages/<page>.js`) และโหลดเฉพาะหน้าที่ใช้
- **อย่า copy ทั้ง template zip**: ถ้าเอา theme มา ให้เอาเฉพาะ **dist ที่จำเป็น** (minified css/js + images ที่ใช้จริง)
- **ห้ามเอา demo/docs/plugins ทั้งชุด**: หลีกเลี่ยง `/docs`, `/examples`, `/demo`, plugins ที่ไม่ได้ใช้
- **assets policy**: CDN-first สำหรับ vendor ทั่วไป, local เฉพาะ theme/custom ที่จำเป็น

### Theme/Templates มักใหญ่ — “เริ่มเล็กก่อน แล้วค่อย optimize” ได้
- ได้: เริ่มจาก minimal dist (เช่น 1 ไฟล์ CSS, 1 ไฟล์ JS ของ theme + รูปที่จำเป็น)
- ได้: เมื่อระบบเริ่มนิ่งแล้ว ค่อย trim/optimize/ลบส่วนไม่ใช้ของ template เพิ่ม
- ห้าม: optimize ก่อนระบบบูต/ผ่าน Layer gates (จะทำให้ AI drift และเสียเวลา)

### Recommended Asset Layout (Minimal)
```txt
public/
├── css/
│   └── app.css              # tiny project overrides only
├── js/
│   ├── app.js               # tiny global: action-router + helpers
│   └── pages/
│       ├── users-index.js   # per-page only
│       └── menus-builder.js
└── themes/
    └── <theme>/
        ├── css/<theme>.min.css
        ├── js/<theme>.min.js
        └── images/
```


---

## 🧱 Layer A/B/C Definition + Hard Gates (Anti-AI-Drift)

> **Important:** เรา “คงเลข Phase 0–21” ตามเดิม แต่เพิ่ม **Layer gates** เพื่อกัน Cursor/AI drift โดยเฉพาะเรื่อง UI/components/datatable/form builder

### Layer A: Kernel + Module Contracts (Contract-first)
**เป้าหมาย:** ทำ service/contract/table/command/generator ให้ครบ + มี test/seed/fixtures + มี UI harness “คลิกได้จริง” 3–5 หน้าหลัก

**Allowed (Layer A):**
- Blade SSR + Bootstrap markup แบบตรง ๆ (`div.card`, `table.table`, `<input class="form-control">`)
- jQuery action router + AJAX เล็กน้อย
- UI harness minimal (ตัวอย่าง: `/_shell`, `/dashboard`, `/users`, `/settings`)

**Forbidden (Layer A hard gate):**
- ห้ามใช้/สร้าง reusable UI component library (`<x-limitless::...>`) เป็น dependency หลัก
- ห้ามทำ/ผูก DataTables เป็น baseline (อนุญาตเฉพาะ “หมายเหตุ/ตัวเลือกอนาคต”)
- ห้ามเริ่ม form builder / report builder / datatable component ชุดใหญ่

### Layer B: Template Integration (Limitless/AdminLTE “ทั้งชุด”)
**เป้าหมาย:** ทำ layout + components library (card/modal/form/etc) และ migrate harness pages ให้ใช้ template/components จริง

**Allowed (Layer B):**
- ทำ `<x-limitless::card>`, `<x-limitless::modal>`, `<x-limitless::form.*>` ให้เสถียร
- Theme manager/white-label UI เฉพาะส่วน “integration” ที่ไม่บังคับให้ feature logic เปลี่ยน

### Layer C: UX Polish & App Factory
**เป้าหมาย:** UX builders / polish ที่มักทำให้ระบบ drift ถ้าเริ่มเร็ว

**Allowed (Layer C):**
- DataTables integration แบบเป็นแพ็ก (per-page) + datatable component ชุดใหญ่
- Form builder UI, report builder UI, advanced builders

### Gate A → B (ต้องผ่านก่อนเริ่ม Layer B)
- [ ] Tenant context + `tenant.selected` middleware ใช้งานจริง
- [ ] RBAC แบบ registry-first (permissions ไม่กระจัดกระจาย)
- [ ] Minimal audit baseline ถูกเรียกใน CRUD สำคัญ (create/update/delete)
- [ ] Action router เดียวทั้งระบบ (`data-action`)
- [ ] CRUD generator ออกโค้ด tenant-safe + permission hooks + audit hooks + workflow-ready
- [ ] UI harness 3–5 หน้า “คลิกได้จริง” และทดสอบได้ (tests/seed/fixtures)

### Gate B → C (ต้องผ่านก่อนเริ่ม Layer C)
- [ ] Template integrated ทั้งระบบ (layout + assets + navigation)
- [ ] Component library (card/modal/form) ใช้งานจริงใน harness pages
- [ ] มีกติกา per-page assets และตัวอย่าง migrate สำเร็จ

### Phase ↔ Layer (Primary Label)
| Phase | Primary Layer | Note |
|---:|:---:|---|
| 0–7 | A | Kernel + module contracts + generator + minimal UI harness (plain Bootstrap) |
| 8–9 | B | “สวม template” + component library + migrate harness pages แล้วค่อยทำ UI modules แรก |
| 10–21 | C | Expansion/Factory/UX polish (รวม builders + ops-grade kernel services + managers) |

---

## 🏗️ System Architecture

### Modular Structure (Minimal Edition)
```
app/
├── Http/
│   ├── Controllers/          # Traditional Controllers (NOT API)
│   │   ├── DashboardController.php
│   │   ├── UserController.php
│   │   ├── RoleController.php
│   │   └── TenantController.php
│   │
│   ├── Middleware/           # Custom only
│   │   ├── TenantMiddleware.php
│   │   └── RoleMiddleware.php
│   │
│   └── Requests/             # Form validation
│       └── UserRequest.php
│
├── Models/                   # Eloquent models
│   ├── User.php
│   ├── Role.php
│   ├── Permission.php
│   └── Tenant.php
│
├── Services/                 # Business logic
│   ├── TenantService.php
│   └── MediaService.php
│
└── helpers.php              # Global helpers

modules/                      # Feature modules (optional)
├── Crud/
├── Menu/
└── Media/

resources/
├── themes/
│   └── <theme>/             # Theme folder
│       ├── layouts/
│       │   ├── app.blade.php
│       │   ├── auth.blade.php
│       │   └── components/
│       │       ├── sidebar.blade.php
│       │       ├── header.blade.php
│       │       ├── breadcrumb.blade.php
│       │       └── footer.blade.php
│       │
│       ├── components/      # Reusable UI components (Layer B)
│       │   ├── card.blade.php
│       │   ├── datatable.blade.php
│       │   ├── form/
│       │   │   ├── input.blade.php
│       │   │   ├── select.blade.php
│       │   │   └── textarea.blade.php
│       │   ├── modal.blade.php
│       │   └── alert.blade.php
│       │
│       └── assets/          # Theme assets
│           ├── css/
│           ├── js/
│           └── images/
│
└── views/                   # Application views
    ├── dashboard/
    │   └── index.blade.php
    ├── users/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    └── auth/
        ├── login.blade.php
        └── register.blade.php

public/
├── themes/                  # Public theme assets (local dist) OR symlink to resources/themes/<theme>/assets
└── uploads/                 # User uploads

routes/
├── web.php                  # All routes here (no API routes)
└── auth.php                 # Auth routes
```

---

## 🧱 Platform Layering: Kernel → Modules → Apps (Long-term Survival)

เอกสารนี้ไม่ได้ “เลือก template” อย่างเดียว แต่กำลังออกแบบ **Application Platform** ที่เป็นฐานให้หลายร้อยแอป (เล็ก → ERP/สเกลใหญ่) โดยต้องแยกสิ่งที่ “นิ่ง” ออกจากสิ่งที่ “เปลี่ยนบ่อย” ให้ชัด

### 1) Kernel (ต้องนิ่งที่สุด)
**Kernel = สัญญา (contracts) + runtime + cross-cutting policies** ที่ทุก module/app ต้องพึ่ง และไม่ควรผูกกับ UI หรือ theme ใด theme หนึ่ง

- Module runtime: module registry/loader, boot order, config merge, migrations/routes/views loading
- Cross-cutting: tenancy context (`tenant_id()`), RBAC contract/naming, i18n hooks, caching policy, error/response conventions
- Theme adapter API: `theme_view`, `theme_asset`, `render_assets` (API ต้องนิ่ง แต่ theme implementation เปลี่ยนได้)

**Rule:** Kernel เปลี่ยนได้ แต่ต้อง “rare + careful” (หลีกเลี่ยง breaking changes)

### 2) Modules (เปลี่ยนได้/เพิ่มได้)
**Modules = capabilities** เช่น Menu/Media/Pages/Forms/Email/Crud โดยต้อง **packageable** และแยก concerns ชัด

- มี routes/migrations/views อยู่ใน module เอง
- พูดกับ kernel ผ่าน conventions/contracts/events (หลีกเลี่ยงเรียกข้าม module กันตรงๆ แบบ tight coupling)

### 3) Apps (เปลี่ยนบ่อยที่สุด)
**Apps = การประกอบ** kernel + modules + config + seed profile + theme choice ให้กลายเป็น “product/app” จริง

- เลือกเปิด/ปิด module ตาม app profile
- ใส่ seed data, default menus, default settings ของ app
- Theme/UI เป็นเรื่องของ app layer (ใช้ adapter เดิม)

### What should be stable vs changeable
- **Stable (Kernel):** tenancy/RBAC/i18n contracts, module boot process, naming conventions, theme adapter API
- **Changeable (Modules/Apps):** screens, builders, templates/themes, workflows, vertical business modules

### Kernel Services (Concept) — Keep jQuery, Avoid AI Drift
เป้าหมายคือ “ใช้ jQuery เหมือนเดิม” แต่ยกระดับเป็น platform แบบ **Kernel Services** เพื่อให้สร้างระบบเพิ่มได้อีกเยอะ และทำให้ Cursor/AI vibe-code ไม่เพี้ยน

**หลักการบังคับ (Kernel-first):**
- โมดูลใด ๆ **ห้ามนิยาม** สิทธิ/เวิร์กโฟลว์/แจ้งเตือน/ออดิท แบบ ad-hoc เฉพาะตัวเองโดยไร้สัญญา
- โมดูลต้องเรียกผ่าน **Kernel Service contract** เดียวกันเสมอ (เพื่อ consistency + auditability)

**Kernel Services Catalog (สิ่งที่ทุกแอปต้องได้เหมือนกัน)**

L1 (Platform Core — เริ่มทำจริงใน core plan นี้):
- Identity & Tenant: ผู้ใช้/ทีม/tenant switch, domain binding
- Auth/SSO Policy: session/token, login policy
- Access Control (RBAC/ABAC): policy กลาง + permission registry
- Workflow (State Machine): states/transitions/approvals/escalation
- Notification: email/webhook (+ template)
- Audit & Activity: audit log + activity stream
- File/Media: upload + ACL (versioning เป็น optional)
- Menu/Nav: dynamic menu ตาม role/tenant
- I18n: locale dictionary + import/export + fallback
- Settings: system/tenant/app settings
- Job/Queue + Scheduler: วาง contract ตั้งแต่ตอนนี้ (แม้ยังไม่สเกลสูง)

L2 (Ops-Grade Automation — อยู่ใน Phase 13–21 scope บางส่วน):
- Event Bus (Domain Events)
- Queue/Worker Contracts: retries, idempotency key, DLQ (roadmap)
- Scheduler: per-tenant schedule, timezone-aware, run history
- Webhook Dispatcher: signing, retry, rate-limit, delivery log

L3 (ERP-Grade Kernel — ไม่จำเป็นต้องทำครบวันแรก แต่ “สัญญา” ควรถูกวางไว้):
- Org/Cost center/Department model
- Approval chains (ผูกกับ Workflow)
- Accounting-grade audit (immutable log + correlation id)
- Reporting Service (definitions/datasets/exports)
- Integration Service (connectors/mapping/retries/sync status)

L4 (Platform Scale — บางส่วนอยู่ใน add-on, บางส่วนอยู่ใน Phase 13–21):
- Search/Index (per-tenant indexing)
- Cache strategy (tenant isolation + invalidation)
- Observability (logs/metrics/traces + per-tenant usage)
- DB scale roadmap (partitioning/read replicas/async projection)
- Backups/restore (per-tenant + audit)

### Phase-to-Kernel Services Mapping (No new features; clarify ownership)
เพื่อให้ “Phase 0–21” สอดคล้องกับ Kernel Services ที่ต้องมีเหมือนกันทุกแอป ให้ยึด mapping นี้เป็นตัวนำทาง:

- Phase 0: Theme Adapter + UI conventions (App layer) แต่ต้องใช้ Kernel contracts
- Phase 1: Auth policy baseline (Kernel: Auth/SSO policy)
- Phase 2: Access Control baseline (Kernel: permission registry + evaluation)
- Phase 4: Settings service baseline (Kernel)
- Phase 5: Identity & Tenant baseline (Kernel: tenant context + domain binding)
- Phase 7: Developer experience (Kernel: generator ต้อง register permissions/menus ผ่าน services)
- Phase 8–12: Module UIs ที่ “consume Kernel services” (Menu/Media/Pages/Forms/Email)
- Phase 13–21: เติม Ops/Advanced (Kernel L2/L4 pieces เช่น webhooks/activity/search/notifications/i18n/backup)

### (A) Kernel Services Deliverables Matrix (Phase 0–21, no renumber)
ตารางนี้ทำให้ชัดว่า “เรากำลังสร้าง platform kernel” ไม่ใช่แค่ทำหน้าจอ และช่วยให้ Cursor/AI ไม่กระโดดไปทำของซ้ำในโมดูล

| Kernel Service | Contract ต้องนิ่ง | Implemented/Planned in Phases (0–21) |
|---|---|---|
| Identity & Tenant | `tenant_id()`/tenant context, domain binding, tenant switch | Phase 5 (Kernel baseline), Phase 6 (App usage), Phase 13+ (ops/scale hooks) |
| Auth/SSO Policy | session/token/login policy, guard conventions | Phase 1 (baseline), Phase 13+ (advanced policy, tokens/webhooks auth) |
| Access Control (RBAC/ABAC) | permission registry + evaluation API | Phase 2 (baseline), Phase 3/7/8–12 (module registration & usage), Phase 13+ (ABAC rules if needed) |
| Workflow Service | state machine + approval task model | Phase 13–21 (planned: kernel L1/L2), modules/app consume later |
| Notification Service | channel+template+delivery logging contract | Phase 12 (template concept), Phase 13–21 (delivery + webhook/LINE planned) |
| Audit & Activity | audit schema + correlation id + immutable policy (roadmap) | Phase 13–21 (planned), Phase 8–12 should call audit hooks when implemented |
| File/Media | upload + ACL + URL contract | Phase 9 (module UI), Phase 13+ (ACL/versioning hardening) |
| Menu/Nav | render contract + filtering + cache | Phase 8 (module UI + theme integration), Phase 13+ (cache/observability) |
| I18n | dictionary import/export + fallback | Phase 13–21 (planned), MasterMenu already i18n-friendly |
| Settings | get/set + scope (system/tenant/app) | Phase 4 (baseline), Phase 13+ (export/backup) |
| Jobs/Queue/Scheduler | retry/idempotency conventions | Phase 13–21 (planned), start contracts early |

> Note: ตารางนี้ “ไม่เพิ่มฟีเจอร์ใหม่” แค่ล็อก ownership + sequence ให้ชัดว่าฟีเจอร์ไหนเป็น Kernel service และ Phase ไหนต้องแตะ

### (B) Contracts & Conventions (AI Guardrails)
ส่วนนี้คือ “กติกากลาง” ที่ทำให้ kernel service / modules / apps อยู่ในเส้นเดียวกัน และให้ Cursor/AI ทำงานไม่เพี้ยน

**1) Tenant & Data Isolation**
- ทุกตารางข้อมูลธุรกิจต้องมี `tenant_id` (ยกเว้น global registry เช่น permissions แบบ global)
- ทุก query ใน module ต้องเริ่มจาก tenant scope (`where('tenant_id', tenant_id())`) หรือใช้ trait/scope กลาง

**2) Permission Naming Convention (Registry-first)**
- รูปแบบ: `neonex.{domain}.{action}` เช่น `neonex.menu.manage`, `neonex.users.view`
- โมดูลต้อง “register permissions” ตอน boot/install ผ่าน access control registry (ห้ามกระจายไปสร้างเองหลายที่)

**3) Routes & UI Naming**
- Admin routes ใช้ prefix เดียว: `/admin` และ name prefix `admin.`
- CRUD resource: `admin.{resources}.index|create|store|edit|update|destroy`

**4) Workflow Hook Rule (future-proof)**
- ถ้า resource ไหนมี publish/approve/assign ให้เรียก workflow service เสมอ (ไม่ทำ state machine เฉพาะตัวเอง)
- ทุก transition ต้องเขียน audit

**5) Audit Rule (every important action)**
- Create/Update/Delete/Approve/Reject/Assign/Upload/Permission-change ต้องเขียน audit
- Event name ใช้รูปแบบ: `{domain}.{verb}` เช่น `users.created`, `menu.updated`, `media.uploaded`

**6) Notification Template Keys**
- template key ใช้รูปแบบ `domain.event` เช่น `auth.reset_password`, `billing.invoice_paid`
- ห้าม hardcode subject/body ใน module; ต้องไปผ่าน notification service + template

**7) jQuery UI Convention (single pattern)**
- ทุก interactive action ใช้ `data-action="domain.command"` + action router กลาง (event delegation)
- AJAX ให้ผ่าน wrapper/pattern เดียว (`$.ajax` + standard error handling)
- Per-page assets: DataTables/Sortable โหลดเฉพาะหน้าที่ต้องใช้

### Workflow Service (Kernel Contract Draft)
เพื่อให้ทุกแอป/โมดูลใช้ approval/publish/assign แบบเดียวกัน ให้ workflow เป็น “บริการกลาง”

**Core tables (contract):**
- `workflow_definitions` (name, version, states, transitions)
- `workflow_instances` (object_type, object_id, current_state)
- `workflow_tasks` (approver, due_date, status)
- `workflow_actions` (approve/reject/assign/escalate) → ทุกครั้งเขียน audit

**Hooks/Events (contract):**
- `on_transition`
- `on_task_created`
- `on_task_completed`

### UI Guardrails for Cursor/AI (jQuery-friendly)
เพื่อกัน AI เขียน JS กระจัดกระจาย ให้ล็อก “สัญญา UI” แบบเดียวทั้งระบบ:

**Action Contract:**
- ปุ่ม/ลิงก์ที่มี behavior ใช้ `data-action="domain.command"` เสมอ
- ใส่ `data-url`, `data-method`, `data-id`, `data-confirm` ตามต้องการ

**Single Action Router (event delegation):**
```html
<button
    class="btn btn-sm btn-danger"
    data-action="users.delete"
    data-url="/admin/users/123"
    data-method="DELETE"
    data-confirm="Delete this user?"
>Delete</button>
```

```js
// themes/limitless/js/app.js
$(document).on('click', '[data-action]', function (e) {
    e.preventDefault();
    const $el = $(this);
    const action = $el.data('action');
    const url = $el.data('url');
    const method = ($el.data('method') || 'GET').toUpperCase();
    const confirmMsg = $el.data('confirm');

    if (confirmMsg && !window.confirm(confirmMsg)) return;

    // Minimal example: standard AJAX wrapper (keeps behavior consistent)
    if (method !== 'GET') {
        $.ajax({
            url,
            type: method,
            headers: { 'Accept': 'application/json' },
            success: function () { location.reload(); },
            error: function (xhr) { alert(xhr.responseJSON?.message || 'Error'); }
        });
    } else {
        window.location.href = url;
    }
});
```

**Rule:** หน้าไหนมี interactive ให้เขียนผ่าน action router เดียวก่อนเสมอ (ลด pattern drift)

---

## 🚀 [Layer A] [Kernel + App] Phase 0: Platform Skeleton + Minimal UI Shell (0A + 0B) (6-8 hours)

### Objective
Phase 0 ต้องทำ “โครงแพลตฟอร์ม” ให้บูตได้ + ทำ UI Shell ให้รันได้เท่านั้น (ไม่ทำ component library หนัก ๆ)

> Rule: ห้ามเริ่มจาก reusable UI หนัก ๆ ใน Phase 0 เพราะ AI จะ drift เอา logic ไปวางใน controller/view ได้ง่าย

### 0A: Platform Skeleton (Kernel scaffolding)
- วางโครง Kernel → Modules → Apps และ conventions/contract ที่ใช้ร่วมกัน
- เตรียม registry contracts (RBAC registry / audit hook / action router rule) ไว้ก่อน
- ให้ module runtime “โหลดได้” (routes/views/migrations/providers) โดยไม่ผูกกับ UI

### 0.1: Theme Folder Ready in Git (0.5 hour)

#### Goal
- เตรียม theme folder + layout partials ขั้นต่ำให้ SSR render ได้ (จะเป็น plain bootstrap หรือธีมสำเร็จรูปก็ได้)
- เก็บ assets แบบ **local dist** หรือ **CDN-first** โดยไม่เพิ่ม bundler

#### Required Theme Layout (Minimal UI Shell)
```
resources/themes/<theme>/
├── layouts/
│   ├── app.blade.php
│   ├── auth.blade.php
│   └── components/
│       ├── sidebar.blade.php
│       ├── header.blade.php
│       └── footer.blade.php

# NOTE: card/modal/form/datatable component library is deferred to Layer B (starts Phase 8)
```

#### Public Assets Strategy (Keep Site Small)
**หลักการ:** โหลดเฉพาะที่ใช้จริง, แยก plugin เป็น per-page, และใช้ไฟล์ minified

Option A (Recommended): **Local minimal dist assets**
```
public/themes/<theme>/
├── css/<theme>.min.css
├── js/<theme>.min.js
└── images/
```

Option B: **CDN-first + local override**
- Bootstrap/jQuery ใช้ CDN
- Theme custom ใช้ local (minified)

### 0.2: Convert & Standardize Blade (1.5 hours)

**CI-style View Pattern (legacy reference):**
```php
<!-- CI4: app/Views/themes/limitless/main.php -->
<?= $this->extend('themes/limitless/layout') ?>
<?= $this->section('content') ?>
<div class="content">
    <?= view('components/table', ['data' => $users]) ?>
</div>
<?= $this->endSection() ?>
```

**Laravel Blade (NeonexCMS, minimal UI shell):**
```blade
{{-- Laravel: resources/views/users/index.blade.php --}}
@extends('themes.limitless.layouts.app')

@section('content')
<div class="content">
    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead><tr><th>ID</th><th>Name</th><th>Email</th></tr></thead>
            <tbody>
                @foreach($users as $u)
                    <tr><td>{{ $u->id }}</td><td>{{ $u->name }}</td><td>{{ $u->email }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
```

**Conversion Patterns:**
- `<?= $this->extend() ?>` → `@extends()`
- `<?= $this->section() ?>` → `@section()` / `@endsection`
- `<?= view() ?>` → `<x-component />` or `@include()`
- `<?= esc($var) ?>` → `{{ $var }}`
- `<?php foreach() ?>` → `@foreach()` / `@endforeach`

### 0.2: Theme System Setup (2 hours)

#### Theme Configuration
```php
// config/theme.php
<?php

return [
    'active' => env('THEME_NAME', 'limitless'),
    
    'themes' => [
        'limitless' => [
            'name' => 'Limitless Admin',
            'version' => '3.0',
            'path' => 'themes/limitless',
            'namespace' => 'limitless',
            
            // Asset optimization
            'assets' => [
                'css' => [
                    // CDN first (faster, no local copy)
                    'cdn' => [
                        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
                    ],
                    // Local only for custom theme
                    'local' => [
                        'themes/limitless/css/limitless.min.css',
                    ]
                ],
                'js' => [
                    'cdn' => [
                        'https://code.jquery.com/jquery-3.6.1.min.js',
                        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
                    ],
                    'local' => [
                        'themes/limitless/js/limitless.min.js',
                        'themes/limitless/js/app.js',  // Our custom code
                    ]
                ]
            ],
            
            // Features
            'features' => [
                'sidebar_collapsible' => true,
                'dark_mode' => true,
                'rtl' => false,
            ]
        ],
    ],
    
    // Performance
    'cache_enabled' => env('THEME_CACHE', true),
    'minify_assets' => env('THEME_MINIFY', true),
];
```

#### Theme Service Provider (Minimal)
```php
// app/Providers/ThemeServiceProvider.php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register theme namespace
        $themeName = config('theme.active');
        $themePath = resource_path("themes/{$themeName}");
        
        View::addNamespace($themeName, $themePath);
        
        // Register theme components
        $this->registerComponents($themeName);
        
        // Share theme config to all views
        View::share('theme', config("theme.themes.{$themeName}"));
    }
    
    private function registerComponents(string $theme): void
    {
        // Register Blade components with theme prefix
        // Layer B example: <x-limitless::card />
        Blade::componentNamespace("Resources\\Themes\\{$theme}\\Components", $theme);
    }
}
```

**Register in bootstrap/providers.php:**
```php
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\ThemeServiceProvider::class,  // Add this
];
```

#### Theme Helper Functions
```php
// app/helpers.php

if (!function_exists('theme_asset')) {
    /**
     * Get theme asset URL
     */
    function theme_asset(string $path): string
    {
        $theme = config('theme.active');
        return asset("themes/{$theme}/{$path}");
    }
}

if (!function_exists('theme_view')) {
    /**
     * Get theme view path
     */
    function theme_view(string $view): string
    {
        $theme = config('theme.active');
        return "{$theme}::{$view}";
    }
}

if (!function_exists('render_assets')) {
    /**
     * Render theme assets (CSS/JS)
     */
    function render_assets(string $type = 'css'): string
    {
        $theme = config('theme.active');
        $assets = config("theme.themes.{$theme}.assets.{$type}");
        
        $html = '';
        
        // CDN first (external, fast)
        foreach ($assets['cdn'] ?? [] as $url) {
            $html .= $type === 'css' 
                ? "<link rel=\"stylesheet\" href=\"{$url}\">\n"
                : "<script src=\"{$url}\"></script>\n";
        }
        
        // Local assets
        foreach ($assets['local'] ?? [] as $path) {
            $url = asset($path);
            $html .= $type === 'css'
                ? "<link rel=\"stylesheet\" href=\"{$url}\">\n"
                : "<script src=\"{$url}\"></script>\n";
        }
        
        return $html;
    }
}
```

### 0.3: Base Layout (2 hours)

#### Main Layout
```blade
{{-- resources/themes/limitless/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? config('app.name') }}</title>
    
    {{-- CSS Assets (CDN + Local) --}}
    {!! render_assets('css') !!}
    
    {{-- Page-specific styles --}}
    @stack('styles')
</head>
<body>
    {{-- Page container --}}
    <div class="page-container">
        
        {{-- Sidebar --}}
        @include('themes.limitless.layouts.components.sidebar')
        
        {{-- Main content --}}
        <div class="page-content">
            
            {{-- Header --}}
            @include('themes.limitless.layouts.components.header')
            
            {{-- Content area --}}
            <div class="content-wrapper">
                
                {{-- Breadcrumb --}}
                @if(isset($breadcrumbs))
                    @include('themes.limitless.layouts.components.breadcrumb')
                @endif
                
                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        {{ session('error') }}
                    </div>
                @endif
                
                {{-- Page content --}}
                <div class="content">
                    @yield('content')
                </div>
                
            </div>
            {{-- /content area --}}
            
            {{-- Footer --}}
            @include('themes.limitless.layouts.components.footer')
            
        </div>
        {{-- /main content --}}
        
    </div>
    {{-- /page container --}}
    
    {{-- JS Assets (CDN + Local) --}}
    {!! render_assets('js') !!}
    
    {{-- Global JS Configuration --}}
    <script>
        // CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Global error handler
        $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
            if (jqxhr.status === 419) {
                alert('Session expired. Please refresh the page.');
            }
        });
        
        // Global success toast
        window.showToast = function(message, type = 'success') {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alert = $(`
                <div class="alert ${alertClass} alert-dismissible alert-styled-left">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    ${message}
                </div>
            `);
            
            $('.content').prepend(alert);
            
            setTimeout(() => alert.fadeOut(() => alert.remove()), 3000);
        };
    </script>
    
    {{-- Page-specific scripts --}}
    @stack('scripts')
</body>
</html>
```

#### Sidebar Component
```blade
{{-- resources/themes/limitless/layouts/components/sidebar.blade.php --}}
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">
    
    {{-- Sidebar content --}}
    <div class="sidebar-content">
        
        {{-- User menu --}}
        <div class="sidebar-section">
            <div class="sidebar-user-material">
                <div class="sidebar-user-material-body">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('profile') }}" class="flex-1">
                            <img src="{{ auth()->user()->avatar ?? theme_asset('images/avatar.png') }}" 
                                 class="img-fluid rounded-circle" 
                                 alt="{{ auth()->user()->name }}">
                        </a>
                        <div class="ms-3">
                            <a href="{{ route('profile') }}" class="text-white">
                                {{ auth()->user()->name }}
                            </a>
                            <div class="text-muted">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- /user menu --}}
        
        {{-- Navigation --}}
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" 
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="ph-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                {{-- Users Management --}}
                @can('view_users')
                <li class="nav-item nav-item-submenu {{ request()->is('users*') ? 'nav-item-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="ph-users"></i>
                        <span>Users</span>
                    </a>
                    <ul class="nav-group-sub collapse {{ request()->is('users*') ? 'show' : '' }}">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" 
                               class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                All Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}" 
                               class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                Add User
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                
                {{-- Roles & Permissions --}}
                @can('view_roles')
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" 
                       class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <i class="ph-shield-check"></i>
                        <span>Roles & Permissions</span>
                    </a>
                </li>
                @endcan
                
                {{-- Settings --}}
                @can('view_settings')
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" 
                       class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="ph-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
                @endcan
                
            </ul>
        </div>
        {{-- /navigation --}}
        
    </div>
    {{-- /sidebar content --}}
    
</div>
```

#### Header Component
```blade
{{-- resources/themes/limitless/layouts/components/header.blade.php --}}
<div class="navbar navbar-expand-lg navbar-static">
    <div class="container-fluid">
        
        {{-- Mobile toggle --}}
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded">
                <i class="ph-list"></i>
            </button>
        </div>
        
        {{-- Logo --}}
        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="{{ route('dashboard') }}" class="d-inline-flex align-items-center">
                <img src="{{ theme_asset('images/logo.png') }}" alt="{{ config('app.name') }}">
            </a>
        </div>
        
        {{-- Right navbar --}}
        <ul class="nav flex-row justify-content-end order-1 order-lg-2">
            
            {{-- User menu --}}
            <li class="nav-item nav-item-dropdown-lg dropdown">
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                    <div class="status-indicator-container">
                        <img src="{{ auth()->user()->avatar ?? theme_asset('images/avatar.png') }}" 
                             class="w-32px h-32px rounded-pill" 
                             alt="{{ auth()->user()->name }}">
                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2">{{ auth()->user()->name }}</span>
                </a>
                
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ route('profile') }}" class="dropdown-item">
                        <i class="ph-user me-2"></i>
                        My Profile
                    </a>
                    <a href="{{ route('settings.index') }}" class="dropdown-item">
                        <i class="ph-gear me-2"></i>
                        Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" 
                       class="dropdown-item"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ph-sign-out me-2"></i>
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
            {{-- /user menu --}}
            
        </ul>
        
    </div>
</div>
```

### 0.4: Component Library Spec (Layer B only — implement starting Phase 8)

> **Layer A hard gate:** ในช่วง Phase 0 (Layer A) ให้ใช้ **plain Bootstrap markup** ไปก่อน
> - ห้ามผูก feature pages กับ `<x-limitless::...>`
> - spec ด้านล่างเก็บไว้เป็น “สเปคสำหรับ Layer B” เท่านั้น (อย่าทำใน Phase 0–7)

<details>
<summary><strong>Open Layer B component spec (reference only)</strong></summary>

#### Card Component
```blade
{{-- resources/themes/limitless/components/card.blade.php --}}
@props([
    'title' => null,
    'icon' => null,
    'actions' => null,
    'footer' => null,
    'class' => '',
])

<div class="card {{ $class }}">
    @if($title || $actions)
    <div class="card-header">
        <h5 class="card-title">
            @if($icon)
                <i class="{{ $icon }} me-2"></i>
            @endif
            {{ $title }}
        </h5>
        
        @if($actions)
        <div class="card-actions">
            {!! $actions !!}
        </div>
        @endif
    </div>
    @endif
    
    <div class="card-body">
        {{ $slot }}
    </div>
    
    @if($footer)
    <div class="card-footer">
        {!! $footer !!}
    </div>
    @endif
</div>
```

**Usage Example:**
```blade
<x-limitless::card 
    title="Users List" 
    icon="ph-users"
    :actions="'<a href=\"'.route('users.create').'\" class=\"btn btn-primary\">Add User</a>'">
    
    {{-- Card content --}}
    <p>Content here...</p>
    
</x-limitless::card>
```

#### DataTable Component (Limitless baseline)
```blade
{{-- resources/themes/limitless/components/datatable.blade.php --}}
@props([
    'id' => 'datatable',
    'columns' => [],
    'ajax' => null,
    'data' => null,
    'actions' => true,
    'class' => '',
])

<table id="{{ $id }}" class="table table-bordered table-hover {{ $class }}">
    <thead>
        <tr>
            @foreach($columns as $column)
                <th>{{ $column['label'] }}</th>
            @endforeach
            @if($actions)
                <th class="text-center" style="width: 120px;">Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if($data)
            @foreach($data as $row)
                <tr data-id="{{ $row->id }}">
                    @foreach($columns as $column)
                        <td>{{ data_get($row, $column['data']) }}</td>
                    @endforeach
                    @if($actions)
                        <td class="text-center">
                            {{ $slot }}
                        </td>
                    @endif
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

@push('scripts')
<script>
$(document).ready(function() {
    @if($ajax)
        // AJAX DataTable
        $('#{{ $id }}').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ $ajax }}',
            columns: [
                @foreach($columns as $column)
                    { data: '{{ $column['data'] }}', name: '{{ $column['data'] }}' },
                @endforeach
                @if($actions)
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                @endif
            ],
            order: [[0, 'desc']],
            pageLength: 25,
            language: {
                paginate: {
                    previous: '<i class="ph-arrow-left"></i>',
                    next: '<i class="ph-arrow-right"></i>'
                }
            }
        });
    @else
        // Simple DataTable
        $('#{{ $id }}').DataTable({
            pageLength: 25,
            language: {
                paginate: {
                    previous: '<i class="ph-arrow-left"></i>',
                    next: '<i class="ph-arrow-right"></i>'
                }
            }
        });
    @endif
});
</script>
@endpush
```

**Usage Example (Simple):**
```blade
<x-limitless::datatable 
    id="usersTable"
    :columns="[
        ['label' => 'ID', 'data' => 'id'],
        ['label' => 'Name', 'data' => 'name'],
        ['label' => 'Email', 'data' => 'email'],
    ]"
    :data="$users">
    
    {{-- Actions slot --}}
    <a href="{{ route('users.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>
    <button class="btn btn-sm btn-danger delete-btn">Delete</button>
    
</x-limitless::datatable>
```

**Usage Example (AJAX):**
```blade
<x-limitless::datatable 
    id="usersTable"
    :columns="[
        ['label' => 'ID', 'data' => 'id'],
        ['label' => 'Name', 'data' => 'name'],
        ['label' => 'Email', 'data' => 'email'],
    ]"
    ajax="{{ route('users.data') }}" />
```

#### Form Components

**Input Component:**
```blade
{{-- resources/themes/limitless/components/form/input.blade.php --}}
@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'readonly' => false,
    'help' => null,
])

<div class="mb-3">
    @if($label)
    <label class="form-label" for="{{ $name }}">
        {{ $label }}
        @if($required) <span class="text-danger">*</span> @endif
    </label>
    @endif
    
    <input 
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $readonly ? 'readonly' : '' }}
        {{ $attributes }}
    >
    
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    
    @if($help)
        <div class="form-text">{{ $help }}</div>
    @endif
</div>
```

**Select Component:**
```blade
{{-- resources/themes/limitless/components/form/select.blade.php --}}
@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => '',
    'placeholder' => 'Select...',
    'required' => false,
    'multiple' => false,
])

<div class="mb-3">
    @if($label)
    <label class="form-label" for="{{ $name }}">
        {{ $label }}
        @if($required) <span class="text-danger">*</span> @endif
    </label>
    @endif
    
    <select 
        id="{{ $name }}"
        name="{{ $name }}{{ $multiple ? '[]' : '' }}"
        class="form-select @error($name) is-invalid @enderror"
        {{ $required ? 'required' : '' }}
        {{ $multiple ? 'multiple' : '' }}
        {{ $attributes }}
    >
        @if(!$multiple && $placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        
        @foreach($options as $optValue => $optLabel)
            <option 
                value="{{ $optValue }}" 
                {{ old($name, $value) == $optValue ? 'selected' : '' }}
            >
                {{ $optLabel }}
            </option>
        @endforeach
    </select>
    
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
```

**Textarea Component:**
```blade
{{-- resources/themes/limitless/components/form/textarea.blade.php --}}
@props([
    'name',
    'label' => null,
    'value' => '',
    'rows' => 3,
    'placeholder' => '',
    'required' => false,
])

<div class="mb-3">
    @if($label)
    <label class="form-label" for="{{ $name }}">
        {{ $label }}
        @if($required) <span class="text-danger">*</span> @endif
    </label>
    @endif
    
    <textarea 
        id="{{ $name }}"
        name="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes }}
    >{{ old($name, $value) }}</textarea>
    
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
```

**Form Usage Example:**
```blade
<form method="POST" action="{{ route('users.store') }}">
    @csrf
    
    <x-limitless::form.input 
        name="name" 
        label="Full Name" 
        required 
    />
    
    <x-limitless::form.input 
        name="email" 
        type="email"
        label="Email Address" 
        required 
    />
    
    <x-limitless::form.select 
        name="role_id" 
        label="Role"
        :options="$roles"
        required 
    />
    
    <x-limitless::form.textarea 
        name="bio" 
        label="Biography"
        rows="5" 
    />
    
    <button type="submit" class="btn btn-primary">Save User</button>
</form>
```

#### Modal Component
```blade
{{-- resources/themes/limitless/components/modal.blade.php --}}
@props([
    'id',
    'title' => '',
    'size' => '', // sm, lg, xl
    'footer' => true,
])

<div class="modal fade" id="{{ $id }}" tabindex="-1">
    <div class="modal-dialog {{ $size ? 'modal-'.$size : '' }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                {{ $slot }}
            </div>
            
            @if($footer)
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="{{ $id }}-submit">Save</button>
            </div>
            @endif
        </div>
    </div>
</div>
```

**Modal Usage:**
```blade
{{-- Button to trigger --}}
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
    Add User
</button>

{{-- Modal --}}
<x-limitless::modal id="addUserModal" title="Add New User" size="lg">
    <form id="addUserForm">
        <x-limitless::form.input name="name" label="Name" required />
        <x-limitless::form.input name="email" type="email" label="Email" required />
    </form>
</x-limitless::modal>

@push('scripts')
<script>
$('#addUserModal-submit').click(function() {
    const formData = $('#addUserForm').serialize();
    
    $.post('{{ route('users.store') }}', formData)
        .done(function(response) {
            $('#addUserModal').modal('hide');
            showToast('User added successfully!');
            location.reload();
        })
        .fail(function(xhr) {
            alert('Error: ' + xhr.responseJSON.message);
        });
});
</script>
@endpush
```

</details>

---

## 📚 Phase 0 Deliverables

### Objective
Phase 0 must be **UI Shell** + **Platform Skeleton** only.

Goal: get a bootable Kernel/Modules runtime + a minimal theme/layout so we can build Kernel contracts first (tenant/RBAC/audit/workflow) without the AI drifting into view/controller logic.

### ✅ Execution Order Checklist (Phase 0)
- [ ] 0A: Platform Skeleton (Kernel scaffolding + module runtime conventions)
- [ ] 0B: Minimal UI Shell (theme runs: layout + assets + placeholder sidebar)

---

### 0A: Platform Skeleton (Kernel scaffolding)

### Objective
Create the **empty-but-structured** platform runtime: folder conventions, contracts, service providers, and module bootstrapping — with minimal/no UI.

### In scope
- [ ] Kernel/Modules structure conventions documented (where contracts/services live)
- [ ] Module runtime boots modules (providers, routes, views, migrations) in a consistent way
- [ ] Central registries are defined as contracts (permission registry, audit/event hooks) even if implementations stay minimal for now
- [ ] “Action Router” JS convention is established (data-action=...) as a global rule

### Out of scope
- [ ] Any real feature logic (auth/tenant/RBAC/etc.) — starts Phase 1+
- [ ] UI component library (cards/forms/modals/datatables) — move to Phase 8 (Layer B)
- [ ] Dynamic sidebar/menu rendering — starts Phase 8

**Exit criteria (Phase 0A):**
- [ ] App boots with the module loader loading at least 1 module skeleton
- [ ] A module can register routes/views/migrations without touching core folders

### Phase 0A Output
- [ ] Documented conventions + bootstrapping skeleton (Kernel → Modules)
- [ ] Contracts stubs exist for later phases to implement

---

### 0B: Minimal UI Shell (theme runs)

### Objective
Make the theme render **one SSR admin page** reliably (assets + layout) so Kernel phases can be tested, without building a full component library.

### In scope
- [ ] Theme assets prepared (local dist OR CDN-first)
- [ ] Theme config + ThemeServiceProvider wired
- [ ] Theme adapter helpers exist: `theme_asset()`, `theme_view()`, `render_assets()` (API only)
- [ ] Base layouts only: `app`, `auth` (thin)
- [ ] Layout partials only: sidebar/header/footer/breadcrumb (placeholder, not DB-driven)
- [ ] Per-page assets loading policy documented (no global heavy plugins)

### Out of scope
- [ ] DataTable component + full DataTables init set — move to Phase 8 (Layer C optional)
- [ ] Modal/form/card component library — move to Phase 8 (Layer B)
- [ ] Sidebar dynamic render from DB — move to Phase 8
- [ ] Theme switching UI — Phase 20

**Exit criteria (Phase 0B):**
- [ ] Theme renders a sample admin page via Blade layout (no broken assets)
- [ ] Bootstrap/theme JS plugins load without npm build
- [ ] Placeholder sidebar renders and does not depend on DB/menu services

### Phase 0B Output
- [ ] Minimal UI shell is working (layout + assets + placeholder nav)
- [ ] Theme adapter API is stable for later phases

---

### Deferred from Phase 0 (moved later)
- UI component library (cards/forms/modals) → Phase 8 (Layer B)
- Datatable component + DataTables init pack → Phase 8
- Sidebar dynamic menu rendering → Phase 8

### ✅ Checklist (Phase 0)
- [ ] Theme folder + layout partials created
- [ ] Public theme assets ready (local dist) OR CDN-first strategy applied
- [ ] CI4 views converted to Laravel Blade
- [ ] Theme config created
- [ ] ThemeServiceProvider registered
- [ ] Helper functions added
- [ ] Base layouts created (app, auth)
- [ ] Layout components created (sidebar, header, footer)
- [ ] Assets optimized (CDN first, minified local)

### 📁 File Structure After Phase 0

```
config/
└── theme.php                    ✅ Theme configuration

app/
├── Providers/
│   └── ThemeServiceProvider.php ✅ Theme service provider
└── helpers.php                  ✅ Theme helper functions

resources/
└── themes/
    └── limitless/
        ├── layouts/
        │   ├── app.blade.php           ✅ Main layout
        │   ├── auth.blade.php          ✅ Auth layout
        │   └── components/
        │       ├── sidebar.blade.php    ✅ Sidebar (placeholder)
        │       ├── header.blade.php     ✅ Header
        │       ├── breadcrumb.blade.php ✅ Breadcrumb
        │       └── footer.blade.php     ✅ Footer

public/
└── themes/
    └── limitless/
        ├── css/
        │   └── limitless.min.css       ✅ Theme styles
        ├── js/
        │   ├── limitless.min.js        ✅ Theme scripts
        │   └── app.js                  ✅ Custom scripts
        └── images/
            ├── logo.png                ✅ Logo
            └── avatar.png              ✅ Default avatar
```

### 🧪 UI Shell Smoke Test Page

Create a smoke-test page to verify the UI shell works (layout + assets only):

```php
// routes/web.php
Route::get('/_shell', function() {
    return view('shell');
})->name('shell');
```

```blade
{{-- resources/views/shell.blade.php --}}
@extends('themes.limitless.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0">UI Shell</h6>
                <span class="badge text-bg-secondary">Phase 0B</span>
            </div>
            <div class="card-body">
                <p class="mb-0">This page validates layouts + assets only (no component library).</p>
            </div>
        </div>
    </div>
    
    {{-- Table Test --}}
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Table (plain)</h6></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead><tr><th>ID</th><th>Name</th><th>Email</th></tr></thead>
                        <tbody>
                            <tr><td>1</td><td>Example</td><td>example@example.com</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Form Test --}}
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Form (plain)</h6></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input class="form-control" placeholder="Enter name" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" placeholder="Enter email" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select class="form-select"><option>Admin</option></select>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal Test --}}
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Modal (plain)</h6></div>
            <div class="card-body">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#testModal">
                    Open Test Modal
                </button>
            </div>
        </div>

        <div class="modal fade" id="testModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Test Modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">This is a test modal content.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

---

## 🎯 Next Phases Overview (Core Plan)

## ✅ Phase 1–6 (Detailed Implementation)

> Goal: ทำให้ระบบ “ใช้ได้จริง” ตั้งแต่ Phase 1–6 โดย **ไม่ต้อง npm build**, UI ใช้ Bootstrap+Limitless, และ code pattern ง่ายสำหรับ Cursor/AI

---

### ✅ Execution Order Checklist (Phase 1–7)

> เป้าหมาย: ทำตามลำดับ “ลดการย้อนแก้” และทำให้ tenant + permission + generator เดินได้ไว

> หมายเหตุสำคัญ: **ลำดับการลงมือทำให้ยึด checklist นี้เป็นหลัก** (ไม่จำเป็นต้องทำตามเลข Phase แบบเรียง 1→7 เสมอ) เพื่อให้ “tenant-first + registry-first + audit-first” เกิดจริง

- [ ] Phase 1: Auth ทำงานครบ (login/register/logout + auth layout)
- [ ] Phase 5: Tenant resolver ทำงาน (ได้ `tenant_id()` / `app('tenant.id')` + middleware)
- [ ] Phase 4: Settings service tenant-aware (อ่าน/เขียน + cache + clear cache)
- [ ] Phase 2: RBAC minimal + `permission` middleware (seed role/permission ขั้นต่ำ)
- [ ] Phase 3: Users CRUD (tenant + permission guard + list/edit/delete)
- [ ] Phase 6: Dashboard (อยู่หลัง auth+tenant, มี quick links)
- [ ] Phase 7: CRUD Generator (generate ออกมาเป็น Blade+jQuery, tenant-safe, permission-safe)

**Exit criteria (Phase 1–7):**
- [ ] เปิด `/dashboard` ได้หลัง login และเลือก tenant
- [ ] เปิด `/admin/users` และทำ CRUD ได้
- [ ] `php artisan neonex:make:crud ...` สร้างโมดูลที่เปิดหน้า index/create/edit ได้โดยไม่ต้อง `npm build`

## [Layer A] [Kernel] Phase 1: Authentication (No Starter Kit, No npm) (8-12 hours)

### Objective
Deliver working session auth (login/register/logout) with Limitless-styled Blade pages and safe defaults, without using any starter kit or frontend build.

### In scope
- [ ] Login/Register/Logout with session-based auth (no starter kit)
- [ ] Blade views for auth pages using Limitless/Bootstrap
- [ ] Basic validation + session regenerate on login

### Out of scope
- [ ] Password reset, email verification, 2FA (add later if needed)
- [ ] SSO/OAuth/SAML
- [ ] SPA auth flows / token auth for admin UI

### 1.1 Routes
```php
// routes/auth.php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
```

### 1.2 Controllers
```php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = (bool) $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Invalid credentials.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
```

```php
// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
```

### 1.3 Blade Views (Bootstrap/Limitless)
```blade
{{-- resources/views/auth/login.blade.php --}}
@extends('themes.limitless.layouts.auth')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Login</h5>

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input class="form-control" name="email" type="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input class="form-control" name="password" type="password" required>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-3">
                <label class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember" value="1">
                    <span class="form-check-label">Remember me</span>
                </label>
            </div>

            <button class="btn btn-primary w-100" type="submit">Sign in</button>
        </form>
    </div>
</div>
@endsection
```

**Exit criteria (Phase 1):**
- [ ] Login/Register/Logout works; session regenerates on login
- [ ] Auth pages render with Limitless auth layout (assets load)
- [ ] Guests are redirected away from protected routes

### Phase 1 Output
- [ ] Auth routes + controllers + Blade views (no starter kit)
- [ ] Session-based auth working end-to-end

---

## [Layer A] [Kernel] Phase 2: RBAC (Custom Minimal) (8-12 hours)

### Objective
Provide minimal roles/permissions + middleware so modules can be guarded consistently (and so generator output can attach permissions later).

### In scope
- [ ] Minimal tables: roles/permissions + pivots
- [ ] `User::canDo()` (or equivalent) + `permission` middleware
- [ ] Route guarding for at least one module (Users)

### Out of scope
- [ ] Full policy/ability matrix UI (role editor, permission UI)
- [ ] Hierarchical roles, attribute-based access control (ABAC)
- [ ] Field-level permissions

### 2.1 Tables (Minimal)
```php
// database/migrations/xxxx_create_roles_permissions_tables.php

Schema::create('roles', function ($table) {
    $table->id();
    $table->string('name')->unique();
    $table->string('label')->nullable();
    $table->timestamps();
});

Schema::create('permissions', function ($table) {
    $table->id();
    $table->string('name')->unique();
    $table->string('label')->nullable();
    $table->timestamps();
});

Schema::create('role_user', function ($table) {
    $table->foreignId('role_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->primary(['role_id', 'user_id']);
});

Schema::create('permission_role', function ($table) {
    $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
    $table->foreignId('role_id')->constrained()->cascadeOnDelete();
    $table->primary(['permission_id', 'role_id']);
});
```

### 2.2 User Model Helper
```php
// app/Models/User.php

public function roles()
{
    return $this->belongsToMany(Role::class);
}

public function hasRole(string $roleName): bool
{
    return $this->roles()->where('name', $roleName)->exists();
}

public function canDo(string $permissionName): bool
{
    return $this->roles()
        ->whereHas('permissions', fn ($q) => $q->where('name', $permissionName))
        ->exists();
}
```

### 2.3 Middleware
```php
// app/Http/Middleware/PermissionMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = $request->user();

        if (!$user || !$user->canDo($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
```

**Route usage:**
```php
Route::middleware(['auth', 'tenant.selected', 'permission:view_users'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});
```

**Exit criteria (Phase 2):**
- [ ] Roles/permissions migrations run cleanly
- [ ] `permission:*` middleware enforces 403 for unauthorized
- [ ] A seeded role can access at least one guarded route

### Phase 2 Output
- [ ] Minimal RBAC tables + pivots
- [ ] `User::canDo()` (or equivalent) + permission middleware wired

---

## [Layer A] [Module] Phase 3: User Management (CRUD baseline, no heavy UI yet) (8-12 hours)

### Objective
Ship the first real CRUD that is **tenant-safe + permission-guarded + audit-first** (no heavy reusable UI yet).

### In scope
- [ ] Users CRUD (index/create/edit/delete) with permission guard
- [ ] Tenant scoping is mandatory (Phase 5 prerequisite)
- [ ] Audit must be recorded on create/update/delete (minimal baseline)
- [ ] Plain SSR list + AJAX delete (no DataTables/component library yet)

### Out of scope
- [ ] Advanced profile features (avatar cropping, audit UI per-user)
- [ ] Bulk import/export (belongs to Phase 16)
- [ ] Complex filtering UI builder

### 3.0 Kernel Contracts Required (Tenant + Audit)
- Phase 5 must already provide `tenant_id()` / tenant context.
- Add a minimal audit baseline **now** so you don’t retrofit later.

**Minimal audit table (baseline):**
```php
Schema::create('audit_logs', function ($table) {
    $table->id();
    $table->uuid('tenant_id')->nullable()->index();
    $table->unsignedBigInteger('actor_id')->nullable()->index();
    $table->string('event', 120)->index();
    $table->string('subject_type', 120)->nullable();
    $table->string('subject_id', 64)->nullable();
    $table->json('payload')->nullable();
    $table->string('correlation_id', 64)->nullable()->index();
    $table->timestamps();
});
```

**Minimal helper contract (baseline):**
```php
// audit()->record($event, $payload, subject: $model)
// For Phase 3, implementation can be a thin DB insert.
```

### 3.1 Routes
```php
Route::middleware(['auth', 'tenant.selected', 'permission:view_users'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
```

### 3.2 Controller (AJAX-friendly)
```php
// app/Http/Controllers/UserController.php

public function index()
{
    $users = User::query()
        ->where('tenant_id', tenant_id())
        ->latest()
        ->limit(500)
        ->get();
    return view('users.index', compact('users'));
}

public function destroy(User $user)
{
    abort_if($user->tenant_id !== tenant_id(), 403);

    $user->delete();

    audit()->record('users.deleted', ['user_id' => $user->id, 'email' => $user->email], subject: $user);
    return response()->json(['ok' => true]);
}
```

### 3.3 View (Plain table + delete)
```blade
{{-- resources/views/users/index.blade.php --}}
@extends('themes.limitless.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6 class="mb-0">Users</h6>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Add</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover">
                <thead><tr><th>ID</th><th>Name</th><th>Email</th><th style="width: 120px;">Actions</th></tr></thead>
                <tbody>
                    @foreach($users as $u)
                        <tr data-id="{{ $u->id }}">
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('users.edit', $u) }}">Edit</a>
                                <a class="btn btn-sm btn-danger js-delete" href="#">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '.js-delete', function(e) {
    e.preventDefault();
    if (!confirm('Delete this user?')) return;

    const id = $(this).closest('tr').data('id');

    $.ajax({
        url: '/users/' + id,
        type: 'DELETE',
        success: function() { location.reload(); },
        error: function(xhr) { alert(xhr.responseJSON?.message || 'Error'); }
    });
});
</script>
@endpush
```

**Exit criteria (Phase 3):**
- [ ] Users list renders and is permission-guarded
- [ ] Create/Edit/Delete works and is tenant-scoped
- [ ] Delete records an audit log row (`users.deleted`)

### Phase 3 Output
- [ ] Users CRUD screens (SSR) + jQuery delete
- [ ] Route-level permission guards applied

---

## [Layer A] [Kernel] Phase 4: Settings System (Tenant-aware) (6-8 hours)

### Objective
Implement a tenant-aware settings store + service that becomes a shared dependency for modules (theme, i18n, notifications, etc.).

### In scope
- [ ] `settings` table contract + tenant-scoped unique key
- [ ] `SettingService::get()` cache-first pattern
- [ ] Cache clear behavior when settings change (minimal)

### Out of scope
- [ ] Full settings admin UI (can be added later)
- [ ] Encrypted secrets/rotation UI
- [ ] Multi-level overrides beyond tenant/app (org/user)

### 4.1 Table
```php
Schema::create('settings', function ($table) {
    $table->id();
    $table->unsignedBigInteger('tenant_id')->nullable()->index();
    $table->string('group')->default('app')->index();
    $table->string('key')->index();
    $table->longText('value')->nullable();
    $table->string('type')->default('string');
    $table->timestamps();

    $table->unique(['tenant_id', 'group', 'key']);
});
```

### 4.2 Access Pattern (Cache first)
```php
// app/Services/SettingService.php

public function get(string $group, string $key, $default = null)
{
    $tenantId = app('tenant.id'); // from tenant middleware
    $cacheKey = "settings:{$tenantId}:{$group}:{$key}";

    return cache()->remember($cacheKey, now()->addMinutes(10), function () use ($tenantId, $group, $key, $default) {
        $row = Setting::query()
            ->where('tenant_id', $tenantId)
            ->where('group', $group)
            ->where('key', $key)
            ->first();

        return $row?->value ?? $default;
    });
}
```

**Exit criteria (Phase 4):**
- [ ] `SettingService::get()` returns correct tenant-scoped values
- [ ] Cache is invalidated on writes (no stale reads)
- [ ] Unique constraint prevents duplicate keys per tenant/group

### Phase 4 Output
- [ ] Tenant-aware settings table + cache-first read pattern
- [ ] Minimal cache clear behavior on updates

---

## [Layer A] [Kernel] Phase 5: Multi-Tenancy (Path/Subdomain/Domain) (10-14 hours)

### Objective
Resolve the current tenant per request and expose a stable tenant context (`tenant_id`) so all module queries can be scoped safely.

### In scope
- [ ] Minimal tables (tenants, tenant_domains, tenant_user)
- [ ] Tenant resolver middleware (domain → subdomain → path)
- [ ] Expose `tenant_id()` / `app('tenant.id')` for scoping queries

### Out of scope
- [ ] Separate database per tenant / dynamic DB connections
- [ ] Tenant provisioning UI + billing
- [ ] Complex tenant RBAC (org units) beyond basic tenant association

### 5.1 Tables (Minimal)
```php
Schema::create('tenants', function ($table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});

Schema::create('tenant_domains', function ($table) {
    $table->id();
    $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
    $table->string('domain')->unique();       // example.com
    $table->string('subdomain')->nullable();  // tenant
    $table->string('path')->nullable();       // /t/tenant
    $table->timestamps();
});

Schema::create('tenant_user', function ($table) {
    $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->primary(['tenant_id', 'user_id']);
});
```

### 5.2 Tenant Resolver Middleware (Priority: domain → subdomain → path)
```php
// app/Http/Middleware/TenantMiddleware.php

public function handle($request, $next)
{
    $host = $request->getHost();
    $path = '/' . ltrim($request->path(), '/');

    $tenant = TenantDomain::query()
        ->where('domain', $host)
        ->first();

    if (!$tenant) {
        $parts = explode('.', $host);
        $sub = count($parts) > 2 ? $parts[0] : null;

        if ($sub) {
            $tenant = TenantDomain::query()->where('subdomain', $sub)->first();
        }
    }

    if (!$tenant) {
        // Example convention: /t/{slug}/...
        if (preg_match('#^/t/([^/]+)#', $path, $m)) {
            $tenant = TenantDomain::query()->where('path', '/t/'.$m[1])->first();
        }
    }

    abort_if(!$tenant, 404);

    app()->instance('tenant.id', $tenant->tenant_id);
    app()->instance('tenant.domain', $tenant);

    return $next($request);
}
```

**Exit criteria (Phase 5):**
- [ ] Tenant resolves by domain/subdomain/path in defined priority
- [ ] `tenant_id()` / `app('tenant.id')` is stable per request
- [ ] Tenant middleware blocks requests without a resolved tenant

### Phase 5 Output
- [ ] Tenant tables + resolver middleware
- [ ] Stable tenant context available for module scoping

---

## [Layer A] [App] Phase 6: Dashboard (6-8 hours)

### Objective
Create the first real admin landing page to validate auth + tenant middleware + navigation in SSR (plain Bootstrap; template components come in Layer B).

### In scope
- [ ] Auth + tenant protected dashboard route
- [ ] Basic stats + quick links (SSR)
- [ ] Use plain Bootstrap markup (no component library yet)

### Out of scope
- [ ] Charts/analytics suite
- [ ] Widget marketplace / configurable dashboard
- [ ] Realtime dashboards (websocket)

### 6.1 Route + Controller
```php
Route::middleware(['auth', 'tenant.selected'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
```

```php
// app/Http/Controllers/DashboardController.php

public function index()
{
    $tenantId = app('tenant.id');

    $stats = [
        'users' => \App\Models\User::count(),
        'tenants' => \App\Models\Tenant::count(),
    ];

    $quickLinks = [
        ['label' => 'Users', 'url' => route('users.index')],
        ['label' => 'Settings', 'url' => route('settings.index')],
    ];

    return view('dashboard.index', compact('stats', 'quickLinks'));
}
```

### 6.2 View
```blade
{{-- resources/views/dashboard/index.blade.php --}}
@extends('themes.limitless.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Users</h6></div>
            <div class="card-body"><h3 class="mb-0">{{ $stats['users'] }}</h3></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Tenants</h6></div>
            <div class="card-body"><h3 class="mb-0">{{ $stats['tenants'] }}</h3></div>
        </div>
    </div>

    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Quick Links</h6></div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($quickLinks as $link)
                        <a class="btn btn-outline-primary" href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

**Exit criteria (Phase 6):**
- [ ] `/dashboard` renders only for authenticated + tenant-selected users
- [ ] Dashboard uses plain Bootstrap markup (component library comes in Layer B)

### Phase 6 Output
- [ ] Dashboard route/controller/view in SSR
- [ ] Quick links validate navigation path for later modules

### [Modules] Phase 7-12: Content Management (32-40 hours)

---

### ✅ Execution Order Checklist (Phase 8–12)

> เป้าหมาย: ทำ content stack ที่ reuse กันได้ (Menu → Media → Pages → Forms → Email)

- [ ] Phase 8: Menu Builder (เพราะต้องใช้เมนูจริงใน theme และเป็นพื้นฐาน UI navigation)
- [ ] Phase 9: Media Manager (ให้ Pages/Email/Form ใช้ไฟล์ได้)
- [ ] Phase 10: Page Builder (ใช้ media URLs และต้องมี slug routing tenant-safe)
- [ ] Phase 11: Forms Builder (เก็บ submissions + validate schema)
- [ ] Phase 12: Email Templates (ส่ง test mail + variables; เริ่มจาก minimal)

**Exit criteria (Phase 8–12):**
- [ ] Sidebar render จาก DB ได้จริงทุก tenant
- [ ] Upload media ได้ + browse/search/pagination ได้
- [ ] สร้าง page แล้วเปิด public `/p/{slug}` ได้ตาม tenant
- [ ] สร้าง form + submit แล้วมี record ใน submissions
- [ ] Send test email ได้จาก template key

## [Layer A] [Kernel] Phase 7: CRUD Generator (Blade + jQuery, No npm build) (12-18 hours)

### Objective
สร้าง CRUD Generator ที่ทำให้ Cursor/AI “ทำงานเร็วและถูก” ด้วยการ generate โค้ดที่:
- ใช้ **Blade + Bootstrap/Limitless + jQuery** เท่านั้น
- **ไม่ใช้ Vue/Inertia** และ **ไม่มี npm build step**
- ออกแบบให้เป็น **module-first** (เอาไปขายเป็นแพ็ก/โมดูลได้)

> Note: ถ้ามี generator/stubs จากโปรเจ็คเก่าที่เน้น Vue/Inertia ให้เก็บไว้เป็น `--stack=legacy` ได้ แต่ **default ต้องเป็น Blade+jQuery** ตามเอกสารนี้

### In scope
- [ ] Default output = Blade + jQuery CRUD (no npm)
- [ ] Module-first output (views/migrations/routes in module)
- [ ] Tenant scoping + AJAX-friendly delete + per-page plugin loading
- [ ] Auto-register permission + menu entry (minimal)

### Out of scope
- [ ] Visual CRUD designer UI
- [ ] Generating API/SDK clients, OpenAPI specs
- [ ] Full test suite generator + CI pipeline
- [ ] Multiple frontend stacks (beyond optional legacy flag)

### 7.1 Generator Command Contract
ใช้ command เดิม (เพื่อไม่ให้ breaking กับของเก่า) แล้วเพิ่ม option ควบคุม output

```bash
# Default = Blade CRUD (no npm)
php artisan neonex:make:crud Product --schema=stubs/crud/product.json --module=Content

# Optional flags
php artisan neonex:make:crud Product --fields="name:string:required,price:integer:required,is_active:boolean:nullable" --module=Content

# (Optional legacy) if needed
php artisan neonex:make:crud Product --stack=legacy
```

**Required Options (Minimal-first):**
- Default schema format: **JSON**
- YAML support: optional (เปิดเฉพาะ dev ถ้ามี `symfony/yaml`)

### 7.2 Schema Format (JSON)
```json
{
  "name": "Product",
  "table": "products",
  "route": {
    "prefix": "admin",
    "middleware": ["web", "auth", "tenant.selected"]
  },
  "fields": {
    "name": {"type": "string", "label": "Name", "validation": "required"},
    "price": {"type": "integer", "label": "Price", "validation": "required"},
    "is_active": {"type": "boolean", "label": "Active", "validation": "nullable"}
  }
}
```

### 7.3 Generated Output (Default Laravel Layout)

**When generating a simple CRUD (default):**
```
app/
├── Models/Product.php
└── Http/
    ├── Controllers/Admin/ProductController.php
    └── Requests/Admin/ProductRequest.php
database/migrations/
└── xxxx_xx_xx_xxxxxx_create_products_table.php
routes/
└── admin.php
resources/views/admin/products/
├── index.blade.php
├── create.blade.php
└── edit.blade.php
```

> ถ้าคุณใช้ “module loader” ในโปรเจ็คของคุณอยู่แล้ว สามารถย้าย output เข้า `modules/<Domain>/*` ได้
> แต่ **ตัวอย่างในเอกสารนี้ต้องไม่ผูกกับ module framework ของ repo ใด repo หนึ่ง**

### 7.4 Blade Controller Stub (Tenant-aware + Simple)
```php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->where('tenant_id', tenant_id());

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Keep it simple first: server pagination
        $products = $query->latest()->paginate(25)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['tenant_id'] = tenant_id();

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Created successfully.');
    }

    public function edit(Product $product)
    {
        abort_if($product->tenant_id !== tenant_id(), 403);
        return view('admin.products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        abort_if($product->tenant_id !== tenant_id(), 403);
        $product->update($request->validated());

        return redirect()->route('admin.products.index')->with('success', 'Updated successfully.');
    }

    public function destroy(Product $product)
    {
        abort_if($product->tenant_id !== tenant_id(), 403);
        $product->delete();

        // AJAX-friendly
        if (request()->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Deleted successfully.');
    }
}
```

### 7.5 Request Stub (Validation)
```php
// app/Http/Requests/Admin/ProductRequest.php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Phase 7: keep simple; Phase 8 RBAC hook can be added
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
```

### 7.6 Routes Stub (Admin prefix)
```php
// routes/admin.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;

Route::middleware(['web', 'auth', 'tenant.selected'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('products', ProductController::class);
    });
```

### 7.7 Views Stub (Index + Create/Edit)

> **Layer A rule:** generator output ต้องเป็น plain Bootstrap markup ก่อน (ไม่พึ่ง `<x-limitless::...>`)
> - Layer B ค่อย migrate ไปใช้ component library
> - Layer C ค่อยเพิ่ม DataTables pack

**Index (plain table; DataTables is Layer C optional):**
```blade
{{-- resources/views/admin/products/index.blade.php --}}
@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6 class="mb-0">Products</h6>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add</a>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="productsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th class="text-center" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr data-id="{{ $product->id }}">
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-primary" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                        <a class="btn btn-sm btn-danger js-delete" href="#">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $(document).on('click', '.js-delete', function(e) {
        e.preventDefault();
        if (!confirm('Delete this item?')) return;

        const id = $(this).closest('tr').data('id');

        $.ajax({
            url: '/admin/products/' + id,
            type: 'DELETE',
            headers: { 'Accept': 'application/json' },
            success: function() { location.reload(); },
            error: function(xhr) { alert(xhr.responseJSON?.message || 'Error'); }
        });
    });
});
</script>
@endpush
```

**Create/Edit (generated from fields):**
```blade
{{-- modules/Content/resources/views/admin/products/create.blade.php --}}
@extends('themes.limitless.layouts.app')

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0">Create Product</h6></div>
    <div class="card-body">
    <form method="POST" action="{{ route('admin.products.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="name">Name</label>
            <input class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="price">Price</label>
            <input class="form-control" id="price" name="price" type="number" value="{{ old('price') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="is_active">Active</label>
            <select class="form-select" id="is_active" name="is_active">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <button class="btn btn-primary" type="submit">Save</button>
        <a class="btn btn-link" href="{{ route('admin.products.index') }}">Cancel</a>
    </form>
</div>
</div>
@endsection
```

### 7.8 Permissions + Menu Auto-Register (Integrate existing modules)

**Permissions naming convention:**
- `neonex.{resource}.view|create|edit|delete`

**Implementation notes (align with current RBAC model):**
- ใช้ model/service ของระบบ RBAC ที่คุณ implement (เช่น `Permission::firstOrCreate(...)`)
- เก็บเป็น global permission (`tenant_id = null`) เพื่อ reuse ทุก tenant

**Menu integration:**
- เพิ่ม menu item ผ่าน model/service ของระบบเมนู (เช่น `MenuItem::create(...)`) แบบ `type=route`
- `route_name`: `admin.{kebabs}.index`
- `permission`: `neonex.{kebab}.view`

### 7.9 Keep It Small (Performance Rules)
1. **No global DataTables assets**: โหลดเฉพาะหน้า index ที่ต้องใช้
2. Generated views ใช้ Bootstrap/theme classes เท่านั้น (ไม่สร้าง css ใหม่)
3. JS เป็น jQuery แบบสั้นๆ (event delegation)
4. ไม่มี Vue/React/Livewire code ใน generator output

---

**Exit criteria (Phase 7):**
- [ ] Default generator output is Blade + jQuery (no npm build)
- [ ] Generated CRUD runs immediately with tenant scoping
- [ ] Permission + menu integration hooks are generated (minimal)

### Phase 7 Output
- [ ] `php artisan neonex:make:crud Product --stack=blade` สร้าง CRUD ที่รันได้ทันที
- [ ] เปิด `/admin/products` ได้โดยไม่ต้อง `npm build`
- [ ] Create/Edit/Delete ทำงานได้
- [ ] Tenant isolation ทำงาน (เห็นข้อมูลเฉพาะ tenant)
- [ ] Permission + Menu ถูกสร้างให้อัตโนมัติ

---

## [Layer B] [Module] Phase 8: Menu Builder (Blade + jQuery, No npm build) (10-14 hours)

### 8.0 Layer B Kickoff (Template Integration Gate)

**Phase 8.0 = จุดเริ่ม Layer B:** ให้ “สวม template” และทำ component library + migrate harness pages ให้เรียบร้อยก่อน แล้วค่อยเดินฟีเจอร์เมนู

- ทำให้ `<x-limitless::...>` component library “ใช้งานจริงได้” (card/modal/form ขั้นต่ำ)
- ย้ายหน้า harness หลัก 3–5 หน้า (เช่น `/dashboard`, `/users`, `/settings`) ไปใช้ component library
- ยืนยันกติกา per-page assets และ action router ทำงานเหมือนเดิม

### Objective
ทำระบบจัดการเมนูให้:
- Render เมนูจริงใน theme (sidebar/header/footer) แบบ tenant-aware
- จัดการได้ใน Admin (CRUD + reorder + nested)
- ไม่ใช้ Inertia/Vue/PrimeVue (แทนที่ด้วย Blade + jQuery)

> Phase 8 นี้เป็น “การทำ Menu module แบบ Blade SSR” และ “ทำ partial render เมนูให้ theme ใช้จริง” โดยยึด Master Menu เป็น default

### In scope
- [ ] Theme renders menu tree from DB (tenant-aware)
- [ ] Admin builder UI in Blade (CRUD + reorder minimal)
- [ ] Reorder with minimal vendor (or button up/down)

### Out of scope
- [ ] Complex permission rule editor per item (beyond existing role constraints)
- [ ] Multi-menu placement engine with conditions/rules DSL
- [ ] Full drag-drop page layout designer

### 8.1 Data Source Policy (Keep Small)
ให้ใช้ **Master Menu เป็น default** เพราะรองรับ role และ field แบบ translatable JSON อยู่แล้ว

- Groups: `master_group_menu`
- Items: `master_menu` (`type=link|module|seperator`, nested ด้วย `parents`, เรียงด้วย `sortid`, จำกัดด้วย `role[]`)

### 8.2 Theme Integration: Dynamic Sidebar

**Sidebar calls service**
```blade
{{-- resources/themes/<theme>/layouts/components/sidebar.blade.php --}}
@php
    $menuTree = app(\App\Contracts\Menu\MenuServiceInterface::class)->getMasterMenu('sidebar');
@endphp

<ul class="nav nav-sidebar" data-nav-type="accordion">
    @include('menu::partials.sidebar-tree', ['items' => $menuTree])
</ul>
```

**Recursive partial**
```blade
{{-- modules/Menu/resources/views/partials/sidebar-tree.blade.php (example location) --}}
@foreach($items as $item)
    @if(($item['type'] ?? null) === 'divider')
        <li class="nav-item-header">
            <div class="text-uppercase fs-sm lh-sm opacity-50">{{ $item['title'] ?? '' }}</div>
        </li>
        @continue
    @endif

    @php
        $children = $item['children'] ?? [];
        $hasChildren = !empty($children);
        $url = '#';
        if (($item['type'] ?? null) === 'url' && !empty($item['url'])) $url = $item['url'];
        if (($item['type'] ?? null) === 'route' && !empty($item['route_name'])) {
            try { $url = route($item['route_name']); } catch (\Throwable) { $url = '#'; }
        }
    @endphp

    <li class="nav-item {{ $hasChildren ? 'nav-item-submenu' : '' }}">
        <a class="nav-link" href="{{ $url }}">
            @if(!empty($item['icon'])) <i class="{{ $item['icon'] }}"></i> @endif
            <span>{{ $item['title'] ?? '' }}</span>
        </a>

        @if($hasChildren)
            <ul class="nav-group-sub collapse">
                @include('menu::partials.sidebar-tree', ['items' => $children])
            </ul>
        @endif
    </li>
@endforeach
```

### 8.3 Admin Builder UI (Blade)
**Route:** `/admin/menus` (ตั้งชื่อแนะนำ: `menu.index`)

**Controller behavior (Phase 8):**
- ใช้ Blade SSR: `return view('menu::builder.index', ...)`
- ห้ามใช้ Inertia/Vue ใน flow นี้
- Endpoints แนะนำ:
    - Groups: `menu.master.groups.*`
    - Items: `menu.master.items.*`

**Minimal UI layout:**
- ซ้าย: list groups + create/edit/delete
- กลาง: list items ของ group (nested)
- ขวา: form create/edit item

### 8.4 Reorder (Nested) Without Build
โหลดเฉพาะหน้า builder เท่านั้น (per-page assets) แล้ว POST ไป `menu.master.items.reorder`

Option A: **SortableJS** (vanilla, small, no build)
```html
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
```

Option B: **No extra vendor** (ปุ่มขึ้น/ลง + ย้าย parent) ใช้ `updateMasterItem` ด้วย `insert_before_id/insert_after_id`

**Exit criteria (Phase 8):**
- [ ] Theme renders sidebar menu from DB (tenant-aware)
- [ ] Admin menu builder is Blade SSR (no Inertia)
- [ ] Reorder persists and cache invalidation works

### Phase 8 Output
- [ ] Sidebar render จาก DB ได้ (tenant-aware)
- [ ] Admin `/admin/menus` เป็น Blade UI
- [ ] เพิ่ม/แก้ไข/ลบ item และ reorder ได้
- [ ] Cache ถูก clear เมื่อแก้ไขเมนู

---

## [Layer B] [Module] Phase 9: Media Manager (Uploads + Library) (12-16 hours)

### Objective
ทำ Media Library แบบ “พอใช้จริง” สำหรับ Admin:
- Upload รูป/ไฟล์
- Browse + Search + Pagination
- Copy URL/Path เพื่อเอาไปใช้ใน Page Builder/Email Templates
- สร้าง thumbnail สำหรับรูป (optional) ด้วย `intervention/image`

### In scope
- [ ] Upload endpoint + DB record (tenant_id scoped)
- [ ] Browse/search/pagination UI (SSR + small jQuery)
- [ ] Copy URL button + basic preview

### Out of scope
- [ ] Video transcoding, document OCR, CDN pipeline
- [ ] Fine-grained folder permissions + sharing
- [ ] Antivirus scanning pipeline

### 9.1 Module Skeleton
```
modules/Media/
├── Models/MediaFile.php
├── Http/Controllers/Admin/MediaController.php
├── database/migrations/
├── routes/admin.php
└── resources/views/admin/media/
    ├── index.blade.php
    └── _upload_form.blade.php
```

### 9.2 Minimal Table Design
```php
Schema::create('media_files', function (Blueprint $table) {
    $table->id();
    $table->uuid('tenant_id')->index();
    $table->string('disk', 50)->default('public');
    $table->string('path', 500);
    $table->string('filename', 255);
    $table->string('mime', 100)->nullable();
    $table->unsignedBigInteger('size')->default(0);
    $table->unsignedInteger('width')->nullable();
    $table->unsignedInteger('height')->nullable();
    $table->json('meta')->nullable();
    $table->unsignedBigInteger('created_by')->nullable();
    $table->timestamps();
    $table->index(['tenant_id', 'filename']);
});
```

### 9.3 Upload Endpoint (AJAX)
- `POST /admin/media/upload` (multipart)
- Response: `{ id, url, filename, mime, size }`

### 9.4 Browse UI (Blade + jQuery)
- ใช้ grid cards + pagination (ไม่ต้องมี JS เยอะ)
- ถ้าต้องใช้ preview modal ค่อยใช้ Bootstrap modal (มีอยู่แล้ว)

**Exit criteria (Phase 9):**
- [ ] Upload stores file + DB row scoped by tenant_id
- [ ] Browse list works with search + pagination
- [ ] Copy URL produces a usable URL/path

### Phase 9 Output
- [ ] Upload ได้ และบันทึก DB พร้อม tenant_id
- [ ] List/Search/Pagination ได้
- [ ] Copy URL ได้ (button)

---

## [Layer C] [Module] Phase 10: Page Builder (Simple) (10-14 hours)

### Objective
ทำระบบหน้าเพจแบบง่ายที่สุด:
- สร้าง/แก้ไข page
- slug routing
- publish/unpublish
- รองรับ content เป็น HTML (เริ่มจาก textarea)

### In scope
- [ ] Pages CRUD + slug routing + publish/unpublish
- [ ] Tenant-safe unique slug + public render endpoint
- [ ] Start with textarea HTML (no heavy editor)

### Out of scope
- [ ] Drag-drop block editor / component marketplace
- [ ] Versioning + approvals workflow
- [ ] Advanced SEO suite (sitemap, schema generator)

### 10.1 Module Skeleton
```
modules/Pages/
├── Models/Page.php
├── Http/Controllers/Admin/PageController.php
├── Http/Controllers/Public/PageRenderController.php
├── database/migrations/
├── routes/admin.php
├── routes/web.php
└── resources/views/
    ├── admin/pages/index.blade.php
    ├── admin/pages/form.blade.php
    └── public/page.blade.php
```

### 10.2 Minimal Data Model
```php
Schema::create('pages', function (Blueprint $table) {
    $table->id();
    $table->uuid('tenant_id')->index();
    $table->string('title', 255);
    $table->string('slug', 255)->index();
    $table->longText('content_html')->nullable();
    $table->boolean('is_published')->default(false);
    $table->json('meta')->nullable();
    $table->timestamps();
    $table->unique(['tenant_id', 'slug']);
});
```

### 10.3 Rendering Strategy (No magic)
- Public route: `/p/{slug}` (ลดชนกับ route อื่น)
- Render view: `pages::public.page`

**Exit criteria (Phase 10):**
- [ ] Admin can create/edit pages and toggle publish
- [ ] Public render route resolves by tenant + slug
- [ ] Slug uniqueness enforced per tenant

### Phase 10 Output
- [ ] CRUD pages ใน admin ได้
- [ ] เปิดหน้า public `/p/{slug}` ได้ตาม tenant

---

## [Layer C] [Module] Phase 11: Forms Builder (JSON-first, Simple) (10-14 hours)

### Objective
เริ่มจาก “JSON schema editor” เพื่อให้ทำงานได้เร็วและ vendor น้อย:
- สร้าง form definition (fields, validation, labels)
- generate public endpoint สำหรับ submit
- เก็บ submissions ใน DB

### In scope
- [ ] Form definition table + submissions table
- [ ] Admin edits JSON schema (textarea) + validate JSON
- [ ] Public submit endpoint saves payload

### Out of scope
- [ ] Visual form designer
- [ ] Multi-step forms + conditional logic builder
- [ ] Payment integrations

### 11.1 Minimal Schema Example
```json
{
  "fields": [
    {"name": "full_name", "type": "text", "label": "Full Name", "rules": "required|max:255"},
    {"name": "email", "type": "email", "label": "Email", "rules": "required|email"},
    {"name": "message", "type": "textarea", "label": "Message", "rules": "required"}
  ]
}
```

### 11.2 Tables
- `forms` (tenant_id, name, slug, schema_json, settings)
- `form_submissions` (form_id, payload_json, user_id, ip, user_agent)

**Exit criteria (Phase 11):**
- [ ] Admin can save valid JSON schema (reject invalid JSON)
- [ ] Public submit endpoint stores a submission row
- [ ] Submissions are tenant-safe

### Phase 11 Output
- [ ] Admin แก้ schema ได้ (textarea JSON + validate)
- [ ] Public submit endpoint ทำงานและเก็บ submissions

---

## [Layer C] [Module] Phase 12: Email Templates (10-14 hours)

### Objective
ทำระบบ email template ที่ tenant ปรับได้:
- subject/body แยกตาม template key
- รองรับ variables
- ส่ง test email ได้

### In scope
- [ ] Templates table + CRUD admin UI (minimal)
- [ ] Variables substitution contract + send test email
- [ ] Use existing Laravel Mail (no SPA)

### Out of scope
- [ ] Drag-drop email builder
- [ ] Full campaign/marketing automation
- [ ] Multi-provider routing + deliverability analytics

### 12.1 Tables
`email_templates`:
- tenant_id
- key (เช่น `welcome`, `reset_password`, `invoice_paid`)
- subject
- body_html / body_text
- variables (json)
- is_active

### 12.2 Sending Service (Pattern)
```php
// Pseudo
MailTemplateService::send(
  tenantId: tenant_id(),
  key: 'welcome',
  to: $user->email,
  data: ['user' => $user]
);
```

**Exit criteria (Phase 12):**
- [ ] Admin can create/update template by key (tenant-scoped)
- [ ] Variables substitution works for a sample template
- [ ] Test send works and failures are visible

### Phase 12 Output
- [ ] Admin CRUD templates ได้
- [ ] Preview + Send test email ได้

---

### [Kernel + Modules] Phase 13-21: Advanced Features (40-56 hours)
Phase 13–21 คือการทำให้ platform “เดินได้แบบหลายแอป” ด้วย **Kernel Ops + Contracts** (L2/L4) แต่ยังคงหลัก no-build + minimal vendor

> Rule: โมดูลทุกตัวต้องเชื่อมผ่าน Kernel services/conventions (audit, notification, webhooks, permissions) เพื่อไม่ให้เกิด drift

---

### ✅ Execution Order Checklist (Phase 13–21)

> เป้าหมาย: ทำแกน “Ops-grade contracts” ก่อน แล้วค่อยต่อยอด feature ที่ consume contracts

- [ ] Phase 13: Audit & Activity (ทุก phase ต่อจากนี้จะอ้างอิง audit)
- [ ] Phase 15: Domain Events baseline (ให้โมดูล emit แบบเดียว แล้วค่อย dispatch)
- [ ] Phase 14: Webhook Dispatcher (consume events + audit)
- [ ] Phase 18: Notifications + Queue contracts (consume events + audit)
- [ ] Phase 16: Exports (อาศัย audit + permission)
- [ ] Phase 17: Search (อาศัย tenant scoping + DB indexes)
- [ ] Phase 19: I18n Dictionary (ทำก่อน Theme Manager ถ้าต้องการชื่อ theme/labels หลายภาษา)
- [ ] Phase 20: Theme Manager (consume settings + theme adapter)
- [ ] Phase 21: Backup/Restore (consume audit + scheduler/queue optional)

**Exit criteria (Phase 13–21):**
- [ ] ทุก action สำคัญมี audit event (อย่างน้อยใน Users/Menu/Media/Pages)
- [ ] มี webhook deliveries + retry และตรวจสอบ signature ได้
- [ ] มี notifications delivery log + test send
- [ ] มี export CSV และ global search endpoint ที่ tenant-safe
- [ ] i18n import/export ได้ และ theme switch (ถ้ามีหลาย theme)
- [ ] backup history + command run ได้

## [Layer C] [Kernel] Phase 13: Audit & Activity Service (8-12 hours)

### Objective
ทำให้ทุก action สำคัญ “ตรวจสอบย้อนหลังได้” และเป็นมาตรฐานเดียวทุกโมดูล (Kernel service)

### In scope
- [ ] ตาราง `audit_logs` + `activity_stream` ตาม contract
- [ ] `AuditService` + helper `audit()` เพื่อให้ทุกโมดูลเรียกได้ทันที
- [ ] Admin list page แบบง่าย (SSR + pagination) สำหรับ audit logs

### Out of scope
- [ ] UI ขั้นสูง (filter builder, export audit, realtime stream)
- [ ] Distributed tracing/observability (เป็น add-on/enterprise)
- [ ] Policy ที่ซับซ้อนระดับ field-level audit masking

### 13.1 Minimal Tables (Migration Snippet)
```php
// database/migrations/xxxx_xx_xx_xxxxxx_create_audit_activity_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('tenant_id')->nullable()->index();
            $table->unsignedBigInteger('actor_id')->nullable()->index();
            $table->string('event', 100)->index(); // users.created, menu.updated
            $table->string('subject_type', 150)->nullable();
            $table->string('subject_id', 64)->nullable();
            $table->string('correlation_id', 64)->nullable()->index();
            $table->json('context')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamps();
            $table->index(['tenant_id', 'event']);
        });

        Schema::create('activity_stream', function (Blueprint $table) {
            $table->id();
            $table->uuid('tenant_id')->nullable()->index();
            $table->unsignedBigInteger('actor_id')->nullable()->index();
            $table->string('message', 255);
            $table->string('event', 100)->nullable()->index();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }
};
```

### 13.2 Kernel Service (Implementation Snippet)
```php
// app/Services/AuditService.php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuditService
{
    public function record(string $event, array $context = [], $subject = null, ?string $correlationId = null): void
    {
        /** @var Request $request */
        $request = request();

        $tenantId = function_exists('tenant_id') ? tenant_id() : (app()->bound('tenant.id') ? app('tenant.id') : null);
        $actorId = auth()->id();

        $subjectType = $subject ? get_class($subject) : null;
        $subjectId = $subject ? (string) ($subject->getKey() ?? null) : null;

        $cid = $correlationId
            ?? $request->header('X-Correlation-Id')
            ?? (string) Str::uuid();

        DB::table('audit_logs')->insert([
            'tenant_id' => $tenantId,
            'actor_id' => $actorId,
            'event' => $event,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'correlation_id' => $cid,
            'context' => json_encode($context, JSON_UNESCAPED_UNICODE),
            'ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Optional: also push to activity stream (keep minimal message)
        if (!empty($context['message'])) {
            DB::table('activity_stream')->insert([
                'tenant_id' => $tenantId,
                'actor_id' => $actorId,
                'message' => (string) $context['message'],
                'event' => $event,
                'meta' => json_encode($context, JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
```

**Helper (optional, keeps controllers tiny):**
```php
// app/helpers.php

use App\Services\AuditService;

function audit(): AuditService
{
    return app(AuditService::class);
}
```

### 13.3 Admin UI Snippets (Blade + jQuery)

**Routes:**
```php
// routes/web.php

use App\Http\Controllers\Admin\AuditLogController;

Route::middleware(['web', 'auth', 'tenant.selected'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });
```

**Controller:**
```php
// app/Http/Controllers/Admin/AuditLogController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');

        $q = DB::table('audit_logs')->where('tenant_id', $tenantId);

        if ($event = $request->string('event')->toString()) {
            $q->where('event', $event);
        }

        $rows = $q->orderByDesc('id')->paginate(50)->withQueryString();

        return view('admin.audit-logs.index', compact('rows'));
    }
}
```

**View:**
```blade
{{-- resources/views/admin/audit-logs/index.blade.php --}}
@extends('themes.limitless.layouts.app')

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0">Audit Logs</h6></div>
    <div class="card-body">
        <form class="row g-2 mb-3" method="GET" action="{{ route('admin.audit-logs.index') }}">
            <div class="col-md-4">
                <input class="form-control" name="event" value="{{ request('event') }}" placeholder="event เช่น users.created">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" type="submit">Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Time</th>
                        <th>Actor</th>
                        <th>Event</th>
                        <th>Subject</th>
                        <th>Correlation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->created_at }}</td>
                        <td>{{ $r->actor_id }}</td>
                        <td><code>{{ $r->event }}</code></td>
                        <td>{{ $r->subject_type }}#{{ $r->subject_id }}</td>
                        <td><code>{{ $r->correlation_id }}</code></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $rows->links() }}</div>
    </div>
</div>
@endsection
```

### 13.4 Usage Convention (Controller snippet)
```php
// Example usage inside any controller action
audit()->record('users.created', [
    'message' => 'Created user',
    'email' => $user->email,
], subject: $user);
```

**Exit criteria (Phase 13):**
- [ ] At least one module action records an audit row
- [ ] Admin audit list renders with pagination
- [ ] Correlation id is present/usable (even if basic)

### Phase 13 Output
- [ ] มี `audit_logs` + admin list page
- [ ] ทุกโมดูลหลักเริ่มเรียก `audit()->record()` ได้

---

## [Layer C] [Kernel] Phase 14: Webhook Dispatcher (8-10 hours)

### Objective
ทำ “การส่งออก” ไปภายนอกแบบมาตรฐานเดียว: signing, retry, delivery log (Kernel service)

### In scope
- [ ] ตาราง endpoints + deliveries และบันทึก delivery log ทุกครั้ง
- [ ] HMAC signature header + correlation id + timeout
- [ ] Admin CRUD endpoints + deliveries list + manual retry (ขั้นต่ำ)

### Out of scope
- [ ] Queue worker เต็มรูปแบบ/parallelism สูง/partitioning
- [ ] Advanced webhook features (event versioning, per-endpoint transforms, DLQ)
- [ ] UI analytics/reporting สำหรับ webhook (charts, KPIs)

### 14.1 Tables (Migration Snippet)
```php
// database/migrations/xxxx_xx_xx_xxxxxx_create_webhooks_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('webhook_endpoints', function (Blueprint $table) {
            $table->id();
            $table->uuid('tenant_id')->index();
            $table->string('name', 100);
            $table->string('url', 500);
            $table->string('secret', 255)->nullable();
            $table->json('events')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['tenant_id', 'is_active']);
        });

        Schema::create('webhook_deliveries', function (Blueprint $table) {
            $table->id();
            $table->uuid('tenant_id')->index();
            $table->foreignId('endpoint_id')->constrained('webhook_endpoints')->cascadeOnDelete();
            $table->string('event', 100)->index();
            $table->string('correlation_id', 64)->nullable()->index();
            $table->unsignedSmallInteger('attempt')->default(0);
            $table->unsignedSmallInteger('status_code')->nullable();
            $table->text('error')->nullable();
            $table->timestamp('next_retry_at')->nullable()->index();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }
};
```

### 14.2 Dispatcher Service (Signing + Delivery Log)
```php
// app/Services/WebhookDispatcher.php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WebhookDispatcher
{
    public function dispatch(string $event, array $payload, ?string $correlationId = null): void
    {
        $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');

        $cid = $correlationId
            ?? request()->header('X-Correlation-Id')
            ?? (string) Str::uuid();

        $endpoints = DB::table('webhook_endpoints')
            ->where('tenant_id', $tenantId)
            ->where('is_active', 1)
            ->get();

        foreach ($endpoints as $ep) {
            $events = $ep->events ? json_decode($ep->events, true) : [];
            if (!empty($events) && !in_array($event, $events, true)) {
                continue;
            }

            $deliveryId = DB::table('webhook_deliveries')->insertGetId([
                'tenant_id' => $tenantId,
                'endpoint_id' => $ep->id,
                'event' => $event,
                'correlation_id' => $cid,
                'attempt' => 0,
                'payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Minimal: deliver sync (Phase 18 can move to queue job)
            $this->deliverNow($deliveryId);
        }
    }

    public function deliverNow(int $deliveryId): void
    {
        $delivery = DB::table('webhook_deliveries')->where('id', $deliveryId)->first();
        $endpoint = DB::table('webhook_endpoints')->where('id', $delivery->endpoint_id)->first();

        $body = json_encode(json_decode($delivery->payload ?? '[]', true), JSON_UNESCAPED_UNICODE);
        $signature = $endpoint->secret ? hash_hmac('sha256', $body, $endpoint->secret) : null;

        try {
            $res = Http::timeout(10)
                ->withHeaders(array_filter([
                    'Content-Type' => 'application/json',
                    'X-Neonex-Event' => $delivery->event,
                    'X-Correlation-Id' => $delivery->correlation_id,
                    'X-Neonex-Signature' => $signature,
                ]))
                ->post($endpoint->url, json_decode($body, true));

            DB::table('webhook_deliveries')->where('id', $deliveryId)->update([
                'attempt' => (int) $delivery->attempt + 1,
                'status_code' => $res->status(),
                'error' => $res->successful() ? null : substr((string) $res->body(), 0, 2000),
                'updated_at' => now(),
            ]);

            audit()->record('webhooks.delivered', [
                'endpoint_id' => $endpoint->id,
                'event' => $delivery->event,
                'status' => $res->status(),
            ]);
        } catch (\Throwable $e) {
            $next = now()->addMinutes(min(60, (int) pow(2, (int) $delivery->attempt)));
            DB::table('webhook_deliveries')->where('id', $deliveryId)->update([
                'attempt' => (int) $delivery->attempt + 1,
                'status_code' => null,
                'error' => substr($e->getMessage(), 0, 2000),
                'next_retry_at' => $next,
                'updated_at' => now(),
            ]);

            audit()->record('webhooks.failed', [
                'endpoint_id' => $endpoint->id,
                'event' => $delivery->event,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
```

### 14.3 Admin UI Snippets (Endpoints + Deliveries)

**Routes:**
```php
use App\Http\Controllers\Admin\WebhookEndpointController;
use App\Http\Controllers\Admin\WebhookDeliveryController;

Route::middleware(['web', 'auth', 'tenant.selected'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('webhooks', [WebhookEndpointController::class, 'index'])->name('webhooks.index');
    Route::get('webhooks/create', [WebhookEndpointController::class, 'create'])->name('webhooks.create');
    Route::post('webhooks', [WebhookEndpointController::class, 'store'])->name('webhooks.store');
    Route::get('webhooks/{id}/edit', [WebhookEndpointController::class, 'edit'])->name('webhooks.edit');
    Route::put('webhooks/{id}', [WebhookEndpointController::class, 'update'])->name('webhooks.update');
    Route::delete('webhooks/{id}', [WebhookEndpointController::class, 'destroy'])->name('webhooks.destroy');

    Route::get('webhook-deliveries', [WebhookDeliveryController::class, 'index'])->name('webhook-deliveries.index');
    Route::post('webhook-deliveries/{id}/retry', [WebhookDeliveryController::class, 'retry'])->name('webhook-deliveries.retry');
});
```

**WebhookEndpointController (minimal CRUD):**
```php
// app/Http/Controllers/Admin/WebhookEndpointController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebhookEndpointController extends Controller
{
    public function index()
    {
        $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
        $rows = DB::table('webhook_endpoints')->where('tenant_id', $tenantId)->orderByDesc('id')->paginate(50);
        return view('admin.webhooks.index', compact('rows'));
    }

    public function create()
    {
        return view('admin.webhooks.create');
    }

    public function store(Request $request)
    {
        $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'url' => ['required','url','max:500'],
            'secret' => ['nullable','string','max:255'],
            'events' => ['nullable','string'], // comma separated, minimal
            'is_active' => ['nullable','boolean'],
        ]);

        $events = array_values(array_filter(array_map('trim', explode(',', (string) ($data['events'] ?? '')))));

        DB::table('webhook_endpoints')->insert([
            'tenant_id' => $tenantId,
            'name' => $data['name'],
            'url' => $data['url'],
            'secret' => $data['secret'] ?? null,
            'events' => json_encode($events, JSON_UNESCAPED_UNICODE),
            'is_active' => (int) ($data['is_active'] ?? 1),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        audit()->record('webhooks.endpoint.created', ['name' => $data['name'], 'url' => $data['url']]);

        return redirect()->route('admin.webhooks.index');
    }

    public function edit(int $id)
    {
        $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
        $row = DB::table('webhook_endpoints')->where('tenant_id', $tenantId)->where('id', $id)->first();
        abort_if(!$row, 404);
        return view('admin.webhooks.edit', compact('row'));
    }

    public function update(Request $request, int $id)
    {
        $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
        $row = DB::table('webhook_endpoints')->where('tenant_id', $tenantId)->where('id', $id)->first();
        abort_if(!$row, 404);

        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'url' => ['required','url','max:500'],
            'secret' => ['nullable','string','max:255'],
            'events' => ['nullable','string'],
            'is_active' => ['nullable','boolean'],
        ]);

        $events = array_values(array_filter(array_map('trim', explode(',', (string) ($data['events'] ?? '')))));

        DB::table('webhook_endpoints')->where('id', $id)->update([
            'name' => $data['name'],
            'url' => $data['url'],
            'secret' => $data['secret'] ?? null,
            'events' => json_encode($events, JSON_UNESCAPED_UNICODE),
            'is_active' => (int) ($data['is_active'] ?? 1),
            'updated_at' => now(),
        ]);

        audit()->record('webhooks.endpoint.updated', ['id' => $id, 'name' => $data['name']]);
        return redirect()->route('admin.webhooks.index');
    }

    public function destroy(int $id)
    {
        $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
        DB::table('webhook_endpoints')->where('tenant_id', $tenantId)->where('id', $id)->delete();
        audit()->record('webhooks.endpoint.deleted', ['id' => $id]);
        return response()->json(['ok' => true]);
    }
}
```

**WebhookDeliveryController (list + retry):**
```php
// app/Http/Controllers/Admin/WebhookDeliveryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WebhookDeliveryController extends Controller
{
    public function index()
    {
        $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
        $rows = DB::table('webhook_deliveries')->where('tenant_id', $tenantId)->orderByDesc('id')->paginate(50);
        return view('admin.webhook-deliveries.index', compact('rows'));
    }

    public function retry(int $id)
    {
        $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
        $row = DB::table('webhook_deliveries')->where('tenant_id', $tenantId)->where('id', $id)->first();
        abort_if(!$row, 404);

        // Minimal: immediate retry
        app(\App\Services\WebhookDispatcher::class)->deliverNow($id);

        return response()->json(['ok' => true]);
    }
}
```

**Retry action (jQuery router style):**
```blade
{{-- inside deliveries table row --}}
<button class="btn btn-sm btn-primary" data-action="webhook.delivery.retry" data-id="{{ $r->id }}">Retry</button>

@push('scripts')
<script>
$(document).on('click', '[data-action="webhook.delivery.retry"]', function(e){
  e.preventDefault();
  const id = $(this).data('id');
  $.post('/admin/webhook-deliveries/' + id + '/retry', {_token: '{{ csrf_token() }}'})
    .done(() => location.reload())
    .fail(xhr => alert(xhr.responseJSON?.message || 'Error'));
});
</script>
@endpush
```

**Exit criteria (Phase 14):**
- [ ] Endpoint CRUD exists and is tenant-scoped
- [ ] Deliveries are logged per attempt (success/fail)
- [ ] Signature header is generated and retry works

### Phase 14 Output
- [ ] มี endpoint CRUD + deliveries list
- [ ] ส่ง webhook ได้ พร้อม signature + retry log

---

## [Layer C] [Kernel + Modules] Phase 15: API Baseline + Domain Events (6-8 hours)

### Objective
วาง “สัญญา API” และ domain events เพื่อให้ modules/apps เชื่อมกับ webhooks/audit ได้แบบเดียวกัน

### In scope
- [ ] Response convention ขั้นต่ำ `{ ok, data, message }`
- [ ] Event naming + จุด emit หลัก (create/update/delete/important state changes)
- [ ] `DomainEventBus` + helper `events_bus()` เป็นรางกลาง (audit → webhook → notification)

### Out of scope
- [ ] ทำระบบ API auth แบบใหญ่ (OAuth2, API keys management UI)
- [ ] API versioning เต็มรูปแบบ + OpenAPI generator
- [ ] เปลี่ยน admin UI ให้เป็น SPA (ขัดกับ no-build)

### 15.1 API Conventions
- Admin UI ใช้ SSR/Blade เป็นหลัก
- API เป็น optional/รอง: ใช้สำหรับ integrations/webhooks/test tools

**Response convention (minimal):**
```json
{ "ok": true, "data": {}, "message": "" }
```

### 15.2 Domain Events (Contract)
- Event names ใช้ชุดเดียวกับ audit/webhooks
- เมื่อเกิด event สำคัญ: `audit` ก่อน → แล้ว `webhook dispatch` ตาม subscription

### 15.3 Domain Event Helper (Snippets)

> แนวคิด: โมดูล emit event ผ่าน Kernel helper เดียว เพื่อให้ audit/webhooks/notifications ทำงานแบบเดียวกัน

```php
// app/Services/DomainEventBus.php

namespace App\Services;

class DomainEventBus
{
    public function emit(string $event, array $payload = [], $subject = null): void
    {
        audit()->record($event, $payload, subject: $subject);

        // Webhooks is optional; if service exists, dispatch
        if (app()->bound(\App\Services\WebhookDispatcher::class)) {
            app(\App\Services\WebhookDispatcher::class)->dispatch($event, $payload);
        }

        // Notifications hook comes in Phase 18
        if (app()->bound(\App\Services\NotificationService::class)) {
            app(\App\Services\NotificationService::class)->notifyFromEvent($event, $payload);
        }
    }
}
```

```php
// app/helpers.php

use App\Services\DomainEventBus;

function events_bus(): DomainEventBus
{
    return app(DomainEventBus::class);
}
```

**Usage in any module:**
```php
events_bus()->emit('users.created', ['user_id' => $user->id, 'email' => $user->email], subject: $user);
```

**Exit criteria (Phase 15):**
- [ ] `events_bus()->emit()` works from at least one module action
- [ ] Fan-out contract exists (audit → webhook → notification hook)
- [ ] API response convention is documented and used where applicable

### Phase 15 Output
- [ ] เอกสาร event list (ขั้นต่ำ) + จุดที่ต้อง emit
- [ ] API endpoints ตัวอย่าง 1–2 จุดเพื่อทดสอบ (ไม่ทำให้เป็น SPA)

---

## [Layer C] [Kernel + Modules] Phase 16: Exports (CSV/XLSX optional) (6-8 hours)

### Objective
ทำ export ให้ทุกโมดูลใช้ pattern เดียว (tenant-safe, permission-guarded)

### In scope
- [ ] Streamed CSV export pattern (ไม่กิน RAM)
- [ ] Audit event `exports.generated`
- [ ] ตัวอย่าง export อย่างน้อย 1 จุด (เช่น users)

### Out of scope
- [ ] XLSX/complex formatting/report builder (ทำเพิ่มเมื่อจำเป็น)
- [ ] Background export + notify when done (จะโยง Phase 18/queue)
- [ ] RBAC matrix แบบละเอียดสำหรับทุก export ชนิด

### 16.1 Minimal Export Pattern (CSV, no heavy vendor)
- ใช้ streamed response
- ใส่ audit `exports.generated`

### 16.2 Export Controller Snippet (Streamed CSV)
```php
// app/Http/Controllers/Admin/UserExportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserExportController extends Controller
{
    public function exportCsv(): StreamedResponse
    {
        $filename = 'users_' . date('Ymd_His') . '.csv';

        audit()->record('exports.generated', ['type' => 'users', 'format' => 'csv']);

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id', 'name', 'email']);

            User::query()
                ->orderBy('id')
                ->chunk(500, function ($rows) use ($out) {
                    foreach ($rows as $u) {
                        fputcsv($out, [$u->id, $u->name, $u->email]);
                    }
                });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
```

**Route + button:**
```php
Route::get('/admin/exports/users.csv', [UserExportController::class, 'exportCsv'])
  ->middleware(['web','auth','tenant.selected'])
  ->name('admin.exports.users.csv');
```

```blade
<a class="btn btn-outline-primary" href="{{ route('admin.exports.users.csv') }}">Export CSV</a>
```

**Exit criteria (Phase 16):**
- [ ] CSV export streams (no memory spike)
- [ ] Export is tenant-safe + permission-guarded
- [ ] Audit records `exports.generated`

### Phase 16 Output
- [ ] มี helper/pattern export CSV ที่ reuse ได้
- [ ] โมดูลหลักอย่าง Users/Media export ได้อย่างน้อย 1 รายการ

---

## [Layer C] [Kernel + Modules] Phase 17: Search (Lightweight) (6-8 hours)

### Objective
ทำ search แบบเบาๆ ก่อน (ไม่ต้อง elastic) แต่รองรับ tenant isolation

### In scope
- [ ] SSR search page (querystring) + รวมผลอย่างน้อย users/pages/media
- [ ] Tenant scoping ทุก query + index ขั้นต่ำใน DB
- [ ] จำกัดผลลัพธ์/limit เพื่อ performance

### Out of scope
- [ ] Elastic/OpenSearch/Meilisearch integration
- [ ] Relevance tuning/typo tolerance/synonyms
- [ ] Global indexing pipeline + async rebuild

### 17.1 Strategy
- เริ่มจาก DB search + indexes (หรือ FULLTEXT ถ้าเหมาะ)
- Search UI เป็น SSR + querystring (ลด JS)

### 17.2 Admin Global Search Snippet (SSR + Querystring)
```php
// app/Http/Controllers/Admin/GlobalSearchController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GlobalSearchController extends Controller
{
        public function index(Request $request)
        {
                $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
                $q = trim((string) $request->get('q', ''));

                $users = [];
                $pages = [];
                $media = [];

                if ($q !== '') {
                        $users = User::query()
                                ->where('name', 'like', "%{$q}%")
                                ->orWhere('email', 'like', "%{$q}%")
                                ->limit(20)
                                ->get();

                        // If Pages/Media are modules, query via DB table names for minimal coupling
                        $pages = DB::table('pages')->where('tenant_id', $tenantId)
                                ->where('title', 'like', "%{$q}%")
                                ->limit(20)->get();

                        $media = DB::table('media_files')->where('tenant_id', $tenantId)
                                ->where('filename', 'like', "%{$q}%")
                                ->limit(20)->get();
                }

                return view('admin.search.index', compact('q', 'users', 'pages', 'media'));
        }
}
```

```blade
{{-- resources/views/admin/search/index.blade.php --}}
@extends('themes.limitless.layouts.app')

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0">Search</h6></div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.search.index') }}" class="row g-2 mb-3">
            <div class="col-md-6">
                <input class="form-control" name="q" value="{{ $q }}" placeholder="Search users/pages/media...">
            </div>
            <div class="col-md-2"><button class="btn btn-primary" type="submit">Search</button></div>
        </form>

        @if($q)
            <h6>Users</h6>
            <ul>@foreach($users as $u)<li>{{ $u->name }} ({{ $u->email }})</li>@endforeach</ul>

            <h6>Pages</h6>
            <ul>@foreach($pages as $p)<li>{{ $p->title }} ({{ $p->slug }})</li>@endforeach</ul>

            <h6>Media</h6>
            <ul>@foreach($media as $m)<li>{{ $m->filename }}</li>@endforeach</ul>
        @endif
    </div>
</div>
@endsection
```

**Route:**
```php
Route::get('/admin/search', [GlobalSearchController::class, 'index'])
    ->middleware(['web','auth','tenant.selected'])
    ->name('admin.search.index');
```

**Exit criteria (Phase 17):**
- [ ] Admin global search returns results scoped by tenant
- [ ] Results link to existing admin pages
- [ ] Query is limited/sane for performance

### Phase 17 Output
- [ ] Global search endpoint ใน admin (ค้นอย่างน้อย users/pages/media)
- [ ] ทุก query มี tenant scope

---

## [Layer C] [Kernel] Phase 18: Notifications + Queue/Scheduler Contracts (6-10 hours)

### Objective
ทำให้ notification เป็น “บริการกลาง” ที่ส่งได้หลาย channel และวางกติกา queue/scheduler ให้พร้อมต่อ scale

### In scope
- [ ] ตาราง `notification_deliveries` + admin list
- [ ] Mail-first send (sync ได้ก่อน) + test send endpoint/UI
- [ ] แนวคิด idempotency/retry เป็น contract (ยังไม่ต้องทำซับซ้อน)

### Out of scope
- [ ] Multi-channel เต็มรูปแบบ (SMS/LINE/Push) และ preference center
- [ ] Job orchestration ซับซ้อน/cron UI
- [ ] Advanced template editor (drag-drop) สำหรับ notification

### 18.1 Notification Delivery Log (Contract)
- บันทึกทุกครั้งที่ส่ง (สำเร็จ/ล้มเหลว)
- ส่งแบบ sync ได้ก่อน แต่รองรับ queue

### 18.2 Queue/Scheduler Conventions
- retry policy ต่อ job
- idempotency key ต่อ delivery (กันส่งซ้ำ)

### 18.3 Minimal Notification Delivery Log (Migration)
```php
// database/migrations/xxxx_xx_xx_xxxxxx_create_notification_deliveries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
        public function up(): void
        {
                Schema::create('notification_deliveries', function (Blueprint $table) {
                        $table->id();
                        $table->uuid('tenant_id')->nullable()->index();
                        $table->string('channel', 30)->index(); // mail, webhook, sms (future)
                        $table->string('event', 100)->nullable()->index();
                        $table->string('to', 255)->nullable();
                        $table->string('subject', 255)->nullable();
                        $table->unsignedSmallInteger('status_code')->nullable();
                        $table->string('status', 30)->default('queued')->index(); // queued|sent|failed
                        $table->string('idempotency_key', 80)->nullable()->index();
                        $table->text('error')->nullable();
                        $table->json('payload')->nullable();
                        $table->timestamps();
                });
        }
};
```

### 18.4 Notification Service (Mail-first, optional queue)
```php
// app/Services/NotificationService.php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class NotificationService
{
        public function notifyFromEvent(string $event, array $payload = []): void
        {
                // Minimal: decide routing elsewhere; here provide a single test path
        }

        public function sendMail(string $to, string $subject, string $html, ?string $event = null, array $payload = []): void
        {
                $tenantId = function_exists('tenant_id') ? tenant_id() : (app()->bound('tenant.id') ? app('tenant.id') : null);
                $key = (string) Str::uuid();

                $id = DB::table('notification_deliveries')->insertGetId([
                        'tenant_id' => $tenantId,
                        'channel' => 'mail',
                        'event' => $event,
                        'to' => $to,
                        'subject' => $subject,
                        'status' => 'queued',
                        'idempotency_key' => $key,
                        'payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
                        'created_at' => now(),
                        'updated_at' => now(),
                ]);

                try {
                        Mail::html($html, function ($m) use ($to, $subject) {
                                $m->to($to)->subject($subject);
                        });

                        DB::table('notification_deliveries')->where('id', $id)->update([
                                'status' => 'sent',
                                'status_code' => 200,
                                'updated_at' => now(),
                        ]);

                        audit()->record('notifications.sent', ['channel' => 'mail', 'to' => $to, 'subject' => $subject]);
                } catch (\Throwable $e) {
                        DB::table('notification_deliveries')->where('id', $id)->update([
                                'status' => 'failed',
                                'status_code' => null,
                                'error' => substr($e->getMessage(), 0, 2000),
                                'updated_at' => now(),
                        ]);
                        audit()->record('notifications.failed', ['channel' => 'mail', 'to' => $to, 'error' => $e->getMessage()]);
                }
        }
}
```

### 18.5 Admin Test Send + List UI (Snippets)
```php
// routes/web.php
use App\Http\Controllers\Admin\NotificationController;

Route::middleware(['web','auth','tenant.selected'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/test-email', [NotificationController::class, 'testEmail'])->name('notifications.test-email');
});
```

```php
// app/Http/Controllers/Admin/NotificationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
        public function index()
        {
                $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
                $rows = DB::table('notification_deliveries')
                        ->where('tenant_id', $tenantId)
                        ->orderByDesc('id')
                        ->paginate(50);

                return view('admin.notifications.index', compact('rows'));
        }

        public function testEmail(Request $request)
        {
                $data = $request->validate([
                        'to' => ['required', 'email'],
                ]);

                app(\App\Services\NotificationService::class)
                        ->sendMail($data['to'], 'Test Email', '<p>Test notification</p>', 'notifications.test');

                return response()->json(['ok' => true]);
        }
}
```

```blade
{{-- resources/views/admin/notifications/index.blade.php --}}
@extends('themes.limitless.layouts.app')

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0">Notifications</h6></div>
    <div class="card-body">
        <div class="row g-2 mb-3">
            <div class="col-md-4">
                <input class="form-control" id="testTo" placeholder="email to...">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" data-action="notification.test.email">Send test</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm">
                <thead><tr><th>ID</th><th>Time</th><th>Channel</th><th>To</th><th>Status</th><th>Event</th></tr></thead>
                <tbody>
                    @foreach($rows as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->created_at }}</td>
                            <td>{{ $r->channel }}</td>
                            <td>{{ $r->to }}</td>
                            <td>{{ $r->status }}</td>
                            <td>{{ $r->event }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $rows->links() }}</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click','[data-action="notification.test.email"]', function(e){
    e.preventDefault();
    $.post('{{ route('admin.notifications.test-email') }}', {
        _token: '{{ csrf_token() }}',
        to: $('#testTo').val()
    }).done(() => location.reload())
        .fail(xhr => alert(xhr.responseJSON?.message || 'Error'));
});
</script>
@endpush
```

**Exit criteria (Phase 18):**
- [ ] Notification delivery logs are recorded (success/fail)
- [ ] Admin can test-send at least one channel (email)
- [ ] Failures are visible and diagnosable from the admin list

### Phase 18 Output
- [ ] delivery log table + UI list
- [ ] send test notification ทำงาน (email/webhook อย่างน้อย 1)

---

## [Layer C] [Kernel + Modules] Phase 19: I18n Dictionary + Import/Export (6-8 hours)

### Objective
ให้ i18n เป็นบริการกลาง (ไม่ให้โมดูลทำไฟล์แปลกระจัดกระจาย)

### In scope
- [ ] ตาราง `translations` + CRUD ขั้นต่ำ + export CSV
- [ ] Tenant-aware dictionary (tenant_id scoped) + fallback rule ในระดับ concept
- [ ] Admin UI แบบง่าย + jQuery upsert

### Out of scope
- [ ] Runtime translation loader ที่แทน Laravel lang files ทั้งหมด
- [ ] Auto-translate ด้วย external provider
- [ ] Workflow อนุมัติคำแปล/translation QA pipeline

### 19.1 Dictionary Tables (Contract)
- `translations` (key, locale, value, group, tenant_id nullable)

### 19.2 Minimal Table + CRUD Snippets

**Migration:**
```php
// database/migrations/xxxx_xx_xx_xxxxxx_create_translations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->uuid('tenant_id')->nullable()->index();
            $table->string('group', 80)->default('app')->index();
            $table->string('key', 190)->index();
            $table->string('locale', 10)->index();
            $table->longText('value')->nullable();
            $table->timestamps();
            $table->unique(['tenant_id', 'group', 'key', 'locale']);
        });
    }
};
```

**Routes:**
```php
use App\Http\Controllers\Admin\TranslationController;

Route::middleware(['web','auth','tenant.selected'])->prefix('admin')->name('admin.')->group(function(){
  Route::get('translations', [TranslationController::class, 'index'])->name('translations.index');
  Route::post('translations', [TranslationController::class, 'store'])->name('translations.store');
  Route::post('translations/import', [TranslationController::class, 'import'])->name('translations.import');
  Route::get('translations/export', [TranslationController::class, 'export'])->name('translations.export');
});
```

**Controller (minimal):**
```php
// app/Http/Controllers/Admin/TranslationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
        $q = trim((string) $request->get('q', ''));
        $locale = $request->get('locale', 'en');

        $rowsQ = DB::table('translations')
            ->where('tenant_id', $tenantId)
            ->where('locale', $locale);

        if ($q !== '') {
            $rowsQ->where(function($x) use ($q){
                $x->where('key','like',"%{$q}%")->orWhere('value','like',"%{$q}%");
            });
        }

        $rows = $rowsQ->orderBy('group')->orderBy('key')->paginate(50)->withQueryString();
        return view('admin.translations.index', compact('rows','q','locale'));
    }

    public function store(Request $request)
    {
        $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
        $data = $request->validate([
            'group' => ['required','string','max:80'],
            'key' => ['required','string','max:190'],
            'locale' => ['required','string','max:10'],
            'value' => ['nullable','string'],
        ]);

        DB::table('translations')->updateOrInsert(
            ['tenant_id' => $tenantId, 'group' => $data['group'], 'key' => $data['key'], 'locale' => $data['locale']],
            ['value' => $data['value'], 'updated_at' => now(), 'created_at' => now()]
        );

        audit()->record('i18n.translation.upserted', ['group' => $data['group'], 'key' => $data['key'], 'locale' => $data['locale']]);

        return response()->json(['ok' => true]);
    }

    public function export(Request $request): StreamedResponse
    {
        $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
        $locale = $request->get('locale', 'en');

        audit()->record('i18n.exported', ['locale' => $locale]);

        return response()->streamDownload(function() use ($tenantId, $locale){
            $out = fopen('php://output', 'w');
            fputcsv($out, ['group','key','locale','value']);

            DB::table('translations')
                ->where('tenant_id', $tenantId)
                ->where('locale', $locale)
                ->orderBy('group')->orderBy('key')
                ->chunk(500, function($rows) use ($out){
                    foreach ($rows as $r) {
                        fputcsv($out, [$r->group, $r->key, $r->locale, $r->value]);
                    }
                });

            fclose($out);
        }, "translations_{$locale}.csv", ['Content-Type' => 'text/csv']);
    }

    public function import(Request $request)
    {
        // Minimal: accept CSV upload, parse rows, upsert. (Implementation detail omitted here)
        audit()->record('i18n.imported', ['note' => 'CSV import']);
        return response()->json(['ok' => true]);
    }
}
```

**View (minimal SSR + jQuery upsert):**
```blade
{{-- resources/views/admin/translations/index.blade.php --}}
@extends('themes.limitless.layouts.app')

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0">Translations</h6></div>
    <div class="card-body">
    <form class="row g-2 mb-3" method="GET" action="{{ route('admin.translations.index') }}">
        <div class="col-md-2">
            <input class="form-control" name="locale" value="{{ $locale }}" placeholder="locale เช่น en">
        </div>
        <div class="col-md-4">
            <input class="form-control" name="q" value="{{ $q }}" placeholder="search key/value">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
        <div class="col-md-4 text-end">
            <a class="btn btn-outline-primary" href="{{ route('admin.translations.export', ['locale' => $locale]) }}">Export CSV</a>
        </div>
    </form>

    <div class="row g-2 mb-3">
        <div class="col-md-2"><input class="form-control" id="tGroup" placeholder="group" value="app"></div>
        <div class="col-md-3"><input class="form-control" id="tKey" placeholder="key"></div>
        <div class="col-md-1"><input class="form-control" id="tLocale" placeholder="locale" value="{{ $locale }}"></div>
        <div class="col-md-4"><input class="form-control" id="tValue" placeholder="value"></div>
        <div class="col-md-2"><button class="btn btn-primary w-100" data-action="translation.upsert">Upsert</button></div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm">
            <thead><tr><th>Group</th><th>Key</th><th>Locale</th><th>Value</th></tr></thead>
            <tbody>
                @foreach($rows as $r)
                    <tr>
                        <td>{{ $r->group }}</td>
                        <td><code>{{ $r->key }}</code></td>
                        <td>{{ $r->locale }}</td>
                        <td>{{ $r->value }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $rows->links() }}</div>
    </div>
</div>

    <div class="mt-3">{{ $rows->links() }}</div>
</x-limitless::card>
@endsection

@push('scripts')
<script>
$(document).on('click','[data-action="translation.upsert"]', function(e){
    e.preventDefault();
    $.post('{{ route('admin.translations.store') }}', {
        _token: '{{ csrf_token() }}',
        group: $('#tGroup').val(),
        key: $('#tKey').val(),
        locale: $('#tLocale').val(),
        value: $('#tValue').val(),
    }).done(() => location.reload())
        .fail(xhr => alert(xhr.responseJSON?.message || 'Error'));
});
</script>
@endpush
```

**Exit criteria (Phase 19):**
- [ ] Admin can upsert a translation key per locale (tenant-aware)
- [ ] Export works (CSV/JSON) and produces usable file
- [ ] Fallback behavior is documented and predictable

### Phase 19 Output
- [ ] Admin CRUD + import/export (CSV/JSON) ได้
- [ ] fallback rule ชัด

---

## [Layer C] [Kernel + App] Phase 20: Theme Manager (6-8 hours)

### Objective
ทำให้ “สลับ theme” เป็นเรื่อง config/app layer โดยไม่กระทบ module logic

### In scope
- [ ] ตั้งค่า theme ผ่าน settings key `theme.active`
- [ ] Admin UI เลือก theme + save (SSR + jQuery)
- [ ] เพิ่ม `SettingService::set()` แบบ minimal (updateOrInsert + cache forget)

### Out of scope
- [ ] Theme marketplace/installer/download (อย่าทำใน core; ให้ทำเป็น optional tooling ภายหลังถ้าจำเป็น)
- [ ] Multi-theme per page/AB testing
- [ ] Theme customization UI ขั้นสูง (color builder, layout designer)

### 20.1 Minimal UI
- เลือก theme จาก list (Limitless, AdminLTE4 future)
- Save เป็น setting (`theme.active`) แบบ tenant/app scope

### 20.2 Admin Theme Switch Snippets

**Policy:** theme ถูกเลือกผ่าน settings key เดียว: `theme.active`

**Route + Controller:**
```php
// routes/web.php
use App\Http\Controllers\Admin\ThemeManagerController;

Route::middleware(['web','auth','tenant.selected'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('theme', [ThemeManagerController::class, 'index'])->name('theme.index');
    Route::post('theme', [ThemeManagerController::class, 'update'])->name('theme.update');
});
```

```php
// app/Http/Controllers/Admin/ThemeManagerController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThemeManagerController extends Controller
{
        public function index()
        {
                $themes = config('theme.available', ['limitless']);
                $active = app(\App\Services\SettingService::class)->get('app', 'theme.active', config('theme.default', 'limitless'));
                return view('admin.theme.index', compact('themes','active'));
        }

        public function update(Request $request)
        {
                $data = $request->validate(['theme' => ['required','string']]);
            // If SettingService::set() does not exist yet, implement it using updateOrInsert (same table as Phase 4)
            app(\App\Services\SettingService::class)->set('app', 'theme.active', $data['theme']);
                audit()->record('theme.changed', ['theme' => $data['theme']]);
                return response()->json(['ok' => true]);
        }
}
```

    **Add `set()` to SettingService (so Theme Manager is copy/paste-ready):**
    ```php
    // app/Services/SettingService.php

    use Illuminate\Support\Facades\DB;

    public function set(string $group, string $key, $value): void
    {
        $tenantId = app('tenant.id');

        DB::table('settings')->updateOrInsert(
            ['tenant_id' => $tenantId, 'group' => $group, 'key' => $key],
            ['value' => (string) $value, 'type' => 'string', 'updated_at' => now(), 'created_at' => now()]
        );

        cache()->forget("settings:{$tenantId}:{$group}:{$key}");
    }
    ```

**View:**
```blade
{{-- resources/views/admin/theme/index.blade.php --}}
@extends('themes.limitless.layouts.app')

@section('content')
<x-limitless::card title="Theme Manager">
    <div class="row g-2">
        <div class="col-md-4">
            <select class="form-select" id="themeSelect">
                @foreach($themes as $t)
                    <option value="{{ $t }}" @selected($t === $active)>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" data-action="theme.save">Save</button>
        </div>
    </div>
</x-limitless::card>
@endsection

@push('scripts')
<script>
$(document).on('click','[data-action="theme.save"]', function(e){
    e.preventDefault();
    $.post('{{ route('admin.theme.update') }}', {
        _token: '{{ csrf_token() }}',
        theme: $('#themeSelect').val()
    }).done(() => location.reload())
        .fail(xhr => alert(xhr.responseJSON?.message || 'Error'));
});
</script>
@endpush
```

**Exit criteria (Phase 20):**
- [ ] Admin can change active theme setting (`theme.active`)
- [ ] Theme adapter resolves assets/views based on active theme
- [ ] Modules do not hardcode theme paths

### Phase 20 Output
- [ ] เปลี่ยน theme ได้จาก admin (ถ้ามีมากกว่า 1 theme)
- [ ] ไม่มี module ไหน hardcode theme path

---

## [Layer C] [Kernel] Phase 21: Backup/Restore (Tenant-aware roadmap) (6-10 hours)

### Objective
วางระบบ backup ให้รองรับหลาย tenant และมีประวัติการทำงาน

### In scope
- [ ] ตาราง `backup_runs` + history list + trigger backup command
- [ ] Audit `backups.created` / `backups.failed`
- [ ] Restore เป็น procedure แบบ manual-first (documented)

### Out of scope
- [ ] One-click restore UI + automated validation
- [ ] Incremental backups, point-in-time recovery, cross-region replication
- [ ] Encryption key management UI / enterprise backup retention policies

### 21.1 Minimal Scope
- Backup DB + uploads (อย่างน้อย export + zip)
- Log history + audit `backups.created`
- Restore อาจเป็น manual-first (ไม่ทำ UI ซับซ้อน)

### 21.2 Minimal Backup History + Command Snippets

**Migration:**
```php
// database/migrations/xxxx_xx_xx_xxxxxx_create_backup_runs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
        public function up(): void
        {
                Schema::create('backup_runs', function (Blueprint $table) {
                        $table->id();
                        $table->uuid('tenant_id')->nullable()->index();
                        $table->string('type', 30)->default('manual')->index();
                        $table->string('status', 30)->default('running')->index(); // running|success|failed
                        $table->string('path', 500)->nullable();
                        $table->unsignedBigInteger('size')->nullable();
                        $table->text('error')->nullable();
                        $table->timestamps();
                });
        }
};
```

**Command (pseudo-real, minimal):**
```php
// app/Console/Commands/TenantBackupCommand.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantBackupCommand extends Command
{
        protected $signature = 'neonex:backup {--tenant=}';
        protected $description = 'Create a tenant-aware backup (DB + uploads minimal)';

        public function handle(): int
        {
                $tenantId = $this->option('tenant');
                $runId = DB::table('backup_runs')->insertGetId([
                        'tenant_id' => $tenantId,
                        'type' => 'manual',
                        'status' => 'running',
                        'created_at' => now(),
                        'updated_at' => now(),
                ]);

                try {
                        // Minimal placeholder: create an artifact path; real implementation can use mysqldump/pg_dump + zip
                        $path = 'backups/' . ($tenantId ?: 'global') . '_' . date('Ymd_His') . '_' . Str::random(6) . '.zip';

                        DB::table('backup_runs')->where('id', $runId)->update([
                                'status' => 'success',
                                'path' => $path,
                                'updated_at' => now(),
                        ]);

                        audit()->record('backups.created', ['path' => $path, 'tenant_id' => $tenantId]);
                        $this->info('Backup created: ' . $path);
                        return self::SUCCESS;
                } catch (\Throwable $e) {
                        DB::table('backup_runs')->where('id', $runId)->update([
                                'status' => 'failed',
                                'error' => $e->getMessage(),
                                'updated_at' => now(),
                        ]);
                        audit()->record('backups.failed', ['error' => $e->getMessage(), 'tenant_id' => $tenantId]);
                        $this->error($e->getMessage());
                        return self::FAILURE;
                }
        }
}
```

**Admin UI (trigger + list) minimal:**
```php
// routes/web.php
use App\Http\Controllers\Admin\BackupController;

Route::middleware(['web','auth','tenant.selected'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('backups/run', [BackupController::class, 'run'])->name('backups.run');
});
```

```php
// app/Http/Controllers/Admin/BackupController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
        public function index()
        {
                $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
                $rows = DB::table('backup_runs')->where('tenant_id', $tenantId)->orderByDesc('id')->paginate(50);
                return view('admin.backups.index', compact('rows'));
        }

        public function run()
        {
                $tenantId = function_exists('tenant_id') ? tenant_id() : app('tenant.id');
                Artisan::call('neonex:backup', ['--tenant' => $tenantId]);
                return response()->json(['ok' => true]);
        }
}
```

```blade
{{-- resources/views/admin/backups/index.blade.php --}}
@extends('themes.limitless.layouts.app')

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0">Backups</h6></div>
    <div class="card-body">
        <button class="btn btn-primary mb-3" data-action="backup.run">Run backup</button>

        <div class="table-responsive">
            <table class="table table-sm">
                <thead><tr><th>ID</th><th>Time</th><th>Status</th><th>Path</th><th>Error</th></tr></thead>
                <tbody>
                    @foreach($rows as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->created_at }}</td>
                            <td>{{ $r->status }}</td>
                            <td>{{ $r->path }}</td>
                            <td class="text-danger">{{ $r->error }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $rows->links() }}</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click','[data-action="backup.run"]', function(e){
    e.preventDefault();
    $.post('{{ route('admin.backups.run') }}', {_token: '{{ csrf_token() }}'})
        .done(() => location.reload())
        .fail(xhr => alert(xhr.responseJSON?.message || 'Error'));
});
</script>
@endpush
```

**Exit criteria (Phase 21):**
- [ ] Backup command can be triggered and records a run row
- [ ] Success/failure is logged in both `backup_runs` and audit
- [ ] Restore procedure is documented (manual-first)

### Phase 21 Output
- [ ] มี backup history table + command run
- [ ] มีเอกสาร restore procedure แบบชัด

**Next optional: Phase 22–27 (Scale Add-on) →** `PROJECT_REBUILD_PLAN_BOOTSTRAP_JQUERY_SCALE_ADDON.md`

### Optional Add-on Pack (Sold Separately)
- Phase 22-27 ถูกแยกไปไฟล์: `PROJECT_REBUILD_PLAN_BOOTSTRAP_JQUERY_SCALE_ADDON.md`
- ใช้สำหรับ commercial/enterprise package โดยไม่ทำให้ core plan หนักเกินไป
- เปิดใช้งานเฉพาะลูกค้าที่ต้องการ scale features

**Core Total Time (Phase 0-21): 96-128 hours (12-16 days)**

---

## 🚀 AI-Optimized Development Tips

### For Cursor/AI:

1. **Always use Bootstrap classes** (not custom CSS)
2. **Use jQuery by default** (vanilla is allowed for small helpers)
3. **Keep code simple** (single responsibility)
4. **Use components** (don't repeat HTML)
5. **Follow examples** (copy patterns from this doc)

### Code Patterns to Follow:

**Controller Pattern:**
```php
class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ]);
        
        $user = User::create($validated);
        
        return response()->json($user);
    }
}
```

**jQuery AJAX Pattern:**
```javascript
$('.delete-btn').click(function() {
    if (!confirm('Are you sure?')) return;
    
    const id = $(this).closest('tr').data('id');
    
    $.ajax({
        url: '/users/' + id,
        type: 'DELETE',
        success: function() {
            showToast('Deleted successfully!');
            location.reload();
        },
        error: function(xhr) {
            alert('Error: ' + xhr.responseJSON.message);
        }
    });
});
```

**Form Validation Pattern:**
```javascript
$('#userForm').submit(function(e) {
    e.preventDefault();
    
    const formData = $(this).serialize();
    
    $.post('{{ route("users.store") }}', formData)
        .done(function(response) {
            showToast('Saved successfully!');
            location.href = '/users';
        })
        .fail(function(xhr) {
            // Show validation errors
            const errors = xhr.responseJSON.errors;
            $.each(errors, function(field, messages) {
                $(`[name="${field}"]`)
                    .addClass('is-invalid')
                    .after(`<div class="invalid-feedback">${messages[0]}</div>`);
            });
        });
});
```

---

## 📊 Performance Optimization

### Asset Loading Strategy

**CDN First (Fast, Low Storage):**
- Bootstrap CSS/JS
- jQuery
- DataTables
- Chart.js
- Icons (Phosphor)

**Local Only (Custom):**
- Limitless theme CSS (minified)
- Limitless theme JS (minified)
- Custom app.js (minified)
- Logo, favicon, images

### Database Optimization

**Use Indexes:**
```php
$table->index('tenant_id');
$table->index('user_id');
$table->index(['tenant_id', 'user_id']);
```

**Eager Loading:**
```php
$users = User::with('roles', 'tenant')->get(); // Good
$users = User::all(); // Bad (N+1 queries)
```

### Cache Strategy

**Cache Views:**
```bash
php artisan view:cache
```

**Cache Config:**
```bash
php artisan config:cache
```

**Cache Routes:**
```bash
php artisan route:cache
```

---

## 📝 Summary

### ✅ Phase 0 Completed Means:

1. **Theme Ready** - Limitless fully integrated
2. **Layouts Ready** - Main layout + Auth layout
3. **Assets Optimized** - CDN first, local minified
4. **Helper Functions** - theme_asset(), render_assets()
5. **Shell Page Works** - Minimal UI shell verified (plain Bootstrap markup)

### 🎯 Success Criteria:

- [ ] Can create a page using `@extends('themes.limitless.layouts.app')`
- [ ] Sidebar navigation works
- [ ] Header dropdown works
- [ ] Assets load from CDN correctly
- [ ] jQuery and Bootstrap work
- [ ] No console errors

> **Layer A reminder:** ใน Phase 0 (Layer A) ให้ใช้ plain Bootstrap markup ไปก่อน
> - `<x-limitless::...>` และ DataTables pack จะเริ่มจริงใน Layer B/C ตาม gates

### 🚀 Ready for Phase 1!

Once Phase 0 is complete, we can proceed to **Phase 1: Authentication** with confidence that the UI foundation is solid and AI-friendly.

---

**Next: Phase 1 - Authentication System** →
