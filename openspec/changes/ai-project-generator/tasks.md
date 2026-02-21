## 1. UI Components Setup

- [x] 1.1 Create the UI view for the Project Generator form (Name, Description, DB type, DB credentials)
- [x] 1.2 Create the UI view for the Project Explorer page (two panes: file tree on the left, code preview on the right)
- [x] 1.3 Add responsive loading state components (e.g. spinners) for long-running scaffolding tasks

## 2. API & Controller Initialization

- [x] 2.1 Set up Laravel routes for `ProjectGeneratorController` (GET for forms, POST for scaffolding action)
- [x] 2.2 Set up Laravel routes for `ProjectExplorerController` (GET directory list, GET file content)
- [x] 2.3 Implement robust form request validation for the scaffolding payload (DB Type validation, sanitizing project name)

## 3. Core Scaffolding Backend

- [x] 3.1 Implement a `ScaffoldProjectService` to run `composer create-project` safely using `Symfony\Component\Process\Process`
- [x] 3.2 Ensure `ScaffoldProjectService` returns actionable status messages and prevents shell expansion vulnerabilities
- [x] 3.3 Set up a working error catch mechanism if scaffolding times out or composer is missing

## 4. Env Configuration Service

- [x] 4.1 Implement an `EnvGeneratorService` to locate the newly generated `.env` file
- [x] 4.2 Write the regex logic to safely find and overwrite `DB_CONNECTION`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in the `.env` string
- [x] 4.3 Inject user input into the regex replacer securely and save the updated `.env` file to disk

## 5. Web File Explorer API

- [x] 5.1 Implement a recursive function using `DirectoryIterator` to return the file tree structure of the generated project directory
- [x] 5.2 Implement file retrieval logic: check if the requested file falls perfectly within the generated project scope
- [x] 5.3 Return file content safely from the API, throwing 403 Forbidden on traversal attempts (e.g. `../`)

## 6. Frontend Integration

- [x] 6.1 Connect the "Generate" form submission to the scaffold API, and transition to the explorer page on success
- [x] 6.2 Render the JSON directory tree in the Web File Explorer UI using recursive nested Blade or Alpine.js components
- [x] 6.3 Implement click handlers on files in the tree to fetch their contents via AJAX and render inside the UI code preview block
