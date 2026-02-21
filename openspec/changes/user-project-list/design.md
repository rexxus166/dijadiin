## Context

Proposal ini membangun fitur "User Project List" — halaman `/projects` yang menjadi landing page utama user setelah login. Halaman ini menampilkan semua proyek yang telah dibuat user melalui `/ai-builder`. Saat ini `generated_projects` tidak memiliki `user_id`, sehingga proyek tidak ter-asosiasi ke user tertentu.

## Goals / Non-Goals

**Goals:**

- Tambah kolom `user_id` (foreign key) pada tabel `generated_projects` agar proyek dimiliki oleh user tertentu.
- Tampilkan daftar proyek user di `/projects` dalam bentuk card grid yang rapi dengan dark theme.
- Setiap card menampilkan: nama, deskripsi, db_type, tanggal dibuat, dan tombol aksi (Open Explorer, Delete).
- Tampilkan empty state yang menarik ketika user belum punya proyek, dengan CTA ke `/ai-builder`.
- Setelah user membuat proyek via `/ai-builder`, proyek otomatis ter-assign ke user yang sedang login.

**Non-Goals:**

- Fitur search/filter proyek (bisa dikerjakan di iterasi berikutnya).
- Sharing proyek antar user.
- Pagination (scope awal, bisa ditambah nanti).

## Decisions

**Decision 1: Relasi User ↔ GeneratedProject**

- _Choice_: Tambah kolom `user_id` via migration baru (bukan modify migration lama), dengan `nullable()` agar data lama tidak rusak.
- _Rationale_: Aman untuk data yang sudah ada. `nullable` di-follow dengan scope `where('user_id', auth()->id())` saat query.

**Decision 2: Controller**

- _Choice_: Buat `ProjectController` khusus untuk list & delete. `ProjectGeneratorController::store()` yang sudah ada cukup ditambah `user_id` saat insert ke DB.
- _Rationale_: SRP — pisahkan concern "generate" dari "manage list".

**Decision 3: Simpan record ke DB saat generate**

- _Choice_: Setelah scaffold berhasil, simpan record `GeneratedProject` (name, description, db_type, path, user_id) ke database.
- _Rationale_: Saat ini `ProjectGeneratorController::store()` tidak menyimpan ke DB sama sekali — ini harus diperbaiki agar list projects bisa diisi.

**Decision 4: UI dark theme**

- _Choice_: Blade view dengan Tailwind dark classes, konsisten dengan design DIJADIIN yang sudah ada.
- _Rationale_: Consistency dengan sidebar dan app layout yang sudah dark.

## Risks / Trade-offs

- **[Risk] Data lama tanpa user_id** → **Mitigation**: Kolom nullable, query di-filter `whereNotNull('user_id')->where('user_id', auth()->id())`.
- **[Risk] Delete proyek files di disk** → **Mitigation**: Scope delete hanya untuk proyek milik user sendiri, dan hapus directory di storage jika ada.

## Migration Plan

1. Buat migration baru: `add_user_id_to_generated_projects_table` — tambah `user_id` nullable dengan foreign key ke `users`.
2. Update `GeneratedProject` model: tambah relasi `belongsTo(User)`, tambah fillable `user_id`.
3. Update `ProjectGeneratorController::store()`: simpan `GeneratedProject` record setelah scaffold sukses, set `user_id`.
4. Buat `ProjectController` dengan method `index()` (list) dan `destroy()` (delete).
5. Update route `/projects` untuk pakai `ProjectController@index`.
6. Rebuild `page/projects/index.blade.php` dengan card grid + empty state.

## Open Questions

- Apakah delete proyek juga hapus file di disk? → Scope awal: ya, hapus directory jika ada.
