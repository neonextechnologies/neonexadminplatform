# NeonexCMS Enterprise Scale Add-on Plan (Phase 22-27)
## Optional Commercial Package for Core Bootstrap+jQuery Platform

---

**Document Version:** 1.1 (Scale Add-on, Kernel-first aligned)  
**Created:** February 16, 2026  
**Depends On:** `PROJECT_REBUILD_PLAN_BOOTSTRAP_JQUERY.md` (Phase 0-21 complete)  
**License Model:** Sellable optional package (not bundled in free core)  

---

## 🎯 Purpose

เอกสารนี้ครอบคลุมเฉพาะ **Phase 22-27** สำหรับลูกค้า enterprise หรือผู้ใช้ที่ต้องการ scale ระดับสูง โดยแยกจาก core platform ชัดเจน

### Why Separate File?
1. Core ฟรี/เบา/เร็ว สำหรับผู้ใช้ทั่วไป
2. Add-on เป็น feature เชิงพาณิชย์สำหรับการขาย
3. ลดความซับซ้อนในการพัฒนาและ support
4. ทำ versioning แยกได้ (`core 1.x`, `scale-addon 1.x`)

---

## 🧱 Layer Alignment (Anti-AI-Drift)

เอกสาร add-on นี้ถือว่า **Core (Phase 0–21) ทำครบแล้ว** และผ่านจุด “สวม template” มาแล้ว

- Phase 22–27 ทั้งหมดให้นับเป็น **Layer C** (Expansion/Factory/Enterprise)
- UI ใน add-on อนุญาตให้ใช้ component library ได้ เพราะเป็นช่วงหลัง integration แล้ว

### Kernel-first Rule (สำคัญ)
แม้จะเป็น Layer C แต่ทุก Phase ใน add-on นี้ต้องทำตามแนวคิดเดียวกับ core:
1) นิยาม **contracts/services/registries** ก่อน
2) ทำ data model/migrations + policy/permission registration ก่อน
3) แล้วค่อยทำ controller/routes
4) สุดท้ายค่อยทำ UI (Blade + jQuery action router)

### Prerequisites (ต้องมีจาก Core ก่อน)
- Tenant + `tenant.selected` middleware ใช้งานจริง
- RBAC แบบ registry-first (permission ไม่กระจัดกระจาย)
- Minimal audit baseline ถูกใช้ใน CRUD สำคัญแล้ว
- Action router (`data-action`) เป็นมาตรฐานเดียว
- Template integration + component library (Layer B) พร้อมใช้งานแล้ว

### Gate ที่ต้องผ่านก่อนเริ่ม Add-on
- Gate A→B และ Gate B→C (ตามเอกสาร core) ต้องผ่านแล้ว
- Phase 7 generator/harness พร้อม เพื่อสร้าง CRUD/add-on ได้โดยไม่หลุดกติกา

### Cursor Prompts
Prompts สำหรับ copy/paste ไปใช้กับ Cursor: `CURSOR_PROMPTS.md`

---

## ✅ Execution Order Checklist (Phase 22–27)

> ยึด checklist นี้มากกว่าเลข Phase ถ้าต้องทำบางส่วนแยกย่อย

1) วาง boundary + feature flags + module skeleton `modules/Scale/*`
2) สร้าง “Kernel contracts” ของ Scale add-on (licensing, domain, branding, provisioning) ให้ครบก่อน UI
3) ทำ permission registration (registry-first) + policies
4) ทำ migrations + models + tenant scoping rules
5) ทำ routes + controllers + actions (ผ่าน `data-action`)
6) ทำ UI เฉพาะที่จำเป็น พร้อม per-page assets policy
7) เพิ่ม tests/fixtures เท่าที่จำเป็นเพื่อพิสูจน์ tenant/RBAC/audit + license gating

## 📦 Package Boundary

### Included in Core (Not repeated here)
- Auth, RBAC, User Management
- CRUD/Menu/Media/Form builders
- Theme system (theme adapter + switchable themes; start minimal)
- Basic tenant + optional API layer

### Included in Scale Add-on (This file)
- Phase 22: White-Label System
- Phase 23: Domain Management
- Phase 24: App Builder & Templates
- Phase 25: License & Activation
- Phase 26: Super Admin Console
- Phase 27: Advanced Enterprise Tools

---

## 🧱 Add-on Architecture Rules

1. ต้องเป็นโมดูลแยกใน `modules/Scale/*`
2. Core ห้าม require add-on classes โดยตรง
3. ใช้ feature flag ปิด/เปิดได้ (`config/scale.php`)
4. Migration ต้องแยก namespace เพื่อถอน add-on ได้
5. API route ของ add-on ต้องอยู่ใน prefix `/enterprise/*`

### Global Conventions (ต้องเหมือน Core)
- ทุก admin route: `auth` + `tenant.selected` (ยกเว้น super-admin ที่ intentionally cross-tenant)
- ทุก CRUD สำคัญ: audit-first (`audit()->record(...)`)
- RBAC: permission ต้อง register ผ่าน registry/service กลางของ add-on (ไม่ hardcode ใน controller)
- UI: Blade SSR + jQuery event delegation ผ่าน `data-action`
- ห้ามเพิ่ม npm build/bundler ใน add-on เช่นเดียวกับ core

### File & Asset Minimization (Cursor Guardrails)
> เป้าหมาย: add-on ต้องเพิ่ม “ของจำเป็นเท่านั้น” และไม่ทำให้ core/site หนักขึ้นโดยไม่จำเป็น

