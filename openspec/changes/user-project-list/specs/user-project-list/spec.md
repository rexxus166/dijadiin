## ADDED Requirements

### Requirement: User Ownership of Generated Projects

Each generated project MUST be associated with the authenticated user who created it.

#### Scenario: Project created via /ai-builder is owned by the logged-in user

- **WHEN** an authenticated user submits the project generation form at `/ai-builder`
- **THEN** the resulting `GeneratedProject` record is saved to the database with `user_id` set to the authenticated user's ID

#### Scenario: User cannot see projects of other users

- **WHEN** a user visits `/projects`
- **THEN** only projects where `user_id` matches their own ID are returned

---

### Requirement: My Projects List Page

The system MUST provide a `/projects` page that displays all projects belonging to the currently authenticated user.

#### Scenario: User has existing projects

- **WHEN** the user navigates to `/projects`
- **THEN** a grid of project cards is displayed, each showing: project name, description (truncated), db_type badge, created_at date, and action buttons (Open Explorer, Delete)

#### Scenario: User has no projects yet (empty state)

- **WHEN** the user navigates to `/projects` and has no projects
- **THEN** an empty state UI is shown with an illustration/icon, a message "Belum ada proyek", and a CTA button "Buat Proyek Pertama" that links to `/ai-builder`

---

### Requirement: Delete Project

The user MUST be able to delete their own projects.

#### Scenario: User deletes a project they own

- **WHEN** the user clicks "Delete" on a project card and confirms
- **THEN** the `GeneratedProject` record is soft-deleted from the DB and the directory at `path` is removed from disk (if it exists)

#### Scenario: User attempts to delete a project they don't own

- **WHEN** a DELETE request is made for a project ID that does not belong to the authenticated user
- **THEN** a 403 Forbidden response is returned

---

### Requirement: Consistent Dark Theme UI

The project list page MUST use the same dark theme (`bg-[#0f1115]`, `dark:bg-[#161b22]`) consistent with the existing app layout.
