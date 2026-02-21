## ADDED Requirements

### Requirement: Interactive Chat Sidebar
The web file explorer page MUST possess an AI Chat sidebar component capable of sending context-aware prompts to the backend.

#### Scenario: Requesting AI to build a feature
- **WHEN** the user is viewing `routes/web.php` and types "Add an admin authentication route" in the Chat Sidebar
- **THEN** the backend sends the prompt + file content to the Gemini API and parses back the recommended code changes.