- ต่อหน้า = ต่อไฟล์: JS แบบ per-page เป็นค่าเริ่มต้น และโหลดเฉพาะหน้าที่ใช้
- ห้าม copy ทั้ง template zip / demo / docs / examples เข้ามาใน add-on
- Vendor ทั่วไปใช้ CDN-first; local เฉพาะ theme/custom ที่จำเป็น
- Reuse core assets/pattern ก่อนเสมอ (อย่า duplicate vendor libs ใน add-on ถ้า core มีอยู่แล้ว)
- ทำให้ผ่าน Layer gates ก่อนค่อย trim/optimize template assets เพิ่ม

**Route naming note:** แนะนำใช้ชื่อสั้นแบบ module-friendly (ไม่จำเป็นต้องมี `admin.`) แต่ให้คงเสถียรทั้งระบบ; URL prefix `/admin` ยังเป็นกติกาหลักเหมือนเดิม

### Suggested Structure

```txt
modules/
└── Scale/
    ├── WhiteLabel/
    ├── DomainManager/
    ├── AppBuilder/
    ├── Licensing/
    ├── SuperAdmin/
    └── EnterpriseTools/
```

---

## 🧩 Module Wiring Blueprint (Copy/Paste-ready)

หัวข้อนี้ทำไว้เพื่อให้ Cursor/AI สร้างโค้ด add-on ได้ “ตามสเปค core plan (Kernel/Modules)” และไม่ drift

### 1) การเปิดใช้งานโมดูล (Modules Registry)

แนวทางหลัก (ตาม core plan) คือให้มี “module loader” ที่โหลดรายชื่อ providers จาก `config/modules.php` ดังนั้นตอนติดตั้ง add-on ให้เพิ่ม provider ของ Scale เข้าไปใน `config/modules.php` (และลบออกเมื่อถอน add-on)

> ถ้าโปรเจ็คของคุณ “ไม่ใช้ Modules registry” ให้ register providers ของ Scale ใน `config/app.php` (providers) แทน โดยยังต้องคุม boundary ว่า core ไม่อ้าง add-on โดยตรง

ตัวอย่าง (แนวทาง):

```php
// config/modules.php

'enabled' => [
    // ...core modules

    // Scale Add-on (install-time only)
    'ScaleWhiteLabel' => \Modules\Scale\WhiteLabel\Providers\WhiteLabelServiceProvider::class,
    'ScaleDomainManager' => \Modules\Scale\DomainManager\Providers\DomainManagerServiceProvider::class,
    'ScaleAppBuilder' => \Modules\Scale\AppBuilder\Providers\AppBuilderServiceProvider::class,
    'ScaleLicensing' => \Modules\Scale\Licensing\Providers\LicensingServiceProvider::class,
    'ScaleSuperAdmin' => \Modules\Scale\SuperAdmin\Providers\SuperAdminServiceProvider::class,
    'ScaleEnterpriseTools' => \Modules\Scale\EnterpriseTools\Providers\EnterpriseToolsServiceProvider::class,
],
```

> หมายเหตุ: core ไม่ควรอ้าง add-on classes โดยตรง แต่ “การเพิ่ม provider ใน config” ถือเป็นขั้นตอน install-time ของ add-on (อยู่ในขอบเขต packaging)

### 2) โครงสร้างขั้นต่ำต่อ 1 โมดูล (เหมือน modules ที่มีอยู่)

```txt
modules/Scale/WhiteLabel/
├── Providers/WhiteLabelServiceProvider.php
├── config/module.php
├── routes/web.php
├── routes/api.php
├── database/migrations/
├── Http/Controllers/
├── Contracts/
└── Services/
```

### 3) ServiceProvider Template (Generic)

ให้ทุก Scale module provider ใช้ ServiceProvider มาตรฐานของ Laravel (หรือ base provider ของโปรเจ็คคุณเองถ้ามี) และทำ 4 อย่างนี้เป็นมาตรฐาน:
1) `loadMigrationsFrom(...)`
2) `loadRoutesFrom(...)`
3) `registerPermissions(...)` ผ่าน `App\Services\RBAC\PermissionRegistrar`
4) bind contracts → services

ตัวอย่าง (copy/paste แล้วปรับชื่อโมดูล):

```php
<?php

declare(strict_types=1);

namespace Modules\Scale\WhiteLabel\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RBAC\PermissionRegistrar;

class WhiteLabelServiceProvider extends ServiceProvider
{
    protected string $modulePath = __DIR__ . '/..';

    public function register(): void
    {
        // bind contracts -> services here
        // $this->app->bind(BrandingServiceInterface::class, BrandingService::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom($this->modulePath . '/database/migrations');
        $this->loadRoutesFrom($this->modulePath . '/routes/web.php');
        $this->loadRoutesFrom($this->modulePath . '/routes/api.php');

        $this->registerPermissions();
    }

    protected function registerPermissions(): void
    {
        /** @var PermissionRegistrar $registrar */
        $registrar = $this->app->make(PermissionRegistrar::class);

        $registrar->registerPermissions([
            ['name' => 'neonex.enterprise.whitelabel.view', 'display_name' => 'View White-Label Settings', 'group' => 'enterprise'],
            ['name' => 'neonex.enterprise.whitelabel.manage', 'display_name' => 'Manage White-Label Settings', 'group' => 'enterprise'],
        ]);
    }
}
```

### 4) Routes Template (Web/Admin)

มาตรฐานของโปรเจ็คนี้: `prefix('admin')` + `tenant.selected` + ใช้ `permission:` middleware

