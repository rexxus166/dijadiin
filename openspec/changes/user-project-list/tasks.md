## 1. Database Migration

- [x] 1.1 Buat migration `add_user_id_to_generated_projects_table` — tambah kolom `user_id` (unsignedBigInteger, nullable, foreign key ke `users.id`, onDelete cascade)

## 2. Model Update

- [x] 2.1 Update `GeneratedProject` model: tambah `user_id` ke `$fillable`, tambah relasi `belongsTo(User::class)`
- [x] 2.2 Update `User` model: tambah relasi `hasMany(GeneratedProject::class)`

## 3. Controller: ProjectGeneratorController (update store)

- [x] 3.1 Setelah scaffold dan env berhasil, simpan record `GeneratedProject` ke DB dengan field: `name`, `description`, `db_type`, `db_name`, `db_username`, `ai_prompt`, `path`, `user_id` (dari `auth()->id()`)

## 4. Controller: ProjectController (baru)

- [x] 4.1 Buat `app/Http/Controllers/ProjectController.php`
- [x] 4.2 Method `index()`: ambil semua project milik user (`GeneratedProject::where('user_id', auth()->id())->latest()->get()`), return view `page.projects.index` dengan data `$projects`
- [x] 4.3 Method `destroy(GeneratedProject $project)`: authorize user adalah pemilik, hapus directory di disk jika ada, hapus record DB, redirect back dengan pesan sukses

## 5. Routes Update

- [x] 5.1 Update route `/projects` di `web.php` untuk pakai `ProjectController@index`
- [x] 5.2 Tambah route DELETE `/projects/{project}` → `ProjectController@destroy` dengan name `projects.destroy`

## 6. View: page/projects/index.blade.php (rebuild)

- [x] 6.1 Rebuild view dengan dark theme — header "My Projects" + tombol "Buat Proyek Baru" (link ke `/ai-builder`)
- [x] 6.2 Buat card grid (3 kolom desktop, 1 kolom mobile) untuk setiap proyek:
    - Nama proyek (bold)
    - Deskripsi (truncated, max 2 baris)
    - Badge db_type (mysql = biru, pgsql = hijau, sqlite = abu)
    - Tanggal dibuat (format: "21 Feb 2026")
    - Tombol "Open Explorer" → route `project.explorer.index`
    - Tombol "Hapus" → form DELETE dengan konfirmasi
- [x] 6.3 Buat empty state: icon, teks "Belum ada proyek. Mulai buat proyek pertamamu!", tombol CTA "Buat Proyek Pertama" → `/ai-builder`

## 7. Sidebar Update

- [ ] 7.1 Pastikan sidebar link "My Projects" mengarah ke route `dashboard` (`/projects`) — sudah ada, verifikasi saja
