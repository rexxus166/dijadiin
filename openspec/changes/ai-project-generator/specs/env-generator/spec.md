## ADDED Requirements

### Requirement: Generate DB Configuration in .env
The system MUST overwrite specific database credentials inside the newly scaffolded project's `.env` file according to the user input.

#### Scenario: Overwriting MySQL credentials
- **WHEN** user inputs DB Type "mysql", Name "jadiin", User "root", Pass ""
- **THEN** the system finds the `.env` file in the generated folder and replaces DB_CONNECTION, DB_DATABASE, DB_USERNAME, DB_PASSWORD with exact provided values using regex

#### Scenario: Retaining other .env values
- **WHEN** the system overwrites database variables
- **THEN** it MUST NOT alter the `APP_KEY`, `APP_URL`, or any other unrelated configuration lines inside the `.env` file

#### Scenario: No .env found
- **WHEN** the `.env` file is missing (e.g. scaffolding failed)
- **THEN** the env generator process fails gracefully and logs an error