```php
<?php

use Illuminate\Support\Facades\Route;
use Modules\Scale\WhiteLabel\Http\Controllers\WhiteLabelController;

Route::middleware(['web', 'auth', 'verified', 'tenant.selected'])
    ->prefix('admin/enterprise')
    ->group(function () {
        // ตัวอย่าง: WhiteLabel
        Route::middleware(['permission:neonex.enterprise.whitelabel.view'])->group(function () {
            Route::get('whitelabel', [WhiteLabelController::class, 'index'])->name('scale.whitelabel.index');
        });

        Route::middleware(['permission:neonex.enterprise.whitelabel.manage'])->group(function () {
            Route::post('whitelabel', [WhiteLabelController::class, 'update'])->name('scale.whitelabel.update');
            Route::post('whitelabel/assets', [WhiteLabelController::class, 'uploadAsset'])->name('scale.whitelabel.assets.upload');
        });
    });
```

### 5) Routes Template (Enterprise API Boundary)

กติกา add-on: API routes ของ add-on ต้องอยู่ใน prefix `/enterprise/*`

```php
<?php

use Illuminate\Support\Facades\Route;
use Modules\Scale\WhiteLabel\Http\Controllers\WhiteLabelApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('enterprise')
    ->group(function () {
        // ตัวอย่าง: WhiteLabel
        Route::middleware(['permission:neonex.enterprise.whitelabel.manage'])->group(function () {
            Route::post('whitelabel/settings', [WhiteLabelApiController::class, 'updateSettings'])->name('enterprise.whitelabel.settings.update');
            Route::post('whitelabel/assets', [WhiteLabelApiController::class, 'uploadAsset'])->name('enterprise.whitelabel.assets.upload');
        });
    });
```

### 6) How to persist new permissions (สำคัญ)

`PermissionRegistrar::registerPermissions(...)` จะ “เพิ่มรายการ permission ในหน่วยความจำ” ของ registrar
เพื่อให้ลง DB ให้ทำอย่างใดอย่างหนึ่ง:
1) รัน seed RBAC ของระบบหลัก (ตัวอย่าง): `php artisan db:seed --class="Database\\Seeders\\RBACSeeder"`
2) หรือใช้ RBAC UI endpoints ที่มีอยู่ (เช่น sync/initialize) ตาม policy ของโปรเจกต์

---

## 🧰 Install/Uninstall Checklist (Ops-ready)

ส่วนนี้คือ checklist สำหรับ “ติดตั้ง/ถอน” Scale Add-on แบบปลอดภัย โดยยึดกติกา package boundary: **core ต้องทำงานได้แม้ไม่มี add-on**

### Install (ครั้งแรก)

1) เปิดใช้โมดูลใน registry
    - เพิ่ม providers ของ Scale modules ใน `config/modules.php` (install-time)
2) เพิ่ม feature flags ของ add-on
    - สร้าง/เพิ่ม `config/scale.php` (เช่น `scale.enabled`, `scale.whitelabel.enabled`, `scale.domains.enabled`, ฯลฯ)
    - ค่าเริ่มต้นควรเป็น `false` เพื่อกัน “เปิดฟีเจอร์โดยไม่ตั้งใจ”
3) รัน migrations
    - `php artisan migrate`
    - ตรวจว่ามีเฉพาะ tables ของ Scale modules เท่านั้น (ไม่มีแก้ core tables โดยไม่จำเป็น)
4) Register Scale permissions (แนะนำให้ทำก่อน)
    - รัน: `php artisan db:seed --class="Modules\\Scale\\Database\\Seeders\\ScalePermissionsSeeder"`
    - เหตุผล: เพื่อให้ permissions ของ Phase 22–27 ถูก sync เข้า DB ก่อนค่อยสร้าง/assign roles
5) Sync permissions + seed roles
    - รัน RBAC seeder ของระบบหลัก (ตัวอย่าง): `php artisan db:seed --class="Database\\Seeders\\RBACSeeder"`
    - ถ้าต้องการให้ role `admin` เข้าถึง enterprise ได้อัตโนมัติ ให้เพิ่ม wildcard เช่น `neonex.enterprise.*` ใน default roles (เลือกทำตาม policy)
5) Seed enterprise menus (optional but typical)
    - รัน seeder ของ add-on (ตัวอย่าง: `Modules\\Scale\\Database\\Seeders\\ScaleEnterpriseMenuSeeder`) เพื่อให้เมนู enterprise โผล่ใน sidebar
    - Route ยังต้อง guard ด้วย RBAC permissions เสมอ (อย่า rely แค่เมนู)
6) Clear caches
    - `php artisan optimize:clear`
7) Smoke tests (ดูหัวข้อด้านล่าง)

### Upgrade (เพิ่ม Phase 23/24/25... ทีละก้อน)

1) เปิด provider/module เฉพาะก้อนที่เพิ่ม (อย่า enable ทุกอย่างถ้ายังไม่พร้อม)
2) รัน migrations ใหม่
3) sync permissions ใหม่ (seed หรือ RBAC UI)
4) รัน smoke tests เฉพาะ Phase ที่เพิ่ม

### Uninstall (ถอน add-on)

> เป้าหมาย: ถอนแล้ว core ยังทำงานได้ 100%

1) ปิด feature flags ทั้งหมดใน `config/scale.php`
2) ซ่อน/ถอด enterprise menus (ผ่าน menu registry ของ add-on; core ไม่ควร hardcode)
3) ถอด providers ของ Scale modules ออกจาก `config/modules.php`
4) Clear caches
    - `php artisan optimize:clear`
5) จัดการข้อมูล (เลือก 1 แนวทาง)
    - **Option A (แนะนำ):** เก็บ tables ไว้ (soft uninstall) เพื่อไม่ทำข้อมูลสูญหาย
    - **Option B:** ทำ rollback migrations ของ add-on เฉพาะถ้ามี tooling/plan ชัดเจนและ backup แล้ว

### Smoke Tests (ผ่านก่อนถือว่าติดตั้งสำเร็จ)

