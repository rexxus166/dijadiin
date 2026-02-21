## Context

The proposal introduces the "AI Builder Project Generator," a web interface that automates the initialization of a clean Laravel project, complete with user-specified database credentials, and allows for exploring the newly created files via a web UI. Scaffolding dynamic projects on the server involves running system shell commands (like `composer create-project` or `laravel new`), parsing string content, dynamically recreating an `.env` file, and interacting intensively with the filesystem.

## Goals / Non-Goals

**Goals:**
- Provide a responsive UI form to collect Project Name, Description, Database Type, and Database credentials.
- Handle scaffolding of a fresh Laravel installation in a specified target directory (e.g., inside the main workspace, possibly a sub-folder).
- Safely update the newly generated `.env` file with the user-provided DB configuration without breaking the formatting.
- Implement a hierarchical Web File Explorer capable of walking the generated directory tree and returning file contents.

**Non-Goals:**
- Containerization or virtualization of the target project (e.g., Docker generation or custom VM). The generated project will simply live in a child folder of the disk.
- Live-code editing or complex LSP capabilities. The file explorer will primarily serve as a visual *read-only* indicator that the project was correctly scaffolded, though a simple text display works.
- Connecting to the DB dynamically in behalf of the generated project; we only scaffold the `.env` settings.

## Decisions

**Decision 1: Scaffolding Mechanism**
- *Choice*: Use PHP's `Symfony\Component\Process\Process` wrapper instead of plain `shell_exec()`.
- *Rationale*: `Process` provides much better stream handling, timeout configuration, escaping mechanisms, and real-time output feedback which is crucial since downloading packages with Composer might take several minutes.

**Decision 2: Env File Generation Strategy**
- *Choice*: Key-value regex replacement rather than fully appending.
- *Rationale*: Laravel's `artisan key:generate` configures `.env`. We can build a regex that finds existing `DB_*` keys and carefully replaces their values with exactly what the user inputted to ensure stability in the `.env` format.

**Decision 3: Web File Explorer Implementation**
- *Choice*: Create an API endpoint returning a recursive tree JSON using `DirectoryIterator`, avoiding symlinks.
- *Rationale*: It makes frontend rendering straightforward (using recursive Vue/Alpine/Blade UI components) and avoids recursive loops. We will limit the root of the explorer to the newly created project directory for security.

## Risks / Trade-offs

- **[Risk] Long processing times lead to HTTP Timeouts** -> **Mitigation**: Offload the actual setup process to a queued Job or return a Server-Sent Event (SSE) / Polling endpoint so the UI displays a loading state rather than a standard synchronous AJAX request timing out.
- **[Risk] Path Traversal in Web File Explorer** -> **Mitigation**: Strictly validate paths requested by the file explorer to ensure they never break out of the configured generated project directory (`str_starts_with(realpath($requested), realpath($projectRoot))`).
- **[Risk] Server Permissions** -> **Mitigation**: The web server user (e.g., `www-data` or laragon's apache/nginx user) must have adequate write permissions to the storage path where generated directories will be placed.

## Migration Plan

- No database tables need to be touched if we're not retaining the generated project metadata. *However*, we may want a simple `projects` table (Name, Path, Status) to remember what was generated. (Added an optional migration if needed).
- Ensure `composer` is available in the `$PATH` of the web server executing the `Process`.

## Open Questions

- Should the scaffolded project be zipped and served as a download, or strictly interacted with through the web interface?
- If generating multiple projects, do we store them universally inside `storage/app/projects/`?
