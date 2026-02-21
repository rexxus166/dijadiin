# Design: Editor Tabs & Auto Save

## Architecture

We are modifying a single view file `resources/views/page/generator/explorer.blade.php`.

The UI will transition from a single-file view to a multi-file buffer array in JavaScript.
State will be kept in a variable:
```javascript
let openFiles = []; // Array of object: { path, filename, content, savedContent, isDirty }
let activeFilePath = null;
```

When a user clicks a file in the tree, we either:
1. Fetch and open it as a new tab if it's not open.
2. Select its existing tab if it's already open.

When a user types into the textarea:
- Update `openFiles[activeIndex].content`.
- Check if "Auto Save" toggle is enabled. If yes, trigger a debounced save (e.g. 1000ms delay). Set `isDirty` if not Auto-Saved or while typing.

## Visual Design
- Tabs container: `<div class="flex overflow-x-auto bg-[#1a1a1a] border-b border-[#2d2d2d] custom-scrollbar">`
- Tab item: `<div class="px-3 py-1.5 flex items-center gap-2 cursor-pointer border-t-2">` Active gets `border-indigo-500 bg-[#1e1e1e]`, inactive gets `border-transparent bg-[#141414] hover:bg-[#1a1a1a]`.
- Instead of a massive save button, we have an options area to the right for "Auto Save" Toggle.

## UI/UX Flow
1. **Tabs Creation**:
   - The user clicks `composer.json` in the file tree. It loads as Tab 1.
   - The user clicks `package.json` in the file tree. It loads as Tab 2.
   - Clicking Tab 1 replaces the textarea content with `composer.json`'s content.
2. **Tab Closure**:
   - Each tab has a tiny "x" button. Clicking it removes the file from `openFiles`. If the closed file was active, the preceding tab becomes the active one.
3. **Auto Save Toggle**:
   - A toggle labelled "Auto Save" (default ON) will sit in a compact toolbar above the code.
   - If User types, after 1 second of inactivity, the `saveActiveFile()` function executes.
