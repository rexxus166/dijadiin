# Proposal: Multi-tab & Auto-save Editor

## Problem to Solve
Currently, only one file can be opened at a time in the web editor, making cross-referencing files difficult. There's also a manual "Save" button to click or `Ctrl+S` required. An ideal modern editor experience allows multiple open tabs and has an Auto-Save toggle.

## Proposed Solution
- Modify the `explorer.blade.php` view.
- Convert the single file header into a scrollable, click-able tabbed navigation interface.
- Add an "Auto Save" toggle button that debounces saves automatically as the user types.
- Remove the manual "Save" button.

## Value Proposition
- Familiar developer experience (VSCode style).
- Prevent data loss by auto-saving.
- Seamless context-switching between different files.

## Scope
- Update `explorer.blade.php` DOM structural changes for tabs.
- Rewrite `loadFile` function in JS to manage state array of `openFiles`.
- Add auto-save toggle logic and debounced saving.

## Out of Scope
Complex file tree persistence or persistent open tabs after full page reloads.
