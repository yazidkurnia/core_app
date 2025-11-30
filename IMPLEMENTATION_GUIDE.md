# Dashboard Implementation Guide

## 📋 Struktur Implementasi

Implementasi routing `/dashboard` ke `views/pages/adm_dashboard/index.blade.php` menggunakan pattern MVC (Model-View-Controller).

---

## 🗂️ File Structure

```
app/
└── Http/
    └── Controllers/
        └── DashboardController.php     # Controller untuk dashboard

routes/
└── web.php                             # File routing utama

resources/
└── views/
    ├── layouts/
    │   ├── master.blade.php            # Master layout
    │   └── partials/                   # Komponen reusable
    └── pages/
        └── adm_dashboard/
            └── index.blade.php         # Dashboard view
```

---

## 📝 Implementasi Detail

### 1. Controller (`app/Http/Controllers/DashboardController.php`)

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.adm_dashboard.index');
    }
}
```

**Penjelasan:**
- Method `index()` mengembalikan view `pages.adm_dashboard.index`
- Laravel akan mencari file di `resources/views/pages/adm_dashboard/index.blade.php`
- Notasi dot (`.`) digunakan untuk folder separator

---

### 2. Routes (`routes/web.php`)

```php
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');
```

**Penjelasan:**
- URL `/dashboard` akan dihandle oleh `DashboardController@index`
- Middleware `auth` memastikan hanya user yang login bisa akses
- Route name `dashboard` untuk referensi di blade: `route('dashboard')`

---

### 3. View (`resources/views/pages/adm_dashboard/index.blade.php`)

```blade
@extends('layouts.master')

@section('content')
    <!-- Dashboard content here -->
@endsection

@push('styles')
    <!-- Page specific CSS -->
@endpush

@push('scripts')
    <!-- Page specific JS -->
@endpush
```

**Struktur View:**
- Extends dari `layouts.master` untuk konsistensi layout
- `@section('content')` untuk isi halaman utama
- `@push('styles')` untuk CSS khusus halaman
- `@push('scripts')` untuk JavaScript khusus halaman

---

## 🚀 Cara Membuat Halaman Baru

### Langkah 1: Buat Controller

```bash
php artisan make:controller NamaController
```

### Langkah 2: Edit Controller

```php
public function index()
{
    return view('pages.nama_folder.index');
}
```

### Langkah 3: Tambah Route

```php
use App\Http\Controllers\NamaController;

Route::get('/url-path', [NamaController::class, 'index'])
    ->middleware(['auth'])
    ->name('route.name');
```

### Langkah 4: Buat View File

```
resources/views/pages/nama_folder/index.blade.php
```

---

## 🎯 Pattern yang Digunakan

### Naming Convention

1. **Controller**: PascalCase dengan suffix `Controller`
   - ✅ `DashboardController`
   - ✅ `UserController`
   - ❌ `dashboardController`

2. **Route Name**: snake_case atau dot notation
   - ✅ `dashboard`
   - ✅ `admin.users.index`
   - ❌ `DashboardIndex`

3. **View Path**: snake_case dengan folder structure
   - ✅ `pages.adm_dashboard.index`
   - ✅ `admin.users.create`
   - ❌ `pages/admDashboard/Index`

---

## 🔧 Advanced Implementation

### Passing Data ke View

```php
public function index()
{
    $users = User::all();
    $totalUsers = User::count();

    return view('pages.adm_dashboard.index', [
        'users' => $users,
        'totalUsers' => $totalUsers
    ]);
}
```

Atau menggunakan `compact()`:

```php
public function index()
{
    $users = User::all();
    $totalUsers = User::count();

    return view('pages.adm_dashboard.index', compact('users', 'totalUsers'));
}
```

### Menggunakan Data di View

```blade
<p>Total Users: {{ $totalUsers }}</p>

@foreach($users as $user)
    <p>{{ $user->name }}</p>
