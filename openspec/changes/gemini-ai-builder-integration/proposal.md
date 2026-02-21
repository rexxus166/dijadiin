## Why

Meskipun generator project baru saat ini sudah menjalankan `composer create-project` secara riil, namun proses HTTP konvensional membuat User Interface (UI) hanya "loading statik" (spinning wheel) dan berisiko mengalami *HTTP Timeout* (terutama untuk `composer` yang memakan waktu lama). Selain itu, kurang sensasi "riil" bagi user. Maka dari itu, diperlukan integrasi *streaming* (Real-Time Terminal Output) yang menampilkan proses bash secara asinkron dengan animasi yang mulus. Setelah project terbuat, user membutuhkan peran *Autonomous Agent* seperti Gemini untuk memanipulasi kode layaknya cursor/antigravity. Karena itu, sebuah UI Chat dan fitur perbandingan kode (*code diff*) perlu ditambahkan di halaman Project Viewer. 

## What Changes

- Mengubah arsitektur *Project Generation* dari HTTP POST synchronous menjadi berbasis `Server-Sent Events` (SSE), Polling, atau HTTP Streamer yang memompa output `Symfony/Process` CLI langsung ke frontend (UI Terminal Live Stream).
- Menambahkan desain **UI Terminal Output** teranimasi pada saat *Scaffolding* berjalan.
- Menambahkan Sidebar *Chatbox Gemini* pada halaman **Project Explorer** untuk memberikan prompt modifikasi AI terhadap project.
- Mengirimkan *source code file* ke API Gemini dan menerima respons berisi kode yang telah diedit/ter-update.
- Membuat komponen UI **Diff Viewer** yang interaktif; memungkinkan user melihat perbedaan rupa kode lama dan kode baru secara riil sebelum file sepenuhnya ditulis/overwritten, disertakan dengan animasi yang memanjakan mata.

## Capabilities

### New Capabilities
- `realtime-terminal-log`: Mekanisme SSE backend untuk mengirimkan stream text output bash process ke frontend *Project Generator*.
- `gemini-agent-chat`: Fitur front-end (side-panel) dan backend untuk menerima dan mengirim pesan prompt user beserta konteks file explorer ke API Gemini.
- `diff-code-viewer`: Komponen Editor UI (dengan library frontend sederhana atau tailwind murni) yang dapat me-*render* highlight / green-red difflinemen antara original code & edited code.

### Modified Capabilities
- `project-scaffolding`: Diubah logic eksekusinya dari blocking response ke background process/stream output. (Dibuat file delta-spec).
- `web-file-explorer`: Ditambahkan section chat AI dan diff mode.

## Impact

- **Frontend:** Memerlukan tambahan JS/Alpine/Vanilla untuk handling EventSource (SSE), streaming chat typing effect, dan merakit HTML elemen untuk diff logic.
- **Backend:** Membutuhkan controller berbasis `StreamedResponse` (Symfony), penambahan library koneksi Guzzle untuk hit ke Endpoint Gemini.
- **Environment:** Menginjeksi Token GEMINI_API_KEY secara default dari `.env` utama sistem AI Builder kita.
