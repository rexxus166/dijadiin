## Technical Decisions

### Real-Time Terminal (Server-Sent Events)
- **Problem**: Long-running `composer create-project` requests time out on standard PHP execution over HTTP, and users aren't visually aware of background execution dynamics.
- **Decision**: Rather than using a queue worker or polling via database, we'll leverage `Symfony\Component\HttpFoundation\StreamedResponse` natively available in Laravel. The controller will spawn `Symfony\Component\Process\Process` and use its callback `run(function($type, $buffer))` to iterate output and `echo` data flushed right to the open HTTP connection as Server-Sent Events (SSE). 
- **Rationale**: Minimal infrastructure dependencies. Works well with Javascript `EventSource` on the frontend side. Simple yet highly effective for one-off build processes.

### Gemini Agent Architecture
- **Decision**: The browser (Explorer UI) submits the current code content of the viewer and a user text prompt to a new Laravel endpoint `POST /api/gemini/chat`. It uses PHP CURL/Guzzle to hit the Gemini REST API `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-lite:generateContent`. 
- **Structure**: The Gemini API structured prompt will instruct it to return **only** raw code or a markdown JSON. We will parse the returned code string and send it to the frontend.

### Diff Viewer Strategy
- **Decision**: Build a side-by-side or stacked HTML diff viewer in Javascript. A simple string diff algorithm is complex to write manually, but we can utilize a lightweight approach: The AI returns the fully modified file. We present the Original and Modified versions side-by-side in HTML (`<pre>`) using CSS. When the user clicks "Accept Changes", the modified content string is dispatched via PUT to update the actual internal file.
- **Rationale**: Best combination of speed, aesthetics, and user experience comparable to modern AI IDEs. We skip heavy generic JS diff libraries using a visual side-by-side split constraint for simplicity and impressiveness.

## Risks & Edge Cases
- **Buffer Output Buffering**: Many web servers like Nginx or PHP-FPM implement output buffering that breaks Server-Sent Events (SSE). To mitigate this, padding strings or header modifications (`X-Accel-Buffering: no`, `Cache-Control: no-cache`) will be critical.

## Capabilities Touched
- `realtime-terminal-log`: NEW
- `gemini-agent-chat`: NEW
- `diff-code-viewer`: NEW
- `project-scaffolding`: MODIFIED
- `web-file-explorer`: MODIFIED
