## ADDED Requirements

### Requirement: Stream CLI Process Output
The system MUST capture the standard output (`stdout`) and standard error (`stderr`) of the `composer create-project` bash process and stream it to the client using a real-time transport mechanism like Server-Sent Events (SSE).

#### Scenario: Real-time Terminal Feedback
- **WHEN** user initiates a project generation
- **THEN** the frontend receives text chunks sequentially identical to a terminal and renders them inside the UI loading state with smooth typing animations