- Core admin routes เปิดได้ตามปกติ (ไม่มี error เรื่อง class/service provider)
- ปิด scale flags แล้ว enterprise pages/menus ไม่โผล่ และไม่ทำให้ core แตก
- เปิด scale flags แล้ว:
  - Phase 22: เข้า `/admin/enterprise/whitelabel` ได้ตามสิทธิ์ และ save ได้ (มี audit)
  - Phase 23: CRUD domain ทำงาน (ไม่ให้ชนกันข้าม tenant; มี audit)
  - Phase 25: licensing claims gating ทำงาน (lock/suppress ตาม policy)
- RBAC middleware `permission:` บังคับ 403 ได้จริงสำหรับทุก route ของ add-on
- ไม่มี npm build/bundler ถูกเพิ่ม (ยังคง CDN/per-page assets policy)

---

## 🧾 Example: `config/scale.php` (Feature Flags)

> ใช้เป็นตัวอย่างเพื่อ copy/paste และปรับตามแพ็ก/การขายจริงของคุณ
> ค่าเริ่มต้นควร “ปิดทั้งหมด” แล้วเปิดเป็นรายฟีเจอร์ตาม license claims

```php
<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Scale Add-on Global Switch
    |--------------------------------------------------------------------------
    */
    'enabled' => env('SCALE_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Feature Flags (per module)
    |--------------------------------------------------------------------------
    */
    'features' => [
        'whitelabel' => env('SCALE_FEATURE_WHITELABEL', false),
        'domains' => env('SCALE_FEATURE_DOMAINS', false),
        'appbuilder' => env('SCALE_FEATURE_APPBUILDER', false),
        'licensing' => env('SCALE_FEATURE_LICENSING', false),
        'superadmin' => env('SCALE_FEATURE_SUPERADMIN', false),
        'tools' => env('SCALE_FEATURE_TOOLS', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | API Boundary (must be /enterprise/*)
    |--------------------------------------------------------------------------
    */
    'enterprise_api_prefix' => 'enterprise',

    /*
    |--------------------------------------------------------------------------
    | Licensing Defaults
    |--------------------------------------------------------------------------
    */
    'licensing' => [
        // แนะนำให้เริ่ม offline-first และเปิด remote validation ทีหลัง
        'offline_first' => true,
        'remote_validation_enabled' => env('SCALE_LICENSE_REMOTE_VALIDATE', false),
        'remote_validation_url' => env('SCALE_LICENSE_REMOTE_URL'),

        // Grace period (นาที) และ policy เมื่อหมดอายุ
        'grace_minutes' => (int) env('SCALE_LICENSE_GRACE_MINUTES', 0),
        'lock_policy' => env('SCALE_LICENSE_LOCK_POLICY', 'hide'), // hide|readonly|lock
    ],

    /*
    |--------------------------------------------------------------------------
    | Domain Management
    |--------------------------------------------------------------------------
    */
    'domains' => [
        'enabled' => env('SCALE_DOMAINS_ENABLED', false),
        'verification_enabled' => env('SCALE_DOMAINS_VERIFICATION_ENABLED', true),
        'priority' => [
            'custom_domain',
            'subdomain',
            'path_fallback',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | White-label
    |--------------------------------------------------------------------------
    */
    'whitelabel' => [
        'enabled' => env('SCALE_WHITELABEL_ENABLED', false),
        // เก็บ asset ใน disk ไหน (ต้องสอดคล้องกับ filesystems.php)
        'disk' => env('SCALE_WHITELABEL_DISK', 'public'),
        // จำกัดชนิดไฟล์ (ตัวอย่าง)
        'allowed_mimes' => ['image/png', 'image/jpeg', 'image/svg+xml', 'image/x-icon'],
    ],
];
```

---

## 🧭 Enterprise Menu Seeding (Master Menu)

เป้าหมาย: ติดตั้ง add-on แล้ว “เมนู enterprise โผล่” โดยยังคุมสิทธิ์ผ่าน RBAC ใน routes และ (ถ้าต้องการ) ซ่อนเมนูด้วย role IDs ใน `master_menu.role`

### สำคัญ: Master Menu ใช้ role IDs (ไม่ใช่ permission string)
- `master_menu.role` เป็น JSON array ของ role IDs (เช่น `[1,2]`)
- Route ยังต้อง guard ด้วย `permission:neonex.enterprise.*` เสมอ (ถือเป็น source of truth)

### Example Seeder (แนวทาง)

```php
<?php

declare(strict_types=1);

namespace Modules\Scale\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\MasterGroupMenu;
use App\Models\MasterMenu;

class ScaleEnterpriseMenuSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Tenant::all() as $tenant) {
            $group = MasterGroupMenu::firstOrCreate([
                'tenant_id' => $tenant->id,
                'name' => 'sidebar',
            ], [
                'active' => 1,
                'sortid' => 0,
            ]);

            // Parent (no link) to hold children
            $enterpriseRoot = MasterMenu::firstOrCreate([
                'group' => $group->id,
                'parents' => null,
                'type' => 'link',
                'link' => null,
                'module' => null,
                'page' => null,
            ], [
                'active' => 1,
                'sortid' => 9000,
                'name' => ['en' => 'Enterprise', 'th' => 'Enterprise'],
                'icon' => 'ph-buildings',
                // 'role' => [/* admin role ids */],
            ]);

            // Children (route names)
            MasterMenu::firstOrCreate([
                'group' => $group->id,
                'parents' => $enterpriseRoot->id,
                'type' => 'link',
                'link' => 'scale.whitelabel.index',
            ], [
                'active' => 1,
                'sortid' => 9010,
                'name' => ['en' => 'White-Label', 'th' => 'White-Label'],
                'icon' => 'ph-palette',
            ]);

            MasterMenu::firstOrCreate([
                'group' => $group->id,
                'parents' => $enterpriseRoot->id,
                'type' => 'link',
                'link' => 'scale.domains.index',
            ], [
                'active' => 1,
                'sortid' => 9020,
                'name' => ['en' => 'Domains', 'th' => 'Domains'],
                'icon' => 'ph-globe',
            ]);

            MasterMenu::firstOrCreate([
                'group' => $group->id,
                'parents' => $enterpriseRoot->id,
                'type' => 'link',
                'link' => 'scale.licensing.index',
            ], [
                'active' => 1,
                'sortid' => 9030,
                'name' => ['en' => 'Licensing', 'th' => 'Licensing'],
                'icon' => 'ph-key',
            ]);
        }
    }
}
```

