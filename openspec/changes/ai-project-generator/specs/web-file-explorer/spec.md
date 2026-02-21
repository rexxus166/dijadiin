## ADDED Requirements

### Requirement: Render Directory Tree
The system MUST provide an endpoint to list the contents of the generated project directory hierarchically.

#### Scenario: Opening File Explorer
- **WHEN** the user is viewing the generated project details
- **THEN** a recursive tree-view of the project files is displayed on the frontend UI

### Requirement: File Content Preview
The system MUST allow users to preview text-based file contents by clicking on them in the file explorer.

#### Scenario: Clicking on web.php
- **WHEN** a user clicks on a file like `routes/web.php`
- **THEN** the system fetches the file contents and displays it in a code viewer on the right side of the explorer

### Requirement: Prevent Path Traversal
The system MUST securely restrict the file explorer to only access files located within the root of the targeted project directory.

#### Scenario: Attempting to access ../../etc/passwd
- **WHEN** a malicious user tries to access out-of-bounds files through the API payload
- **THEN** the backend throws an error and rejects the request
