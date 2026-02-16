# 🎨 Theme Polish — Copilot Rules (STRICT)

## ❗ SCOPE: UI/CSS/Blade ONLY — ห้ามแตะ Logic

งานนี้คือ "แต่งหน้าตา" Limitless theme + เพิ่ม DataTables per-page เท่านั้น

---

## ✅ ทำได้ (SAFE):

1. แก้ไฟล์ใน `resources/themes/limitless/layouts/` (CSS, HTML structure)
2. แก้ไฟล์ใน `resources/views/` เฉพาะ Blade markup/CSS class (เช่น เปลี่ยน class, icon)
3. แก้ `resources/views/components/limitless/` (ปรับ component markup)
4. เพิ่ม DataTables per-page ด้วย `@push('scripts')` เฉพาะหน้า index
5. แก้ `config/theme.php` เฉพาะ asset paths (CSS/JS)
6. เพิ่ม CSS ใน `@push('styles')` หรือ style block ใน layout

---

## 🚫 ห้ามทำ (DANGER — จะทำลาย architecture):

1. ห้ามแก้ไฟล์ใน `app/` (Controllers, Services, Models, Contracts, Providers)
2. ห้ามแก้ `routes/` (web.php, admin.php, auth.php)
3. ห้ามแก้ `database/` (migrations, seeders)
4. ห้ามแก้ `bootstrap/app.php`
5. ห้ามลบ/เปลี่ยน `@extends(theme_view('layouts.app'))` — ทุก view ต้องเรียกผ่าน theme_view()
6. ห้ามลบ `@section('content')`, `@section('breadcrumb')`, `@push('scripts')`, `@push('styles')`
7. ห้ามลบ/เปลี่ยน `data-action="..."` ใน Blade (jQuery action router)
8. ห้ามลบ CSRF meta tag, `auth()->user()->canDo()` checks, `tenant_id()` calls
9. ห้ามติดตั้ง npm packages หรือ build tools
10. ห้ามเปลี่ยน `<x-limitless::card>` เป็น syntax อื่น

---

## 📁 Key Files Reference:

| ไฟล์ | หน้าที่ |
|---|---|
| `resources/themes/limitless/layouts/app.blade.php` | Main layout (แก้ได้) |
| `resources/themes/limitless/layouts/auth.blade.php` | Login layout (แก้ได้) |
| `resources/themes/limitless/layouts/components/sidebar.blade.php` | Sidebar (แก้ได้เฉพาะ markup) |
| `resources/themes/limitless/layouts/components/sidebar-tree.blade.php` | Recursive menu (แก้ได้เฉพาะ markup) |
| `resources/themes/limitless/layouts/components/header.blade.php` | Header + breadcrumb (แก้ได้) |
| `resources/themes/limitless/layouts/components/footer.blade.php` | Footer (แก้ได้) |
| `resources/views/components/limitless/card.blade.php` | Card component (แก้ได้) |
| `resources/views/components/limitless/modal.blade.php` | Modal component (แก้ได้) |
| `resources/views/components/limitless/form-group.blade.php` | Form group component (แก้ได้) |
| `config/theme.php` | Theme asset config (แก้ได้เฉพาะ asset paths) |
| `themes/limitless/layout.blade.php` | **Original** Limitless template (อ่านเป็น reference) |
| `themes/limitless/header.blade.php` | **Original** header (อ่านเป็น reference) |
| `themes/limitless/main_sidebar.blade.php` | **Original** sidebar (อ่านเป็น reference) |
| `themes/limitless/footer.blade.php` | **Original** footer (อ่านเป็น reference) |
| `public/themes/limitless/assets/` | Limitless CSS/JS/Icons (junction → themes/limitless/) |

### View ที่ต้อง polish:

| View file | หน้า |
|---|---|
| `resources/views/dashboard/index.blade.php` | Dashboard |
| `resources/views/users/index.blade.php` | Users list |
| `resources/views/users/create.blade.php` | Create user form |
| `resources/views/users/edit.blade.php` | Edit user form |
| `resources/views/admin/product/index.blade.php` | Products list |
| `resources/views/admin/product/create.blade.php` | Create product form |
| `resources/views/admin/product/edit.blade.php` | Edit product form |
| `resources/views/admin/menu/index.blade.php` | Menu builder |
| `resources/views/admin/menu/_item-row.blade.php` | Menu item row |
| `resources/views/auth/login.blade.php` | Login page |

---

## 📐 Patterns to PRESERVE (ห้ามลบ/เปลี่ยน):

```blade
{{-- ทุก view ต้องเริ่มด้วย --}}
@extends(theme_view('layouts.app'))

{{-- Breadcrumb section --}}
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
    <span class="breadcrumb-item active">Page Name</span>
@endsection

{{-- Content section --}}
@section('content')
    ...
@endsection

{{-- Per-page CSS --}}
@push('styles')
<style>...</style>
@endpush

{{-- Per-page JS --}}
@push('scripts')
<script>...</script>
@endpush
```

### Component syntax (ห้ามเปลี่ยน):

