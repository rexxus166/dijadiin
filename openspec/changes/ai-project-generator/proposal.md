## Why

Untuk mempercepat inisiasi proyek software development di lingkungan lokal / cloud, dibutuhkan sebuah sistem generator proyek ("AI Builder" / "Code-as-a-Service"). Sistem ini akan menghapus proses copy-paste boilerplate secara manual sehingga developer atau user dapat langsung memilih tech-stack (khususnya database relasional), mengisi credential environment, dan otomatis mendapatkan kerangka proyek Laravel clean version yang siap untuk dikerjakan. Ini membuat inisiasi proyek jauh lebih efisien dan modern layaknya AI Builder.

## What Changes

- Menambahkan halaman UI "Project Generator" dengan form untuk:
  - Nama Proyek.
  - Deskripsi Proyek.
  - Pilihan Database (MySQL, PostgreSQL, atau opsi lain).
  - Khusus untuk MySQL/PGSQL: Input untuk konfigurasi credential Database (DB Name, Username, Password).
- Mengintegrasikan proses CLI/Bash script di *backend* untuk melakukan scaffolding proyek Laravel secara otomatis.
- Menambahkan logika untuk melakukan overwrite secara dinamis pada file `.env` di dalam root direktori hasil scaffold menyesuaikan isian payload dari user.
- Membangun UI File Explorer (menyerupai VS Code) yang mampu membaca dan menampilkan struktur folder *project* yang baru di-generate.
- Menambahkan kapabilitas di UI File Explorer untuk membaca/pratinjau isi kode dalam file proyek.

## Capabilities

### New Capabilities
- `project-scaffolding`: Fitur backend utama untuk melakukan instruksi shell creation kerangka proyek Laravel otomatis.
- `env-generator`: Fitur backend *parser/writer* khusus untuk memanipulasi parameter konfigurasi `.env` terkait database.
- `web-file-explorer`: UI frontend komprehensif yang menampilkan direktori tree dan mampu melakukan pratinjau terhadap isi file.

### Modified Capabilities
- 

## Impact

- **UI/Frontend:** Memerlukan pembuatan set komponen View/Blade baru untuk halaman Generator Form dan UI File Explorer.
- **Backend/API:** Butuh controller khusus yang dapat menjalankan `Process` atau shell command di background server (mungkin diperlukan penyesuaian fungsi exec/shell_exec php terkait environment local).
- **FileSystem:** Aplikasi membutuhkan permission read & write penuh ke dalam disk (workspace path) yang menampung file generasi project baru.