### Install Hook (แนะนำ)
- หลัง install + migrate + seed RBAC ให้รันเมนู seeder นี้เพิ่ม (หรือรวมไว้ใน installer ของ add-on)

---

## 🔐 Scale Permissions Pack (Registry-first)

หัวข้อนี้ทำไว้เพื่อให้ Cursor/AI “สร้าง permissions ของ add-on แบบรวมศูนย์” โดยใช้ service registrar ของระบบ RBAC (เช่น `App\\Services\\RBAC\\PermissionRegistrar`)

### Permission Groups (แนวทาง)
- `enterprise` สำหรับทุกฟีเจอร์ Phase 22–27 ที่เป็น enterprise
- `superadmin` สำหรับสิทธิ์ cross-tenant (Phase 26)

### Example Seeder: `ScalePermissionsSeeder`

```php
<?php

declare(strict_types=1);

namespace Modules\Scale\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\RBAC\PermissionRegistrar;

class ScalePermissionsSeeder extends Seeder
{
    public function __construct(
        protected PermissionRegistrar $registrar
    ) {}

    public function run(): void
    {
        $this->registrar->registerPermissions([
            // Phase 22: WhiteLabel
            ['name' => 'neonex.enterprise.whitelabel.view', 'display_name' => 'View White-Label Settings', 'group' => 'enterprise'],
            ['name' => 'neonex.enterprise.whitelabel.manage', 'display_name' => 'Manage White-Label Settings', 'group' => 'enterprise'],

            // Phase 23: Domains
            ['name' => 'neonex.enterprise.domains.view', 'display_name' => 'View Domains', 'group' => 'enterprise'],
            ['name' => 'neonex.enterprise.domains.manage', 'display_name' => 'Manage Domains', 'group' => 'enterprise'],

            // Phase 24: AppBuilder
            ['name' => 'neonex.enterprise.appbuilder.view', 'display_name' => 'View App Builder', 'group' => 'enterprise'],
            ['name' => 'neonex.enterprise.appbuilder.manage', 'display_name' => 'Manage App Builder', 'group' => 'enterprise'],

            // Phase 25: Licensing
            ['name' => 'neonex.enterprise.licensing.view', 'display_name' => 'View Licensing', 'group' => 'enterprise'],
            ['name' => 'neonex.enterprise.licensing.manage', 'display_name' => 'Manage Licensing', 'group' => 'enterprise'],

            // Phase 27: Enterprise Tools
            ['name' => 'neonex.enterprise.tools.view', 'display_name' => 'View Enterprise Tools', 'group' => 'enterprise'],
            ['name' => 'neonex.enterprise.tools.manage', 'display_name' => 'Manage Enterprise Tools', 'group' => 'enterprise'],

            // Phase 26: Super Admin (cross-tenant)
            ['name' => 'neonex.superadmin.access', 'display_name' => 'Access Super Admin Console', 'group' => 'superadmin'],
            ['name' => 'neonex.superadmin.tenants.manage', 'display_name' => 'Manage Tenants (Super Admin)', 'group' => 'superadmin'],
        ]);

        // Persist to DB
        $this->registrar->syncGlobalPermissions();
    }
}
```

### Notes
- Seeder นี้ “เพิ่มเฉพาะ permissions” และ sync เข้า DB
- การ assign เข้า roles (เช่น `admin`) ให้ตัดสินใจตาม policy (บางระบบไม่อยากให้ admin เห็น enterprise โดย default)

---

## [Layer C] 🚀 Phase 22: White-Label System (8-12h)

### Objective
เพิ่มระบบ white-label แบบ tenant-aware โดยไม่กระทบ core และปิด/เปิดได้ด้วย feature flag + license claims

### In Scope
- Per-tenant logo, favicon, brand name
- Preset/override token ของ theme (ระดับ “token/variables” ไม่ใช่ redesign)
- Branding สำหรับ footer + email templates (แบบ override เป็นชั้น)
- Gating ด้วย plan/license (ซ่อน/แสดง platform branding)

### Out of Scope
- ระบบ design editor แบบลากวาง
- ทำ theme ใหม่ทั้งชุด/ทำสีแบบ arbitrary (นอก preset)

### Outputs
- Module `modules/Scale/WhiteLabel/*`
- Contracts + Services + Migrations + UI หน้า settings

### Kernel Contracts/Services (ทำก่อน)
- `BrandingServiceInterface` (get/set branding by tenant)
- `BrandingAssetStorageInterface` (store/resolve assets)
- `BrandingPolicy`/permission registry: `neonex.enterprise.whitelabel.manage`

### RBAC Permissions (Registry-first)
- `neonex.enterprise.whitelabel.view` (เปิดหน้า settings)
- `neonex.enterprise.whitelabel.manage` (บันทึก/อัปโหลด/เปลี่ยนค่า)

### Routes (Suggested)

