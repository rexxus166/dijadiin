## Why

User perlu melihat daftar proyek yang telah mereka generate melalui AI Builder. Saat ini, setelah user membuat proyek, tidak ada halaman yang menampilkan riwayat atau daftar proyek milik user tersebut. Fitur ini penting agar user dapat mengelola, membuka kembali file explorer, dan melacak proyek-proyek yang sudah dibuat — layaknya dashboard project pada platform seperti Vercel atau Railway.

## What Changes

- Menambahkan relasi `user_id` pada tabel `generated_projects` agar setiap proyek dimiliki oleh seorang user.
- Membangun halaman **"My Projects"** (`/projects`) dengan tampilan grid card yang menampilkan daftar proyek milik user yang sedang login.
- Setiap project card menampilkan: nama proyek, deskripsi, database type, tanggal dibuat, dan tombol aksi (Open Explorer, Delete).
- Menambahkan state **empty state** yang menarik ketika user belum memiliki proyek.
- Mengintegrasikan halaman ini sebagai landing page utama user setelah login (route `dashboard`).

## Capabilities

### New Capabilities

- `user-project-list`: Halaman daftar proyek user dengan card grid, empty state, dan aksi per-proyek.

### Modified Capabilities

- `generated_projects` migration: Tambah kolom `user_id` (foreign key ke `users`).
- `GeneratedProject` model: Tambah relasi `belongsTo(User::class)` dan scope untuk filter per-user.
- `ProjectGeneratorController`: Saat `store`, simpan `user_id` dari user yang sedang login.
- `page/projects/index.blade.php`: Rebuild halaman menjadi list project yang proper.

## Impact

- **Database:** Migrasi baru untuk menambah `user_id` pada `generated_projects`.
- **Backend:** Controller baru atau update `ProjectGeneratorController` untuk filter proyek berdasarkan user.
- **UI/Frontend:** Blade view baru untuk halaman list project dengan dark theme konsisten dengan design DIJADIIN.
