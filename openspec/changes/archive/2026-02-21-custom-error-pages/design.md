# Design: Custom Error Pages

## Architecture

We are leveraging Laravel's default error page overriding mechanism. By simply placing Blade views named after the HTTP status codes into `resources/views/errors/`, Laravel will automatically serve these custom templates in place of its default framework ones whenever `abort(403)` or a `NotFoundHttpException` occurs.

## Data Model
[None required]

## APIs / Controllers
[None required] — Handled automatically by the Laravel Kernel's Exception Handler.

## UI/UX Flow
### Visual Style
The theme must align with DIJADIIN. We will use a black background (`bg-[#080808]`), white text (`text-white`), and gradient text classes. Glowing `orb` elements will sit in the background to provide depth.

### Elements
1. **Centered Content Container**: The container will display the HTTP Status Code (e.g. 404) in large, bold, gradient typography.
2. **Descriptive Text**: E.g. "Halaman Tidak Ditemukan" (Page Not Found) or "Akses Ditolak" (Access Denied).
3. **Action Button**: A primary call-to-action to send the user back to the homepage (`/`) or their authenticated dashboard area (`/projects`).
