## ADDED Requirements

### Requirement: Scaffold New Laravel Project
The system MUST support scaffolding a new Laravel project in a designated directory using `composer create-project` or the Laravel installer when triggered.

#### Scenario: Successful project generation
- **WHEN** user submits the new project form with valid project name
- **THEN** the backend process creates a new folder with the sanitized project name and installs a clean Laravel skeleton

#### Scenario: Submitting invalid project name
- **WHEN** user submits the form with special characters not allowed in directory names
- **THEN** an error is returned and generation defaults to failing securely without touching the shell

### Requirement: Scaffolding Process Feedback
The system MUST provide feedback on the status of the background process, whether it succeeded or failed during scaffolding.

#### Scenario: Composer installation takes time
- **WHEN** the backend is running the scaffold shell command
- **THEN** the UI is kept informed of the loading state (e.g., polling or loading indicator) rather than crashing from HTTP timeout