**Admin Web (SSR)**
- `GET /admin/enterprise/whitelabel` → `scale.whitelabel.index`
- `POST /admin/enterprise/whitelabel` → `scale.whitelabel.update`
- `POST /admin/enterprise/whitelabel/assets` → `scale.whitelabel.assets.upload`

**Enterprise API (Prefix บังคับ: `/enterprise/*`)**
- `POST /enterprise/whitelabel/assets` → `enterprise.whitelabel.assets.upload`
- `POST /enterprise/whitelabel/settings` → `enterprise.whitelabel.settings.update`

### Minimal Tables
- `tenant_branding`
- `tenant_branding_assets`

### Implementation Checklist
1) เพิ่ม `config/scale.php` + feature flag `scale.whitelabel.enabled`
2) เพิ่ม permission registry ของ add-on และ register permissions ของ Phase 22
3) ทำ migrations + models (ทุก query ต้อง scope ด้วย `tenant_id`)
4) ทำ service layer + resolver สำหรับ logo/favicon (tenant-aware)
5) ทำ settings UI (Blade) + actions (jQuery `data-action`) สำหรับ save/upload
6) เพิ่ม audit events สำหรับ update branding

### Exit Criteria
- ปิด feature flag แล้วระบบ core ทำงานเหมือนเดิม (ไม่มี coupling)
- เปิด feature flag แล้ว tenant แต่ละรายตั้งค่า logo/favicon ได้ และแสดงผลถูก tenant
- Permission `neonex.enterprise.whitelabel.manage` คุมหน้า settings ได้จริง

---

## [Layer C] 🌐 Phase 23: Domain Management (8-12h)

### Objective
เพิ่มระบบ mapping domain → tenant (custom domain/subdomain) แบบปลอดภัย ตรวจสอบได้ และมีสถานะ verification

### In Scope
- Domain CRUD (ต่อ tenant)
- Verification status + audit trail
- Tenant identification priority ตามลำดับที่กำหนด
- Job สำหรับตรวจ DNS/HTTP verification แบบ async

### Out of Scope
- ออกใบรับรอง SSL จริง (ทำได้แค่เก็บ status/placeholder)
- Reverse proxy automation

### Outputs
- Module `modules/Scale/DomainManager/*`
- Middleware/resolver extension แบบ “hook/adapter” (ไม่ hack core)

### Kernel Contracts/Services (ทำก่อน)
- `DomainResolverInterface` (resolve tenant by host)
- `DomainVerificationServiceInterface`
- Permissions: `neonex.enterprise.domains.manage`

### RBAC Permissions (Registry-first)
- `neonex.enterprise.domains.view`
- `neonex.enterprise.domains.manage`

### Routes (Suggested)

**Admin Web (SSR)**
- `GET /admin/enterprise/domains` → `scale.domains.index`
- `GET /admin/enterprise/domains/create` → `scale.domains.create`
- `POST /admin/enterprise/domains` → `scale.domains.store`
- `GET /admin/enterprise/domains/{domain}/edit` → `scale.domains.edit`
- `PUT /admin/enterprise/domains/{domain}` → `scale.domains.update`
- `DELETE /admin/enterprise/domains/{domain}` → `scale.domains.destroy`
- `POST /admin/enterprise/domains/{domain}/verify` → `scale.domains.verify`

**Enterprise API (Prefix บังคับ: `/enterprise/*`)**
- `POST /enterprise/domains` → `enterprise.domains.store`
- `POST /enterprise/domains/{domain}/verify` → `enterprise.domains.verify`

### Tenant Identification Priority
1) Custom domain
2) Subdomain
3) Path-based fallback

### Implementation Checklist
1) เพิ่ม tables: `tenant_domains` (host, tenant_id, status, verified_at, meta)
2) เพิ่ม service สำหรับ normalize host + conflict check (ห้ามชนกันข้าม tenant)
3) เพิ่ม resolver chain: custom domain → subdomain → fallback
4) เพิ่ม verification job + UI แสดงสถานะ
5) ทุก action ต้อง audit-first + RBAC ผ่าน registry

### Exit Criteria
- ใส่ domain ซ้ำข้าม tenant ไม่ได้
- Resolver คืน tenant ถูกต้องตาม priority และไม่ทำให้ core route พัง
- Verification flow มีสถานะที่ตรวจสอบย้อนหลังได้ (audit)

---

## [Layer C] 🏗️ Phase 24: App Builder & Templates (10-14h)

### Objective
เพิ่มระบบ “provisioning” สำหรับสร้าง tenant app จาก template/blueprint แบบ queue-driven พร้อม monitoring และ rollback

### In Scope
- Template registry/manager (metadata + seed plan)
- Queue-driven provisioning + status tracking
- Rollback แบบ minimal (best-effort) เมื่อ job ล้มเหลว

### Out of Scope
- UI builder แบบ drag&drop
- Orchestration ข้ามเครื่อง/ข้าม cluster

### Outputs
- Module `modules/Scale/AppBuilder/*`
- Provision workflow + monitor UI

### Kernel Contracts/Services (ทำก่อน)
- `ProvisioningServiceInterface` (start/track/cancel)
- `TemplateRegistryInterface`
- Permissions: `neonex.enterprise.appbuilder.manage`

### RBAC Permissions (Registry-first)
- `neonex.enterprise.appbuilder.view`
- `neonex.enterprise.appbuilder.manage`

### Routes (Suggested)

