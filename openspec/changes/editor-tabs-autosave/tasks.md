# Tasks

## 1. UI Structure Update
- [x] 1.1 In `explorer.blade.php`, remove the static `#active-file-name` and the Save Button from the editor's header.
- [x] 1.2 Add an `#editor-tabs-container` that spans horizontally containing tabs.
- [x] 1.3 Add an "Auto Save" toggle switch at the right side of the tabs container. Remove the "Save" button and the Ctrl+S logic (or redirect it if kept).

## 2. JavaScript State Management
- [x] 2.1 Add an `openFiles` array and `activeFilePath` string.
- [x] 2.2 Update `loadFile(path)` to check if the file is in `openFiles`. If yes, set it as `activeFilePath` and render tabs.
- [x] 2.3 If not in `openFiles`, fetch the content from the API, add it to `openFiles`, make it active, and render the tabs.
- [x] 2.4 Add `switchTab(path)` function to switch the textarea content.
- [x] 2.5 Add `closeTab(path, event)` function.

## 3. Auto Save Logic
- [x] 3.1 Listen to `input` event on the textarea.
- [x] 3.2 Update `openFiles[activeIndex].content` on input.
- [x] 3.3 Create a debounced save function using `setTimeout` (1000ms delay). Only fire if the "Auto Save" toggle is checked.
- [x] 3.4 Ensure `saveActiveFile()` functions cleanly and quietly (maybe show a subtle saving indicator instead of alerts).
