## 1. Real-Time Terminal Controller Setup

- [x] 1.1 Create `ProjectStreamController` with a `stream` GET method returning a `StreamedResponse`.
- [x] 1.2 Move `ScaffoldProjectService` logic heavily inside the `StreamedResponse` closure to flush data iteratively using `$process->run(function ($type, $buffer){...})`.
- [x] 1.3 Ensure appropriate SSE headers (`Content-Type: text/event-stream`, `X-Accel-Buffering: no`) are set to prevent buffering.

## 2. Terminal UI (Frontend Updates)

- [x] 2.1 Update `index.blade.php` to initiate `new EventSource()` pointing to the streaming endpoint upon Form submission.
- [x] 2.2 Add dynamic CSS animations to the terminal pane to render text block lines auto-scrolling accurately.
- [x] 2.3 Stop the SSE listener dynamically upon receiving the "DONE" trigger event and auto-redirect to the project explorer.

## 3. Gemini API Client Backend

- [x] 3.1 Create `GeminiService` using Laravel `Http` facade to connect to Google Generative Language API endpoint `generateContent`.
- [x] 3.2 Add Laravel controller `GeminiChatController` that acts as a proxy for sending current `file_content` and `user_prompt` to the model.
- [x] 3.3 Ensure the prompt explicitly instructs Gemini to output only the fully updated code snippet without conversational padding.

## 4. UI Chat Integration & Code Diffs

- [x] 4.1 Update `explorer.blade.php` to include a beautiful, modern Chat interface sidebar floating or snapped to the right of the code preview.
- [x] 4.2 Wire the chat UI input box. Upon hitting "Send", trigger loading animation and contact the new `GeminiChatController`.
- [x] 4.3 Replace the old Code Viewer div with a side-by-side (Original ↔ Agent Proposed) layout conditionally visible when a diff arrives.
- [x] 4.4 Add "Accept Changes" and "Reject" floating buttons for the proposed diff.
- [x] 4.5 Create an API endpoint `POST /project/{name}/save-file` to actually overwrite the physical file when "Accept" is triggered.