**Admin Web (SSR)**
- `GET /admin/enterprise/templates` → `scale.templates.index`
- `GET /admin/enterprise/templates/{template}` → `scale.templates.show`
- `POST /admin/enterprise/templates` → `scale.templates.store`
- `PUT /admin/enterprise/templates/{template}` → `scale.templates.update`
- `DELETE /admin/enterprise/templates/{template}` → `scale.templates.destroy`
- `GET /admin/enterprise/provision-runs` → `scale.provisionRuns.index`
- `GET /admin/enterprise/provision-runs/{run}` → `scale.provisionRuns.show`
- `POST /admin/enterprise/provision-runs` → `scale.provisionRuns.start`
- `POST /admin/enterprise/provision-runs/{run}/retry` → `scale.provisionRuns.retry`
- `POST /admin/enterprise/provision-runs/{run}/cancel` → `scale.provisionRuns.cancel`

**Enterprise API (Prefix บังคับ: `/enterprise/*`)**
- `POST /enterprise/provision-runs` → `enterprise.provisionRuns.start`
- `POST /enterprise/provision-runs/{run}/cancel` → `enterprise.provisionRuns.cancel`

### Implementation Checklist
1) เพิ่ม tables: `app_templates`, `provision_runs`, `provision_run_steps`
2) ทำ template registry + validation (ไม่ให้ template อ้าง add-on อื่นโดยไม่เช็ค)
3) ทำ provisioning job pipeline (step-based) + retry policy
4) ทำ monitor UI (list/detail) + actions (retry/cancel)
5) เพิ่ม audit events: start/finish/fail/rollback

### Exit Criteria
- สร้าง provisioning run ได้ 1 template end-to-end และมีสถานะครบ (pending/running/succeeded/failed)
- มี monitor UI ที่เห็น step และสามารถ retry/cancel ได้ตามสิทธิ์
- Core ยังทำงานได้โดยไม่ติด add-on

---

## [Layer C] 🔑 Phase 25: License & Activation (8-12h)

### Objective
เพิ่มระบบ license/claims สำหรับเปิดฟีเจอร์ add-on และจำกัด plan แบบตรวจสอบได้ มี grace period และ lock policy ที่ชัดเจน

### In Scope
- License key generation/validation
- Activation แบบ domain-bound
- Claims-based gating (users/storage/modules)
- Grace period + lock policy (ทำให้ predictable)

### Out of Scope
- ระบบชำระเงิน/billing จริง (ยังคง out of scope)

### Outputs
- Module `modules/Scale/Licensing/*`
- License claims service + admin activation UI

### Kernel Contracts/Services (ทำก่อน)
- `LicenseClaimsServiceInterface` (current claims for tenant)
- `LicenseValidatorInterface`
- Permissions: `neonex.enterprise.licensing.manage`

### RBAC Permissions (Registry-first)
- `neonex.enterprise.licensing.view`
- `neonex.enterprise.licensing.manage`

### Routes (Suggested)

**Admin Web (SSR)**
- `GET /admin/enterprise/licensing` → `scale.licensing.index`
- `POST /admin/enterprise/licensing/activate` → `scale.licensing.activate`
- `POST /admin/enterprise/licensing/deactivate` → `scale.licensing.deactivate`
- `POST /admin/enterprise/licensing/refresh` → `scale.licensing.refresh`

**Enterprise API (Prefix บังคับ: `/enterprise/*`)**
- `POST /enterprise/licensing/validate` → `enterprise.licensing.validate`
- `POST /enterprise/licensing/activate` → `enterprise.licensing.activate`
- `GET /enterprise/licensing/claims` → `enterprise.licensing.claims`

### Implementation Checklist
1) เพิ่ม tables: `tenant_licenses`, `license_audit_events`
2) ทำ validator (offline-first เป็นค่าเริ่มต้น) + optional remote endpoint
3) ทำ claims cache + invalidation strategy
4) ทำ gating helpers เช่น `scale_enabled('whitelabel')`, `plan_limit('users')`
5) ทำ activation UI + audit trail ทุกครั้ง

### Exit Criteria
- ปิด license/claims แล้วเมนู enterprise ถูกซ่อน/ถูกกันจริง
- เปิด license แล้วฟีเจอร์ที่ claim อนุญาตทำงานได้ และจำกัดตาม plan ได้
- activation ทุกครั้งมี audit trail ตรวจย้อนหลังได้

---

## [Layer C] 📊 Phase 26: Super Admin Console (10-14h)

### Objective
เพิ่ม console สำหรับ super-admin ที่ intentionally cross-tenant เพื่อดูสถานะรวม + ทำ bulk actions แบบปลอดภัย

### In Scope
- Global tenant list + status/health
- Usage snapshots (ตามข้อมูลที่มีอยู่ในระบบ)
- Alerts (quota/health) แบบ baseline
- Bulk actions (suspend/activate/notify)

### Out of Scope
- Revenue จริง/การเงินจริง (ถ้า core ไม่มี billing ให้แสดงเป็น placeholder)

### Outputs
- Module `modules/Scale/SuperAdmin/*`
- Dashboard + exports

### Kernel Contracts/Services (ทำก่อน)
- `SuperAdminAuthorizationInterface` (กันไม่ให้ role ปกติหลุดเข้า)
- `TenantHealthServiceInterface`
- Permissions: `neonex.superadmin.access`

### RBAC Permissions (Registry-first)
- `neonex.superadmin.access`
- `neonex.superadmin.tenants.manage`

### Routes (Suggested)

**Admin Web (SSR)**
- `GET /admin/super` → `super.index`
- `GET /admin/super/tenants` → `super.tenants.index`
- `GET /admin/super/tenants/{tenant}` → `super.tenants.show`
- `POST /admin/super/tenants/{tenant}/suspend` → `super.tenants.suspend`
- `POST /admin/super/tenants/{tenant}/activate` → `super.tenants.activate`
- `POST /admin/super/tenants/{tenant}/notify` → `super.tenants.notify`
- `GET /admin/super/exports/tenants` → `super.exports.tenants`