@endforeach
```

---

## 🛡️ Middleware Options

### Auth Middleware
```php
->middleware(['auth'])  // Hanya user login
```

### Multiple Middleware
```php
->middleware(['auth', 'verified'])  // Login + email verified
```

### Role-based Access
```php
->middleware(['auth', 'role:admin'])  // Hanya admin
->middleware(['auth', 'role:admin,manager'])  // Admin atau Manager
```

---

## 🔐 Role Middleware - Cara Penggunaan

### Setup (Sudah Dilakukan)
Role middleware sudah terdaftar di `app/Http/Kernel.php`:
```php
protected $routeMiddleware = [
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];
```

### Cara Memanfaatkan

#### 1. Di Routes (Cara Paling Umum)
```php
// Single role - hanya admin
Route::get('/admin/users', [UserController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('users.index');

// Multiple roles - admin atau manager
Route::post('/reports', [ReportController::class, 'store'])
    ->middleware(['auth', 'role:admin,manager'])
    ->name('reports.store');

// Grouped routes dengan role
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});
```

#### 2. Di Controller
```php
class AdminController extends Controller
{
    public function __construct()
    {
        // Terapkan role middleware ke semua method
        $this->middleware('role:admin');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
```

#### 3. Di Controller untuk Method Tertentu
```php
class UserController extends Controller
{
    public function __construct()
    {
        // Hanya method 'destroy' dan 'delete' yang butuh role admin
        $this->middleware('role:admin')->only(['destroy', 'delete']);
    }

    public function index()
    {
        return view('users.index');  // Accessible tanpa role check
    }

    public function destroy($id)
    {
        User::destroy($id);  // Hanya admin bisa akses
    }
}
```

### Contoh Implementasi Lengkap

#### Routes dengan Role (routes/web.php)
```php
Route::middleware(['auth'])->group(function () {
    // Dashboard - semua user login bisa akses
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Admin routes - hanya role admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
        Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);
    });

    // Manager routes - admin atau manager
    Route::middleware('role:admin,manager')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::post('/reports', [ReportController::class, 'store']);
    });
});
```

### Error Handling
Ketika user tidak memiliki role yang diizinkan, middleware akan return:
- **Status Code**: 403 (Forbidden)
- **Pesan**: "Unauthorized action. You do not have permission to access this page."

Jika user belum login:
- **Redirect** ke halaman login dengan pesan: "Anda belum login..."

### Notes Penting
1. Role diambil dari field `linked_type` di tabel users (case-insensitive)
2. Support multiple roles dengan separator koma: `role:admin,manager,supervisor`
3. Harus digunakan setelah middleware `auth`
4. Middleware akan stop eksekusi jika user tidak punya role

---

## 🔍 Debugging

### Cek Route Terdaftar
```bash
php artisan route:list
php artisan route:list --name=dashboard
```

### Cek Controller Exists
```bash
php artisan route:list | grep DashboardController
```

### Clear Cache
```bash
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

---

## ✅ Testing

### Manual Test
1. Login ke aplikasi
2. Akses URL: `http://localhost:8000/dashboard`
3. Verifikasi view ditampilkan dengan benar

### Route Test
```bash
php artisan route:list --name=dashboard
# Output: GET|HEAD dashboard ... DashboardController@index
```

---

## 📚 Best Practices

1. **Gunakan Controller** untuk logic, bukan closure di route
2. **Naming Consistency** untuk mudah maintenance
3. **Middleware** untuk security
4. **Resource Controllers** untuk CRUD operations
5. **View Partials** untuk reusable components
6. **Comments** di code untuk dokumentasi

---

## 🎨 Contoh Resource Controller (CRUD Lengkap)

```php
// Generate resource controller
php artisan make:controller UserController --resource

// Route resource
Route::resource('users', UserController::class)
    ->middleware(['auth']);

// Menghasilkan routes:
// GET    /users          -> index
// GET    /users/create   -> create
// POST   /users          -> store
// GET    /users/{id}     -> show
// GET    /users/{id}/edit -> edit
// PUT    /users/{id}     -> update
// DELETE /users/{id}     -> destroy
```

---

## 📞 Troubleshooting

### Error: View not found
- Cek path view di controller
- Pastikan file exists di `resources/views/`
- Clear view cache: `php artisan view:clear`

### Error: Route not found
- Cek `routes/web.php`
- Clear route cache: `php artisan route:clear`
- Jalankan: `php artisan route:list`

### Error: Controller not found
- Cek namespace di route
- Pastikan `use App\Http\Controllers\ControllerName;`
- Jalankan: `composer dump-autoload`

---

**Dokumentasi dibuat pada:** {{ date('Y-m-d H:i:s') }}