```blade
<x-limitless::card title="Title">
    content here
</x-limitless::card>

<x-limitless::card>
    <x-slot:header>Custom header</x-slot:header>
    content
    <x-slot:footer>Footer</x-slot:footer>
</x-limitless::card>

<x-limitless::modal id="myModal" title="Title" size="lg">
    content
    <x-slot:footer>buttons</x-slot:footer>
</x-limitless::modal>

<x-limitless::form-group label="Field" name="field_name" required>
    <input type="text" class="form-control" name="field_name">
</x-limitless::form-group>
```

### jQuery action router (ห้ามลบ):

```javascript
// Pattern 1: registerAction (Phase 0-3 style)
registerAction('delete-user', function($element) {
    // ...
});

// Pattern 2: direct delegation (Phase 7+ style)
$(document).on('click', '[data-action="delete-item"]', function(e) {
    // ...
});
```

### Layout assets (ห้ามเปลี่ยน):

```blade
{{-- ใน layout head --}}
{!! render_theme_assets('css') !!}
@stack('styles')

{{-- ใน layout body end --}}
{!! render_theme_assets('js') !!}
@stack('scripts')
```

---

## 🎯 DataTables Integration (Per-page ONLY)

### วิธีเพิ่ม DataTables ในหน้า index:

ใช้ Limitless built-in DataTables (มีอยู่แล้วใน assets):

```blade
@push('styles')
{{-- Limitless DataTables CSS (ถ้าจำเป็น) --}}
@endpush

@push('scripts')
{{-- Limitless DataTables JS --}}
<script src="{{ theme_asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
<script>
$(function() {
    $('.datatable').DataTable({
        pageLength: 25,
        order: [[0, 'desc']],
        language: {
            search: '',
            searchPlaceholder: 'Search...',
        }
    });
});
</script>
@endpush
```

หรือใช้ CDN:

```blade
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.min.js"></script>
<script>
$(function() {
    $('.datatable').DataTable({ ... });
});
</script>
@endpush
```

### กฎ DataTables:

- **แต่ละหน้า load เอง** ผ่าน `@push('scripts')` — ห้ามใส่ใน layout
- เพิ่ม class `datatable` ให้ `<table>` ที่ต้องการ
- ไม่ต้องลบ server-side pagination ที่มีอยู่ (อาจใช้คู่กันได้)
- ห้ามทำ DataTables เป็น global dependency

---

## 🏗️ Architecture Context (อ่านเฉยๆ ห้ามแก้):

- **Framework:** Laravel 12 + Bootstrap 5 + jQuery (NO npm build)
- **Tenant-aware:** ทุก query scope ด้วย `tenant_id` — ห้ามลบ
- **RBAC:** registry-first — `PermissionSeeder` เป็น single source of truth
- **Audit:** `audit()->record()` บน CRUD operations — ห้ามลบ
- **Theme adapter:** `theme_view()`, `theme_asset()`, `render_theme_assets()`
- **Menu from DB:** Sidebar renders จาก `MenuService` — ห้ามแก้ logic
- **Icons:** Phosphor `ph-*` classes (Limitless standard)
- **Active theme:** `APP_THEME=limitless` ใน `.env`

---

## 🔍 Checklist ก่อน Commit:

```bash
# 1. ดูว่าแก้ไฟล์อะไรบ้าง
git diff --stat

# 2. ตรวจว่าไม่มีไฟล์ใน app/, routes/, database/
git diff --name-only | Select-String "^(app/|routes/|database/|bootstrap/)"
# ถ้ามี output = มีปัญหา! ต้อง revert

# 3. ตรวจว่าไม่ได้ลบ logic สำคัญ
git diff | Select-String "(canDo|tenant_id|audit\(\)|theme_view|data-action)"
# ถ้ามี "-" (ลบ) ในบรรทัดเหล่านี้ = ต้องตรวจสอบ

# 4. Test
# เปิด http://neonexadminplatform.test/dashboard ดูว่าทำงานปกติ
# เปิด http://neonexadminplatform.test/users ดูว่า DataTables ทำงาน
# เปิด http://neonexadminplatform.test/admin/menu ดูว่า menu builder ยังใช้ได้
```

---

## 📝 ตัวอย่าง Prompt สำหรับ Copilot:

### Polish layout:
> "ปรับ `resources/themes/limitless/layouts/app.blade.php` ให้ CSS classes ตรงกับ `themes/limitless/layout.blade.php` (original) แต่ห้ามลบ render_theme_assets, @stack, @include, @yield ที่มีอยู่"

### เพิ่ม DataTables:
> "เพิ่ม DataTables ให้ `resources/views/users/index.blade.php` โดยใช้ @push('scripts') load CDN แล้ว init บน table ที่มีอยู่ ห้ามลบ canDo checks, data-action, หรือ AJAX delete logic"

### แก้ Icons:
> "เปลี่ยน icon class จาก bi-* (Bootstrap Icons) เป็น ph-* (Phosphor Icons) ในไฟล์ views ทั้งหมด ห้ามแก้ไฟล์ใน app/ หรือ routes/"