**Enterprise API (Prefix บังคับ: `/enterprise/*`)**
- `GET /enterprise/super/tenants` → `enterprise.super.tenants.index`
- `POST /enterprise/super/tenants/{tenant}/suspend` → `enterprise.super.tenants.suspend`

### Implementation Checklist
1) นิยาม super-admin guard/role ให้ชัด (แยกจาก tenant roles)
2) สร้าง services สำหรับ aggregate metrics แบบ read-only
3) ทำ UI dashboard + table (ไม่ผูก DataTables baseline; ใช้เฉพาะหน้าได้ถ้าจำเป็น)
4) ทำ bulk actions ผ่าน action router + audit ทุก action
5) เพิ่ม export แบบ CSV/Excel (ตามของที่มีใน core)

### Exit Criteria
- ผู้ใช้ทั่วไปเข้า console ไม่ได้
- super-admin เห็น tenant list และทำ bulk action ได้ โดยมี audit record ครบ
- ไม่มี query ที่ทำให้ข้อมูล tenant A หลุดไป tenant B ในบริบทผู้ใช้ปกติ

---

## [Layer C] 🧰 Phase 27: Advanced Enterprise Tools (16-24h)

### Objective
เพิ่มเครื่องมือ enterprise ที่ “ต่อยอดจาก kernel/service patterns” โดยยังคุม scope ให้เป็น baseline ที่ขยายได้

### In Scope
- Custom fields engine (schema registry + apply to resources ที่กำหนด)
- Workflow automation แบบ rule/action (ขั้นต่ำ)
- Backup policy manager (เก็บ policy + schedule metadata)
- API builder (resource-level metadata; ไม่จำเป็นต้อง generate code จริงทั้งหมด)

### Out of Scope
- Visual editor ขั้นสูง
- Full BPMN/complex workflow engine

### Outputs
- Module `modules/Scale/EnterpriseTools/*`
- Registries: field schema registry + workflow registry

### Kernel Contracts/Services (ทำก่อน)
- `FieldSchemaRegistryInterface`
- `WorkflowRegistryInterface`
- `BackupPolicyServiceInterface`
- Permissions: `neonex.enterprise.tools.manage`

### RBAC Permissions (Registry-first)
- `neonex.enterprise.tools.view`
- `neonex.enterprise.tools.manage`

### Routes (Suggested)

**Admin Web (SSR)**
- `GET /admin/enterprise/tools` → `scale.tools.index`
- `GET /admin/enterprise/tools/fields` → `scale.tools.fields.index`
- `POST /admin/enterprise/tools/fields` → `scale.tools.fields.store`
- `PUT /admin/enterprise/tools/fields/{field}` → `scale.tools.fields.update`
- `DELETE /admin/enterprise/tools/fields/{field}` → `scale.tools.fields.destroy`
- `GET /admin/enterprise/tools/workflows` → `scale.tools.workflows.index`
- `POST /admin/enterprise/tools/workflows` → `scale.tools.workflows.store`
- `PUT /admin/enterprise/tools/workflows/{workflow}` → `scale.tools.workflows.update`
- `DELETE /admin/enterprise/tools/workflows/{workflow}` → `scale.tools.workflows.destroy`
- `GET /admin/enterprise/tools/backup-policies` → `scale.tools.backupPolicies.index`
- `POST /admin/enterprise/tools/backup-policies` → `scale.tools.backupPolicies.store`
- `PUT /admin/enterprise/tools/backup-policies/{policy}` → `scale.tools.backupPolicies.update`
- `DELETE /admin/enterprise/tools/backup-policies/{policy}` → `scale.tools.backupPolicies.destroy`

**Enterprise API (Prefix บังคับ: `/enterprise/*`)**
- `GET /enterprise/tools/fields` → `enterprise.tools.fields.index`
- `POST /enterprise/tools/fields` → `enterprise.tools.fields.store`

### Implementation Checklist
1) ทำ registry + storage schema สำหรับ fields/workflows/policies
2) ทำ validation rules และ tenant scoping
3) ทำ UI baseline สำหรับ CRUD ของ fields/workflows/policies
4) ผูก action router + audit-first ทุก action
5) เพิ่มตัวอย่าง integration อย่างน้อย 1 resource เพื่อพิสูจน์ pattern

### Exit Criteria
- สามารถสร้าง field schema และผูกกับ resource ตัวอย่างได้จริง (tenant-safe)
- สามารถสร้าง workflow rule/action แบบ baseline และมี log/audit ได้
- Backup policy สามารถ schedule metadata ได้ และไม่ทำให้ core พัง

---

## 💰 Packaging for Sale

### SKU Model
1. `Core` (ฟรี): Phase 0-21
2. `Scale Add-on` (เสียเงิน): Phase 22-27
3. Optional future packs: industry templates

### Technical Enforcement
- Add-on service provider registration key
- Feature flags by license claims
- UI hides locked enterprise menus

---

## ⏱️ Estimated Timeline

- Phase 22-26: 44-64 hours
- Phase 27: 16-24 hours
- **Total Add-on:** 60-88 hours (7.5-11 days)

---

## ✅ Exit Criteria

- Core ติดตั้งและทำงานได้โดยไม่ต้องมี add-on
- เมื่อติดตั้ง add-on แล้วเมนู enterprise โผล่อัตโนมัติ
- เปิด/ปิด add-on ได้ด้วย config + license
- ไม่มี coupling ข้าม boundary ที่ทำให้ core พัง

---

## 🔗 Integration Note

Core plan reference: `PROJECT_REBUILD_PLAN_BOOTSTRAP_JQUERY.md`  
This add-on is optional by design and can be shipped/sold independently.
